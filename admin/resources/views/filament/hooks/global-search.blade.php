@unless (filament()->isGlobalSearchEnabled() && filament()->getGlobalSearchPosition() === \Filament\Enums\GlobalSearchPosition::Topbar)
    @livewire(\Filament\Livewire\GlobalSearch::class)
@endunless
