<x-filament-panels::page>

    @php
        $unread = $this->getUnreadMessages();
        $pendingGdpr = $this->getPendingGdpr();
        $overdueGdpr = $this->getOverdueGdpr();
        $hasAlerts = $unread > 0 || $overdueGdpr > 0;
    @endphp

    {{-- HEADER COMPACT --}}
    <div class="dash-header">
        <div class="dash-header-left">
            <h1 class="dash-greeting">
                {{ $this->getGreeting() }}, {{ $this->getAdminName() }}
            </h1>
            <p class="dash-date">{{ $this->getFormattedDate() }}</p>
        </div>
        <div class="dash-header-right">
            @if($hasAlerts)
                <div class="dash-alerts">
                    @if($unread > 0)
                        <a href="{{ \App\Filament\Resources\ContactMessageResource::getUrl() }}" class="dash-alert dash-alert-danger">
                            <x-heroicon-s-envelope class="dash-alert-icon" />
                            <span>{{ $unread }} message{{ $unread > 1 ? 's' : '' }} non lu{{ $unread > 1 ? 's' : '' }}</span>
                        </a>
                    @endif
                    @if($overdueGdpr > 0)
                        <a href="{{ \App\Filament\Resources\GdprRequestResource::getUrl() }}" class="dash-alert dash-alert-warning">
                            <x-heroicon-s-shield-exclamation class="dash-alert-icon" />
                            <span>{{ $overdueGdpr }} RGPD en retard</span>
                        </a>
                    @endif
                </div>
            @endif
            <a href="{{ url('/') }}" target="_blank" class="dash-site-link">
                <x-heroicon-o-arrow-top-right-on-square class="w-4 h-4" />
                Voir le site
            </a>
        </div>
    </div>

    {{-- STATS --}}
    @livewire(\App\Filament\Widgets\StatsOverview::class)

    {{-- RACCOURCIS --}}
    <div class="dash-section-label">Accès rapides</div>
    <div class="dash-shortcuts">
        {{-- Ligne principale --}}
        <a href="{{ url('/admin/homepage') }}" class="dash-shortcut dash-shortcut-primary">
            <div class="dash-shortcut-icon dash-icon-blue">
                <x-heroicon-o-home class="w-5 h-5" />
            </div>
            <div class="dash-shortcut-text">
                <p class="dash-shortcut-title">Page d'accueil</p>
                <p class="dash-shortcut-desc">Hero, textes, boutons, image</p>
            </div>
            <x-heroicon-o-chevron-right class="dash-shortcut-arrow" />
        </a>

        <a href="{{ url('/admin/pages') }}" class="dash-shortcut dash-shortcut-primary">
            <div class="dash-shortcut-icon dash-icon-green">
                <x-heroicon-o-document-text class="w-5 h-5" />
            </div>
            <div class="dash-shortcut-text">
                <p class="dash-shortcut-title">Pages du site</p>
                <p class="dash-shortcut-desc">GTB, GTC, Solutions, FAQ...</p>
            </div>
            <x-heroicon-o-chevron-right class="dash-shortcut-arrow" />
        </a>

        <a href="{{ \App\Filament\Resources\PostResource::getUrl('create') }}" class="dash-shortcut dash-shortcut-primary">
            <div class="dash-shortcut-icon dash-icon-amber">
                <x-heroicon-o-plus class="w-5 h-5" />
            </div>
            <div class="dash-shortcut-text">
                <p class="dash-shortcut-title">Nouvel article</p>
                <p class="dash-shortcut-desc">Publier sur le blog</p>
            </div>
            <x-heroicon-o-chevron-right class="dash-shortcut-arrow" />
        </a>

        {{-- Ligne secondaire --}}
        <a href="{{ url('/admin/navigation-menus') }}" class="dash-shortcut">
            <div class="dash-shortcut-icon dash-icon-violet">
                <x-heroicon-o-bars-3 class="w-4 h-4" />
            </div>
            <div class="dash-shortcut-text">
                <p class="dash-shortcut-title">Menus</p>
            </div>
        </a>

        <a href="{{ url('/admin/media-library') }}" class="dash-shortcut">
            <div class="dash-shortcut-icon dash-icon-rose">
                <x-heroicon-o-photo class="w-4 h-4" />
            </div>
            <div class="dash-shortcut-text">
                <p class="dash-shortcut-title">Médiathèque</p>
            </div>
        </a>

        <a href="{{ url('/admin/site-settings') }}" class="dash-shortcut">
            <div class="dash-shortcut-icon dash-icon-slate">
                <x-heroicon-o-cog-6-tooth class="w-4 h-4" />
            </div>
            <div class="dash-shortcut-text">
                <p class="dash-shortcut-title">Réglages</p>
            </div>
        </a>
    </div>

    {{-- TABLES --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div>
            @livewire(\App\Filament\Widgets\RecentMessages::class)
        </div>
        <div>
            @livewire(\App\Filament\Widgets\RecentActivity::class)
        </div>
    </div>

</x-filament-panels::page>
