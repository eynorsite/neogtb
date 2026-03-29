<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;

class HomepagePage extends Page
{
    use WithFileUploads;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static string|\UnitEnum|null $navigationGroup = 'Mon site';

    protected static ?string $navigationLabel = 'Page d\'accueil';

    protected static ?string $title = 'Page d\'accueil — Hero';

    protected static ?string $slug = 'homepage';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.homepage';

    public string $badge = '';
    public string $subtitle = '';
    public string $title_text = '';
    public string $description = '';
    public string $cta_text = '';
    public string $cta_url = '';
    public string $cta2_text = '';
    public string $cta2_url = '';
    public string $image_alt = '';
    public string $current_image = '';
    public $hero_image = null;

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();

        if (! $admin) {
            return false;
        }

        return in_array($admin->role, ['superadmin', 'admin', 'editeur']);
    }

    protected function getJsonPath(): string
    {
        return base_path('../src/data/homepage.json');
    }

    public function mount(): void
    {
        $path = $this->getJsonPath();

        if (File::exists($path)) {
            $data = json_decode(File::get($path), true);
            $hero = $data['hero'] ?? [];

            $this->badge = $hero['badge'] ?? '';
            $this->subtitle = $hero['subtitle'] ?? '';
            $this->title_text = $hero['title'] ?? '';
            $this->description = $hero['description'] ?? '';
            $this->cta_text = $hero['cta_text'] ?? '';
            $this->cta_url = $hero['cta_url'] ?? '';
            $this->cta2_text = $hero['cta2_text'] ?? '';
            $this->cta2_url = $hero['cta2_url'] ?? '';
            $this->image_alt = $hero['image_alt'] ?? '';
            $this->current_image = $hero['image'] ?? '';
        }
    }

    public function updatedHeroImage(): void
    {
        $this->validate([
            'hero_image' => 'image|max:10240',
        ]);
    }

    public function save(): void
    {
        $path = $this->getJsonPath();
        $imagePath = $this->current_image;

        if ($this->hero_image) {
            $extension = $this->hero_image->getClientOriginalExtension();
            $filename = 'hero-neogtb-' . time() . '.' . $extension;
            $destination = base_path('../public/images');

            // Copier le fichier depuis le tmp Livewire vers le dossier public Astro
            copy($this->hero_image->getRealPath(), $destination . '/' . $filename);

            $imagePath = '/images/' . $filename;
            $this->current_image = $imagePath;
            $this->hero_image = null;
        }

        $data = [
            'hero' => [
                'image' => $imagePath,
                'image_alt' => $this->image_alt,
                'badge' => $this->badge,
                'subtitle' => $this->subtitle,
                'title' => $this->title_text,
                'description' => $this->description,
                'cta_text' => $this->cta_text,
                'cta_url' => $this->cta_url,
                'cta2_text' => $this->cta2_text,
                'cta2_url' => $this->cta2_url,
            ],
        ];

        File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        Notification::make()
            ->title('Page d\'accueil mise à jour')
            ->body('Les modifications du hero ont été enregistrées.')
            ->success()
            ->send();
    }
}
