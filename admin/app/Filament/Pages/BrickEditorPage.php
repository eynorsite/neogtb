<?php

namespace App\Filament\Pages;

use App\Filament\Bricks\BrickRegistry;
use App\Models\PageBrick;
use App\Models\SitePage;
use Filament\Forms\Components\Group;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class BrickEditorPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.pages.brick-editor';

    protected static ?string $title = 'Éditeur de page';

    protected static ?string $slug = 'pages/{pageId}/bricks';

    public ?SitePage $page = null;

    public array $bricks = [];

    public ?int $selectedBrickIndex = null;

    public ?int $selectedBrickId = null;

    public array $editingContent = [];

    public bool $showPreview = false;

    public bool $isPublishing = false;

    public function mount(int $pageId): void
    {
        $this->page = SitePage::findOrFail($pageId);
        $this->loadBricks();
    }

    public function getTitle(): string
    {
        return ($this->page->name ?? 'Page') . ' — Éditeur';
    }

    protected function loadBricks(): void
    {
        $this->bricks = $this->page->bricks()
            ->orderBy('order')
            ->get()
            ->map(fn (PageBrick $b) => [
                'id' => $b->id,
                'brick_type' => $b->brick_type,
                'brick_name' => $b->brick_name,
                'content' => $b->content ?? [],
                'settings' => $b->settings ?? [],
                'is_visible' => $b->is_visible,
                'is_locked' => $b->is_locked,
                'order' => $b->order,
            ])
            ->toArray();

        $this->bricks = array_values($this->bricks);
    }

    public function getBrickForm(): ?array
    {
        if ($this->selectedBrickIndex === null || !isset($this->bricks[$this->selectedBrickIndex])) {
            return null;
        }

        $brick = $this->bricks[$this->selectedBrickIndex];
        $brickDef = BrickRegistry::get($brick['brick_type']);

        return $brickDef?->schema() ?? [];
    }

    public function addBrick(string $type): void
    {
        $brickDef = BrickRegistry::get($type);
        if (!$brickDef) {
            return;
        }

        $order = count($this->bricks);
        $admin = auth()->guard('admin')->user();

        PageBrick::create([
            'page_id' => $this->page->id,
            'brick_type' => $type,
            'brick_name' => $brickDef->name(),
            'content' => $brickDef->defaultContent(),
            'settings' => $brickDef->defaultSettings(),
            'order' => $order,
            'is_visible' => true,
            'is_locked' => false,
            'created_by' => $admin?->id,
            'updated_by' => $admin?->id,
        ]);

        $this->loadBricks();
        $this->selectedBrickIndex = count($this->bricks) - 1;
        $this->editingContent = [
            'content' => $brickDef->defaultContent(),
            'settings' => $brickDef->defaultSettings(),
        ];

        Notification::make()->title('Brick ajoutée : ' . $brickDef->name())->success()->send();
    }

    public function selectBrick(int $index): void
    {
        if (!isset($this->bricks[$index])) {
            return;
        }

        $this->selectedBrickIndex = $index;
        $brick = $this->bricks[$index];
        $this->selectedBrickId = $brick['id'] ?? null;
        $this->editingContent = [
            'content' => $brick['content'] ?? [],
            'settings' => $brick['settings'] ?? [],
        ];
    }

    protected function updateBrickInState(int $brickId): void
    {
        $brick = PageBrick::find($brickId);
        if (!$brick) {
            return;
        }

        $payload = [
            'id' => $brick->id,
            'brick_type' => $brick->brick_type,
            'brick_name' => $brick->brick_name,
            'content' => $brick->content ?? [],
            'settings' => $brick->settings ?? [],
            'is_visible' => $brick->is_visible,
            'is_locked' => $brick->is_locked,
            'order' => $brick->order,
        ];

        foreach ($this->bricks as $i => $b) {
            if (($b['id'] ?? null) === $brickId) {
                $this->bricks[$i] = $payload;
                return;
            }
        }
    }

    public function autoSaveBrick(int $brickId, array $data): void
    {
        try {
            $brick = PageBrick::find($brickId);

            if (!$brick) {
                Notification::make()
                    ->title('Brick introuvable')
                    ->warning()
                    ->send();
                return;
            }

            if (array_key_exists('expected_version', $data)
                && isset($brick->version)
                && (int) $data['expected_version'] !== (int) $brick->version) {
                Notification::make()
                    ->title('Conflit : un autre onglet a modifié ce bloc. Recharger pour voir.')
                    ->warning()
                    ->send();
                return;
            }

            $admin = auth()->guard('admin')->user();

            $update = [
                'content' => $data['content'] ?? $brick->content,
                'settings' => $data['settings'] ?? $brick->settings,
                'updated_by' => $admin?->id,
            ];

            if (isset($brick->version)) {
                $update['version'] = (int) $brick->version + 1;
            }

            $brick->update($update);
            $brick->refresh();

            $this->updateBrickInState($brickId);

            if ($this->selectedBrickId === $brickId) {
                $this->editingContent = [
                    'content' => $brick->content ?? [],
                    'settings' => $brick->settings ?? [],
                ];
            }

            $this->dispatch('brick-saved', [
                'brickId' => $brickId,
                'version' => $brick->version ?? null,
                'savedAt' => now()->toIso8601String(),
            ]);
        } catch (\Throwable $e) {
            Log::error('autoSaveBrick failed', [
                'brickId' => $brickId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function renderBrickPreview(int $brickId): string
    {
        try {
            $brick = PageBrick::find($brickId);
            if (!$brick) {
                return '<div style="padding:1rem;border:1px solid #fca5a5;background:#fef2f2;color:#991b1b;border-radius:6px;font-family:sans-serif;">Brick introuvable (#' . $brickId . ')</div>';
            }

            $type = $brick->brick_type;

            return View::make("front.bricks.{$type}", [
                'brick' => $brick,
                'content' => $brick->content,
                'settings' => $brick->settings,
            ])->render();
        } catch (\Throwable $e) {
            Log::error('renderBrickPreview failed', [
                'brickId' => $brickId,
                'error' => $e->getMessage(),
            ]);

            return '<div style="padding:1rem;border:1px solid #fca5a5;background:#fef2f2;color:#991b1b;border-radius:6px;font-family:sans-serif;"><strong>Erreur de rendu</strong><br><span style="font-size:0.85em;">' . e($e->getMessage()) . '</span></div>';
        }
    }

    public function saveBrick(): void
    {
        $brick = null;
        if ($this->selectedBrickId !== null) {
            $brick = PageBrick::find($this->selectedBrickId);
        }

        if (!$brick && $this->selectedBrickIndex !== null && isset($this->bricks[$this->selectedBrickIndex])) {
            $brick = PageBrick::find($this->bricks[$this->selectedBrickIndex]['id']);
        }

        if (!$brick) {
            return;
        }

        $admin = auth()->guard('admin')->user();

        $brick->update([
            'content' => $this->editingContent['content'] ?? $brick->content,
            'settings' => $this->editingContent['settings'] ?? $brick->settings,
            'brick_name' => $this->editingContent['content']['titre']
                ?? $this->editingContent['content']['titre_section']
                ?? $brick->brick_name,
            'updated_by' => $admin?->id,
        ]);

        $this->loadBricks();

        if ($this->selectedBrickId !== null) {
            foreach ($this->bricks as $i => $b) {
                if (($b['id'] ?? null) === $this->selectedBrickId) {
                    $this->selectedBrickIndex = $i;
                    break;
                }
            }
        }

        Notification::make()->title('Enregistré')->success()->send();
    }

    public function publishPage(): void
    {
        // Avec l'archi Laravel-only, le front lit la DB en direct via PageController.
        // Plus besoin de rebuild Astro — la page est "publiée" dès le save.
        $this->isPublishing = true;

        Notification::make()
            ->title('Page publiée')
            ->body('Le site a été mis à jour avec vos modifications.')
            ->success()
            ->send();

        $this->isPublishing = false;
    }

    public function togglePreview(): void
    {
        $this->showPreview = !$this->showPreview;
    }

    public function toggleVisibility(int $index): void
    {
        if (!isset($this->bricks[$index])) {
            return;
        }

        $brickId = $this->bricks[$index]['id'];
        if ($this->selectedBrickId !== null && $this->selectedBrickId === $brickId) {
            // keep selection by id
        }
        $brick = PageBrick::find($brickId);
        if ($brick) {
            $brick->update(['is_visible' => !$brick->is_visible]);
            $this->loadBricks();
            if ($this->selectedBrickId !== null) {
                foreach ($this->bricks as $i => $b) {
                    if (($b['id'] ?? null) === $this->selectedBrickId) {
                        $this->selectedBrickIndex = $i;
                        break;
                    }
                }
            }
        }
    }

    public function moveBrick(int $index, string $direction): void
    {
        $targetIndex = $direction === 'up' ? $index - 1 : $index + 1;

        if ($targetIndex < 0 || $targetIndex >= count($this->bricks)) {
            return;
        }

        if ($this->bricks[$index]['is_locked'] || $this->bricks[$targetIndex]['is_locked']) {
            Notification::make()->title('Brick verrouillée')->warning()->send();
            return;
        }

        $brickA = PageBrick::find($this->bricks[$index]['id']);
        $brickB = PageBrick::find($this->bricks[$targetIndex]['id']);

        if ($brickA && $brickB) {
            $orderA = $brickA->order;
            $brickA->update(['order' => $brickB->order]);
            $brickB->update(['order' => $orderA]);
            $this->loadBricks();

            if ($this->selectedBrickIndex === $index) {
                $this->selectedBrickIndex = $targetIndex;
            }
        }
    }

    public function deleteBrick(int $index): void
    {
        if (!isset($this->bricks[$index])) {
            return;
        }

        if ($this->bricks[$index]['is_locked']) {
            Notification::make()->title('Impossible de supprimer une brick verrouillée')->danger()->send();
            return;
        }

        $brickId = $this->bricks[$index]['id'];
        $brick = PageBrick::find($brickId);
        if ($brick) {
            $brick->delete();
            if ($this->selectedBrickId === $brickId) {
                $this->selectedBrickId = null;
                $this->selectedBrickIndex = null;
                $this->editingContent = [];
            }
            $this->loadBricks();
            if ($this->selectedBrickId !== null) {
                $this->selectedBrickIndex = null;
                foreach ($this->bricks as $i => $b) {
                    if (($b['id'] ?? null) === $this->selectedBrickId) {
                        $this->selectedBrickIndex = $i;
                        break;
                    }
                }
            }
            Notification::make()->title('Brick supprimée')->success()->send();
        }
    }

    public function duplicateBrick(int $index): void
    {
        if (!isset($this->bricks[$index])) {
            return;
        }

        $source = PageBrick::find($this->bricks[$index]['id']);
        if (!$source) {
            return;
        }

        $admin = auth()->guard('admin')->user();

        PageBrick::create([
            'page_id' => $source->page_id,
            'brick_type' => $source->brick_type,
            'brick_name' => $source->brick_name . ' (copie)',
            'content' => $source->content,
            'settings' => $source->settings,
            'order' => $source->order + 1,
            'is_visible' => true,
            'is_locked' => false,
            'created_by' => $admin?->id,
            'updated_by' => $admin?->id,
        ]);

        $this->loadBricks();
        Notification::make()->title('Brick dupliquée')->success()->send();
    }

    public function getBrickDefinition(string $type): ?array
    {
        $def = BrickRegistry::get($type);
        if (!$def) {
            return null;
        }

        return [
            'name' => $def->name(),
            'icon' => $def->icon(),
            'description' => $def->description(),
        ];
    }

    public function reorderBricks(array $orderedIds): void
    {
        foreach ($orderedIds as $position => $brickId) {
            PageBrick::where('id', $brickId)->update(['order' => $position]);
        }

        $this->loadBricks();

        if ($this->selectedBrickId !== null) {
            $this->selectedBrickIndex = null;
            foreach ($this->bricks as $i => $b) {
                if (($b['id'] ?? null) === $this->selectedBrickId) {
                    $this->selectedBrickIndex = $i;
                    break;
                }
            }
        }
    }

    public function getAvailableBricksProperty(): array
    {
        return BrickRegistry::byCategory();
    }

    public function getPreviewUrlProperty(): string
    {
        $slug = $this->page->slug === 'index' ? '' : $this->page->slug;
        return 'https://neogtb.fr/' . $slug;
    }
}
