<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Mode maintenance --}}
        <x-filament::section heading="Mode maintenance">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        @if(app()->isDownForMaintenance())
                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800">
                                Mode maintenance ACTIF
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                                Site en ligne
                            </span>
                        @endif
                    </p>
                </div>
                <x-filament::button
                    wire:click="toggleMaintenance"
                    :color="app()->isDownForMaintenance() ? 'success' : 'danger'"
                >
                    {{ app()->isDownForMaintenance() ? 'Remettre en ligne' : 'Activer la maintenance' }}
                </x-filament::button>
            </div>
        </x-filament::section>

        {{-- Cache --}}
        <x-filament::section heading="Gestion du cache">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                <x-filament::button wire:click="clearAllCache" color="danger" icon="heroicon-o-trash">
                    Vider tout le cache
                </x-filament::button>

                <x-filament::button wire:click="clearConfigCache" color="warning" icon="heroicon-o-cog-6-tooth">
                    Cache configuration
                </x-filament::button>

                <x-filament::button wire:click="clearViewCache" color="warning" icon="heroicon-o-eye">
                    Cache des vues
                </x-filament::button>

                <x-filament::button wire:click="clearRouteCache" color="warning" icon="heroicon-o-arrow-path">
                    Cache des routes
                </x-filament::button>

                <x-filament::button wire:click="optimize" color="success" icon="heroicon-o-bolt">
                    Optimiser l'application
                </x-filament::button>
            </div>
        </x-filament::section>

        {{-- Santé du site --}}
        <x-filament::section heading="Santé du site">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="flex items-center gap-2">
                    @if(!config('app.debug'))
                        <span class="text-green-500 text-lg">✅</span>
                        <span>APP_DEBUG = false</span>
                    @else
                        <span class="text-red-500 text-lg">❌</span>
                        <span class="text-red-600">APP_DEBUG = true (à désactiver en production !)</span>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    @if(config('app.env') === 'production')
                        <span class="text-green-500 text-lg">✅</span>
                        <span>Environnement : production</span>
                    @else
                        <span class="text-yellow-500 text-lg">⚠️</span>
                        <span>Environnement : {{ config('app.env') }}</span>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-green-500 text-lg">✅</span>
                    <span>PHP {{ phpversion() }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-green-500 text-lg">✅</span>
                    <span>Laravel {{ app()->version() }}</span>
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
