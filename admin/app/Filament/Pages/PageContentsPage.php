<?php

namespace App\Filament\Pages;

use App\Models\PageContent;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PageContentsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Page d\'accueil';

    protected static ?string $title = 'Contenu des pages';

    protected static string|\UnitEnum|null $navigationGroup = 'Mon site';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.page-contents';

    public ?array $data = [];

    /**
     * Page order for tab sorting.
     */
    private array $pageOrder = [
        'accueil' => 1,
        'gtb' => 2,
        'gtc' => 3,
        'solutions' => 4,
        'reglementation' => 5,
        'audit' => 6,
        'contact' => 7,
        'about' => 8,
        'comparateur' => 9,
        'blog' => 10,
        'generateur-cee' => 11,
        'positionnement' => 12,
        'mentions-legales' => 20,
        'politique-de-confidentialite' => 21,
        'mes-droits-rgpd' => 22,
    ];

    private array $pageIcons = [
        'accueil' => 'heroicon-o-home',
        'gtb' => 'heroicon-o-cpu-chip',
        'gtc' => 'heroicon-o-computer-desktop',
        'solutions' => 'heroicon-o-wrench-screwdriver',
        'reglementation' => 'heroicon-o-scale',
        'audit' => 'heroicon-o-clipboard-document-check',
        'contact' => 'heroicon-o-envelope',
        'about' => 'heroicon-o-user-group',
        'comparateur' => 'heroicon-o-arrows-right-left',
        'mentions-legales' => 'heroicon-o-document-text',
        'politique-de-confidentialite' => 'heroicon-o-shield-check',
        'mes-droits-rgpd' => 'heroicon-o-shield-exclamation',
        'generateur-cee' => 'heroicon-o-calculator',
        'positionnement' => 'heroicon-o-map-pin',
        'blog' => 'heroicon-o-newspaper',
    ];

    public function mount(): void
    {
        $formData = [];

        $contents = PageContent::where('key', 'not like', '\_%')->get();

        foreach ($contents as $pc) {
            $formData["pc_{$pc->id}"] = $pc->value;
        }

        $this->form->fill($formData);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Tabs::make('Pages')
                    ->persistTabInQueryString()
                    ->tabs($this->buildTabs())
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    private function buildTabs(): array
    {
        $pages = PageContent::select('page')
            ->distinct()
            ->pluck('page')
            ->sort(function ($a, $b) {
                $orderA = $this->pageOrder[$a] ?? 99;
                $orderB = $this->pageOrder[$b] ?? 99;
                return $orderA <=> $orderB;
            })
            ->values();

        $tabs = [];

        foreach ($pages as $page) {
            // Count sections for badge
            $sectionCount = PageContent::where('page', $page)
                ->select('section')
                ->distinct()
                ->count();

            $tabs[] = Tab::make(ucfirst($page))
                ->icon($this->pageIcons[$page] ?? 'heroicon-o-document')
                ->badge($sectionCount . ' sections')
                ->schema($this->buildSectionsForPage($page));
        }

        return $tabs;
    }

    private function buildSectionsForPage(string $page): array
    {
        // Get brick names for section labels
        $brickNames = PageContent::where('page', $page)
            ->where('key', '_brick_name')
            ->pluck('value', 'section');

        $brickTypes = PageContent::where('page', $page)
            ->where('key', '_brick_type')
            ->pluck('value', 'section');

        // Get all sections in order
        $sections = PageContent::where('page', $page)
            ->select('section')
            ->distinct()
            ->orderBy('section')
            ->pluck('section');

        $result = [];

        foreach ($sections as $sectionKey) {
            $fields = $this->buildFieldsForSection($page, $sectionKey);

            if (empty($fields)) {
                continue;
            }

            // Build section label
            $brickName = $brickNames[$sectionKey] ?? null;
            $brickType = $brickTypes[$sectionKey] ?? null;
            $sectionLabel = $brickName ?: ($brickType ?: $sectionKey);

            $result[] = Section::make($sectionLabel)
                ->schema($fields)
                ->columns(2)
                ->collapsible()
                ->collapsed(true);
        }

        return $result;
    }

    private function buildFieldsForSection(string $page, string $sectionKey): array
    {
        $contents = PageContent::where('page', $page)
            ->where('section', $sectionKey)
            ->where('key', 'not like', '\_%')
            ->orderBy('id')
            ->get();

        // Separate settings from regular fields
        $regularFields = [];
        $settingFields = [];

        foreach ($contents as $pc) {
            $field = $this->buildField($pc);

            if ($field === null) {
                continue;
            }

            if (str_starts_with($pc->key, 'setting_')) {
                $settingFields[] = $field;
            } else {
                $regularFields[] = $field;
            }
        }

        // Add settings in a sub-section if any
        if (! empty($settingFields)) {
            $regularFields[] = Section::make('Paramètres')
                ->schema($settingFields)
                ->columns(2)
                ->collapsible()
                ->collapsed(true)
                ->icon('heroicon-o-cog-6-tooth');
        }

        return $regularFields;
    }

    private function buildField(PageContent $pc): mixed
    {
        $formKey = "pc_{$pc->id}";
        $label = $pc->label ?: ucfirst(str_replace(['_', '-'], ' ', $pc->key));

        return match ($pc->type) {
            'textarea' => Textarea::make($formKey)
                ->label($label)
                ->rows(3)
                ->columnSpanFull(),

            'boolean' => Toggle::make($formKey)
                ->label($label)
                ->formatStateUsing(fn ($state) => filter_var($state, FILTER_VALIDATE_BOOLEAN))
                ->dehydrateStateUsing(fn ($state) => $state ? '1' : '0'),

            'image' => TextInput::make($formKey)
                ->label($label)
                ->helperText('Chemin de l\'image')
                ->columnSpanFull(),

            'color' => ColorPicker::make($formKey)
                ->label($label),

            default => TextInput::make($formKey)
                ->label($label),
        };
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $pagesUpdated = [];

        foreach ($data as $formKey => $value) {
            if (! str_starts_with($formKey, 'pc_')) {
                continue;
            }

            $id = (int) substr($formKey, 3);

            PageContent::where('id', $id)->update(['value' => $value]);

            // Track pages for cache invalidation
            $pc = PageContent::find($id);
            if ($pc) {
                $pagesUpdated[$pc->page] = true;
            }
        }

        // Invalidate cache for updated pages
        foreach (array_keys($pagesUpdated) as $page) {
            PageContent::clearCache($page);
        }

        Notification::make()
            ->title('Contenu enregistré')
            ->body(count($pagesUpdated) . ' page(s) mise(s) à jour')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Enregistrer le contenu')
                ->submit('save')
                ->icon('heroicon-o-check'),
        ];
    }
}
