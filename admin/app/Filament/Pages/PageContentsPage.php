<?php

namespace App\Filament\Pages;

use App\Models\PageBrick;
use App\Models\SitePage;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
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

    public function mount(): void
    {
        $formData = [];

        $pages = SitePage::with(['bricks' => fn ($q) => $q->orderBy('order')])->get();

        foreach ($pages as $page) {
            foreach ($page->bricks as $brick) {
                $this->flattenToForm($formData, $brick->id, 'content', $brick->content ?? []);
                $this->flattenToForm($formData, $brick->id, 'settings', $brick->settings ?? []);
            }
        }

        $this->form->fill($formData);
    }

    /**
     * Flatten nested arrays into dot-notation form keys: brick_{id}__content__key
     */
    private function flattenToForm(array &$formData, int $brickId, string $group, array $data, string $prefix = ''): void
    {
        foreach ($data as $key => $value) {
            $formKey = "brick_{$brickId}__{$group}__{$prefix}{$key}";

            if (is_array($value) && $this->isAssoc($value)) {
                $this->flattenToForm($formData, $brickId, $group, $value, $prefix . $key . '__');
            } else {
                $formData[$formKey] = $value;
            }
        }
    }

    private function isAssoc(array $arr): bool
    {
        if (empty($arr)) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
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
        $pages = SitePage::with(['bricks' => fn ($q) => $q->orderBy('order')])
            ->orderBy('order')
            ->get();

        $pageIcons = [
            'accueil' => 'heroicon-o-home',
            'gtb' => 'heroicon-o-cpu-chip',
            'gtc' => 'heroicon-o-computer-desktop',
            'solutions' => 'heroicon-o-wrench-screwdriver',
            'reglementation' => 'heroicon-o-scale',
            'audit' => 'heroicon-o-clipboard-document-check',
            'contact' => 'heroicon-o-envelope',
            'about' => 'heroicon-o-user-group',
            'faq' => 'heroicon-o-question-mark-circle',
            'comparateur' => 'heroicon-o-arrows-right-left',
            'blog' => 'heroicon-o-newspaper',
        ];

        $tabs = [];

        foreach ($pages as $page) {
            $bricks = $page->bricks;
            if ($bricks->isEmpty()) continue;

            $sections = [];

            foreach ($bricks as $brick) {
                $fields = $this->buildFieldsForBrick($brick);
                $label = ($brick->brick_name ?: $brick->brick_type) . ($brick->is_visible ? '' : ' (masqué)');

                $sections[] = Section::make($label)
                    ->schema($fields)
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(true);
            }

            $tabs[] = Tab::make($page->name ?: $page->slug)
                ->icon($pageIcons[$page->slug] ?? 'heroicon-o-document')
                ->badge(count($bricks))
                ->schema($sections);
        }

        return $tabs;
    }

    /**
     * Build simple TextInput/Textarea fields for each brick content key.
     * Arrays (like repeaters) are shown as JSON for now.
     */
    private function buildFieldsForBrick(PageBrick $brick): array
    {
        $fields = [];
        $content = $brick->content ?? [];
        $settings = $brick->settings ?? [];

        // Content fields
        foreach ($content as $key => $value) {
            $formKey = "brick_{$brick->id}__content__{$key}";
            $label = $this->humanLabel($key);

            if (is_array($value)) {
                // Arrays (cartes, stats, questions, etc.) → Textarea with JSON
                $fields[] = Textarea::make($formKey)
                    ->label($label)
                    ->rows(4)
                    ->helperText('Format JSON — tableau de données')
                    ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $state)
                    ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state)
                    ->columnSpanFull();
            } elseif (is_bool($value)) {
                $fields[] = Toggle::make($formKey)
                    ->label($label);
            } elseif (mb_strlen((string) $value) > 120) {
                $fields[] = Textarea::make($formKey)
                    ->label($label)
                    ->rows(3)
                    ->columnSpanFull();
            } else {
                $fields[] = TextInput::make($formKey)
                    ->label($label);
            }
        }

        // Settings fields
        if (!empty($settings)) {
            foreach ($settings as $key => $value) {
                $formKey = "brick_{$brick->id}__settings__{$key}";
                $label = '⚙️ ' . $this->humanLabel($key);

                if (is_array($value)) {
                    $fields[] = Textarea::make($formKey)
                        ->label($label)
                        ->rows(2)
                        ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $state)
                        ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state)
                        ->columnSpanFull();
                } elseif (is_bool($value)) {
                    $fields[] = Toggle::make($formKey)
                        ->label($label);
                } else {
                    $fields[] = TextInput::make($formKey)
                        ->label($label);
                }
            }
        }

        return $fields;
    }

    private function humanLabel(string $key): string
    {
        return ucfirst(str_replace(['_', '-'], ' ', $key));
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Group by brick ID
        $brickUpdates = [];

        foreach ($data as $formKey => $value) {
            if (!preg_match('/^brick_(\d+)__(content|settings)__(.+)$/', $formKey, $matches)) {
                continue;
            }

            $brickId = (int) $matches[1];
            $group = $matches[2];
            $field = $matches[3];

            $brickUpdates[$brickId][$group][$field] = $value;
        }

        $admin = auth()->guard('admin')->user();

        foreach ($brickUpdates as $brickId => $updates) {
            $brick = PageBrick::find($brickId);
            if (!$brick) continue;

            if (isset($updates['content'])) {
                $content = $brick->content ?? [];
                foreach ($updates['content'] as $key => $val) {
                    $content[$key] = $val;
                }
                $brick->content = $content;
            }

            if (isset($updates['settings'])) {
                $settings = $brick->settings ?? [];
                foreach ($updates['settings'] as $key => $val) {
                    $settings[$key] = $val;
                }
                $brick->settings = $settings;
            }

            $brick->updated_by = $admin?->id;
            $brick->save();
        }

        Notification::make()
            ->title('Contenu enregistré')
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
