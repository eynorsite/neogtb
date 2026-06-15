<?php

namespace App\Filament\Pages;

use App\Models\ContentRevision;
use App\Models\PageContent;
use App\Models\SitePage;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
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
use Illuminate\Support\Str;

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
        $this->loadFormData();
    }

    private function loadFormData(): void
    {
        $formData = [];

        // Comme buildTabs() : on ne charge que les pages réellement éditables
        // (pas les pages à Blade figée), pour ne pas alourdir l'état du formulaire.
        $contents = PageContent::where('key', 'not like', '\_%')
            ->whereNotIn('page', SitePage::STATICALLY_RENDERED_SLUGS)
            ->get();

        foreach ($contents as $pc) {
            $formData["pc_{$pc->id}"] = $pc->value;
        }

        $this->form->fill($formData);
    }

    public function form(Schema $form): Schema
    {
        $tabs = $this->buildTabs();

        if (empty($tabs)) {
            return $form
                ->schema([
                    Placeholder::make('aucune_page_editable')
                        ->label('')
                        ->content('Aucune page éditable en ligne pour le moment.'),
                ])
                ->statePath('data');
        }

        return $form
            ->schema([
                Tabs::make('Pages')
                    ->persistTabInQueryString()
                    ->tabs($tabs)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    private function buildTabs(): array
    {
        $pages = PageContent::select('page')
            ->distinct()
            ->pluck('page')
            // VOIE B : on ne montre que les pages réellement rendues depuis page_contents.
            // Les pages à Blade figée (gtb, gtc, audit…) ne sont pas éditables ici :
            // les afficher laisserait croire à tort qu'on peut modifier leur contenu.
            ->reject(fn ($page) => in_array($page, SitePage::STATICALLY_RENDERED_SLUGS, true))
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

            'image' => FileUpload::make($formKey)
                ->label($label)
                ->image()
                ->disk('public')
                ->directory('content')
                ->imagePreviewHeight('120')
                ->helperText('Choisissez une image depuis votre ordinateur.')
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

        // Valeurs soumises, indexées par id de page_content.
        $submitted = [];
        foreach ($data as $formKey => $value) {
            if (str_starts_with($formKey, 'pc_')) {
                $submitted[(int) substr($formKey, 3)] = $value;
            }
        }

        if (empty($submitted)) {
            Notification::make()->title('Rien à enregistrer')->warning()->send();

            return;
        }

        // État actuel en base des lignes soumises.
        $current = PageContent::whereIn('id', array_keys($submitted))
            ->get(['id', 'page', 'value']);

        // Pages réellement modifiées (au moins une valeur différente) : on évite de
        // snapshoter/écraser une page inchangée (sinon un « Enregistrer » à vide
        // consommerait une révision et ferait tourner l'historique pour rien).
        // Comparaison normalisée : Filament déshydrate '' en null, donc un champ
        // stocké à '' ne doit pas être vu comme « modifié » au 1er enregistrement.
        $changedPages = [];
        foreach ($current as $pc) {
            if ((string) ($submitted[$pc->id] ?? '') !== (string) ($pc->value ?? '')) {
                $changedPages[$pc->page] = true;
            }
        }
        $changedPages = array_keys($changedPages);

        if (empty($changedPages)) {
            Notification::make()
                ->title('Aucune modification')
                ->body('Le contenu est déjà à jour.')
                ->warning()
                ->send();

            return;
        }

        // Filet de sécurité : instantané complet des pages modifiées avant écrasement,
        // regroupé sous un même lot (batch) pour pouvoir tout annuler d'un coup.
        $batchId = (string) Str::uuid();
        foreach ($changedPages as $page) {
            $this->snapshotPage($page, $batchId);
        }
        $this->purgeOldBatches();

        // Écrasement (uniquement les lignes des pages modifiées).
        foreach ($current as $pc) {
            if (in_array($pc->page, $changedPages, true)) {
                PageContent::where('id', $pc->id)->update(['value' => $submitted[$pc->id]]);
            }
        }

        // Invalide le cache des pages mises à jour.
        foreach ($changedPages as $page) {
            PageContent::clearCache($page);
        }

        Notification::make()
            ->title('Contenu enregistré')
            ->body(count($changedPages) . ' page(s) mise(s) à jour')
            ->success()
            ->send();
    }

    /**
     * Capture l'état actuel d'une page (toutes ses lignes page_contents, valeurs
     * nulles incluses) dans une révision du lot $batchId.
     */
    private function snapshotPage(string $page, string $batchId): void
    {
        $snapshot = PageContent::where('page', $page)
            ->pluck('value', 'id')
            ->toArray();

        ContentRevision::create([
            'batch_id'   => $batchId,
            'page'       => $page,
            'snapshot'   => $snapshot,
            'created_by' => auth()->guard('admin')->id(),
        ]);
    }

    /**
     * Borne l'historique aux 10 derniers lots (un lot = un « Enregistrer »).
     * On purge par lot et non par page, pour qu'un undo restaure toujours un lot
     * complet, même s'il a touché plusieurs pages.
     */
    private function purgeOldBatches(int $keep = 10): void
    {
        $keepBatchIds = ContentRevision::query()
            ->selectRaw('batch_id, MAX(id) as max_id')
            ->groupBy('batch_id')
            ->orderByDesc('max_id')
            ->limit($keep)
            ->pluck('batch_id');

        if ($keepBatchIds->isEmpty()) {
            return;
        }

        ContentRevision::whereNotIn('batch_id', $keepBatchIds)->delete();
    }

    /**
     * Restaure le dernier enregistrement (tout le lot, quelles que soient les pages
     * touchées) et le consomme : le bouton remonte ainsi l'historique cran par cran.
     */
    public function undoLastChange(): void
    {
        $last = ContentRevision::orderByDesc('id')->first();

        if (! $last) {
            Notification::make()
                ->title('Rien à annuler')
                ->body('Aucune modification récente à restaurer.')
                ->warning()
                ->send();

            return;
        }

        $revisions = ContentRevision::where('batch_id', $last->batch_id)->get();
        $restoredPages = [];

        foreach ($revisions as $revision) {
            foreach ($revision->snapshot as $id => $value) {
                PageContent::where('id', (int) $id)->update(['value' => $value]);
            }
            $restoredPages[$revision->page] = true;
        }

        // Purge le cache AVANT la notification (sinon le front garderait l'ancien
        // état jusqu'à 1h et l'annulation semblerait sans effet).
        foreach (array_keys($restoredPages) as $page) {
            PageContent::clearCache($page);
        }

        ContentRevision::where('batch_id', $last->batch_id)->delete();

        // Recharge le formulaire avec les valeurs restaurées.
        $this->loadFormData();

        Notification::make()
            ->title('Modification annulée')
            ->body('Le contenu a été remis à son état précédent.')
            ->success()
            ->send();
    }

    /**
     * Y a-t-il au moins une révision restaurable ? (pilote l'affichage du bouton d'annulation)
     */
    public function hasRevisions(): bool
    {
        return ContentRevision::exists();
    }

    /**
     * Télécharge une sauvegarde JSON de tout le contenu éditable (point de
     * restauration manuel, indépendant du retour arrière en base).
     */
    public function downloadBackup()
    {
        $rows = PageContent::orderBy('page')
            ->orderBy('section')
            ->orderBy('id')
            ->get(['id', 'page', 'section', 'key', 'value', 'type', 'label']);

        $payload = [
            'exported_at' => now()->toIso8601String(),
            'count'       => $rows->count(),
            'contents'    => $rows->toArray(),
        ];

        $filename = 'neogtb-contenu-' . now()->format('Ymd-His') . '.json';

        return response()->streamDownload(function () use ($payload) {
            echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }, $filename, [
            'Content-Type' => 'application/json',
        ]);
    }
}
