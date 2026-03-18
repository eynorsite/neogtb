<?php

namespace App\Filament\Pages;

use App\Filament\Bricks\BrickRegistry;
use App\Models\PageBrick;
use App\Models\SitePage;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class BrickEditorPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.pages.brick-editor';

    protected static ?string $title = 'Éditeur de bricks';

    protected static ?string $slug = 'pages/{pageId}/bricks';

    public ?SitePage $page = null;

    public array $bricks = [];

    public ?int $selectedBrickIndex = null;

    public array $editingContent = [];

    public function mount(int $pageId): void
    {
        $this->page = SitePage::findOrFail($pageId);

        $this->loadBricks();
    }

    public function getTitle(): string
    {
        return 'Bricks — ' . ($this->page->name ?? 'Page');
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

    public function addBrick(string $type): void
    {
        $brickDef = BrickRegistry::get($type);
        if (! $brickDef) {
            return;
        }

        $order = count($this->bricks);
        $admin = auth()->guard('admin')->user();

        $brick = PageBrick::create([
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
        $this->editingContent = array_merge(
            ['content' => $brickDef->defaultContent()],
            ['settings' => $brickDef->defaultSettings()]
        );

        Notification::make()->title('Brick ajoutée : ' . $brickDef->name())->success()->send();
    }

    public function selectBrick(int $index): void
    {
        if (! isset($this->bricks[$index])) {
            return;
        }

        $this->selectedBrickIndex = $index;
        $brick = $this->bricks[$index];
        $this->editingContent = [
            'content' => $brick['content'] ?? [],
            'settings' => $brick['settings'] ?? [],
        ];
    }

    public function saveBrick(): void
    {
        if ($this->selectedBrickIndex === null || ! isset($this->bricks[$this->selectedBrickIndex])) {
            return;
        }

        $brickData = $this->bricks[$this->selectedBrickIndex];
        $brick = PageBrick::find($brickData['id']);

        if (! $brick) {
            return;
        }

        $admin = auth()->guard('admin')->user();

        $brick->update([
            'content' => $this->editingContent['content'] ?? $brick->content,
            'settings' => $this->editingContent['settings'] ?? $brick->settings,
            'updated_by' => $admin?->id,
        ]);

        $this->loadBricks();

        Notification::make()->title('Brick enregistrée')->success()->send();
    }

    public function toggleVisibility(int $index): void
    {
        if (! isset($this->bricks[$index])) {
            return;
        }

        $brick = PageBrick::find($this->bricks[$index]['id']);
        if ($brick) {
            $brick->update(['is_visible' => ! $brick->is_visible]);
            $this->loadBricks();
        }
    }

    public function moveBrick(int $index, string $direction): void
    {
        $targetIndex = $direction === 'up' ? $index - 1 : $index + 1;

        if ($targetIndex < 0 || $targetIndex >= count($this->bricks)) {
            return;
        }

        // Check locked
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
        if (! isset($this->bricks[$index])) {
            return;
        }

        if ($this->bricks[$index]['is_locked']) {
            Notification::make()->title('Impossible de supprimer une brick verrouillée')->danger()->send();
            return;
        }

        $brick = PageBrick::find($this->bricks[$index]['id']);
        if ($brick) {
            $brick->delete();
            $this->selectedBrickIndex = null;
            $this->editingContent = [];
            $this->loadBricks();

            Notification::make()->title('Brick supprimée')->success()->send();
        }
    }

    public function getBrickDefinition(string $type): ?array
    {
        $def = BrickRegistry::get($type);
        if (! $def) {
            return null;
        }

        return [
            'name' => $def->name(),
            'icon' => $def->icon(),
            'description' => $def->description(),
        ];
    }

    public function getAvailableBricksProperty(): array
    {
        return BrickRegistry::byCategory();
    }
}
