<?php

namespace App\Livewire;

use App\Filament\Bricks\BrickRegistry;
use App\Models\PageBrick;
use App\Models\SitePage;
use Livewire\Component;
use Livewire\WithFileUploads;

class BrickEditor extends Component
{
    use WithFileUploads;

    public SitePage $page;
    public array $bricks = [];
    public ?int $selectedBrickId = null;
    public array $editForm = [];
    public $imageUpload;
    public string $imageUploadField = '';

    public function mount(int $pageId): void
    {
        $this->page = SitePage::findOrFail($pageId);
        $this->loadBricks();
    }

    public function loadBricks(): void
    {
        $this->bricks = $this->page->bricks()
            ->orderBy('order')
            ->get()
            ->map(fn (PageBrick $b) => [
                'id' => $b->id,
                'type' => $b->brick_type,
                'name' => $b->brick_name,
                'content' => $b->content ?? [],
                'settings' => $b->settings ?? [],
                'visible' => $b->is_visible,
                'locked' => $b->is_locked,
            ])
            ->toArray();
    }

    public function selectBrick(int $id): void
    {
        $this->selectedBrickId = $id;
        $brick = collect($this->bricks)->firstWhere('id', $id);
        if ($brick) {
            $this->editForm = [
                'content' => $brick['content'],
                'settings' => $brick['settings'],
            ];
        }
    }

    public function addBrick(string $type): void
    {
        $def = BrickRegistry::get($type);
        if (!$def) return;

        $admin = auth()->guard('admin')->user();
        $order = count($this->bricks);

        $brick = PageBrick::create([
            'page_id' => $this->page->id,
            'brick_type' => $type,
            'brick_name' => $def->name(),
            'content' => $def->defaultContent(),
            'settings' => $def->defaultSettings(),
            'order' => $order,
            'is_visible' => true,
            'created_by' => $admin?->id,
            'updated_by' => $admin?->id,
        ]);

        $this->loadBricks();
        $this->selectBrick($brick->id);
        $this->dispatch('notify', message: 'Brick ajoutée : ' . $def->name());
    }

    public function saveBrick(): void
    {
        if (!$this->selectedBrickId) return;

        $brick = PageBrick::find($this->selectedBrickId);
        if (!$brick) return;

        $admin = auth()->guard('admin')->user();
        $brick->update([
            'content' => $this->editForm['content'] ?? $brick->content,
            'settings' => $this->editForm['settings'] ?? $brick->settings,
            'updated_by' => $admin?->id,
        ]);

        $this->loadBricks();
        $this->dispatch('notify', message: 'Brick enregistrée');
    }

    public function setImageField(string $field): void
    {
        $this->imageUploadField = $field;
    }

    public function updatedImageUpload(): void
    {
        if (!$this->imageUpload || !$this->selectedBrickId || !$this->imageUploadField) return;

        $path = $this->imageUpload->store('bricks', 'public');

        $brick = PageBrick::find($this->selectedBrickId);
        if ($brick) {
            $brickContent = $brick->content ?? [];
            $brickContent[$this->imageUploadField] = $path;
            $brick->update(['content' => $brickContent]);
            $this->loadBricks();
            $this->selectBrick($this->selectedBrickId);
        }

        $this->imageUpload = null;
        $this->imageUploadField = '';
        $this->dispatch('notify', message: 'Image uploadée');
    }

    public function toggleVisibility(int $id): void
    {
        $brick = PageBrick::find($id);
        if ($brick) {
            $brick->update(['is_visible' => !$brick->is_visible]);
            $this->loadBricks();
        }
    }

    public function deleteBrick(int $id): void
    {
        $brick = PageBrick::find($id);
        if ($brick && !$brick->is_locked) {
            $brick->delete();
            if ($this->selectedBrickId === $id) {
                $this->selectedBrickId = null;
                $this->editForm = [];
            }
            $this->loadBricks();
            $this->dispatch('notify', message: 'Brick supprimée');
        }
    }

    public function reorderBricks(array $orderedIds): void
    {
        foreach ($orderedIds as $position => $id) {
            PageBrick::where('id', $id)->update(['order' => $position]);
        }
        $this->loadBricks();
    }

    public function getSelectedBrick(): ?array
    {
        if (!$this->selectedBrickId) return null;
        return collect($this->bricks)->firstWhere('id', $this->selectedBrickId);
    }

    public function render()
    {
        return view('livewire.brick-editor', [
            'availableBricks' => BrickRegistry::byCategory(),
            'selectedBrick' => $this->getSelectedBrick(),
        ])->layout('livewire.layouts.brick-editor-layout');
    }
}
