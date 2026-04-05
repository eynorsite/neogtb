<x-filament-panels::page>
    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Consentements --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-finger-print class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Consentements</h3>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($this->getConsentsThisMonth()) }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">ce mois-ci</p>
            <div class="mt-3 flex items-center gap-2">
                <span class="text-sm font-semibold {{ $this->getAcceptanceRate() >= 70 ? 'text-green-600' : 'text-orange-600' }}">
                    {{ $this->getAcceptanceRate() }}% acceptés
                </span>
            </div>
        </div>

        {{-- Demandes en attente --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 {{ $this->getOverdueRequests() > 0 ? 'bg-red-100 dark:bg-red-900' : 'bg-amber-100 dark:bg-amber-900' }} rounded-lg flex items-center justify-center">
                    <x-heroicon-o-clock class="w-5 h-5 {{ $this->getOverdueRequests() > 0 ? 'text-red-600 dark:text-red-400' : 'text-amber-600 dark:text-amber-400' }}" />
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Demandes</h3>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $this->getPendingRequests() }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">en attente de traitement</p>
            @if($this->getOverdueRequests() > 0)
                <div class="mt-3">
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-md text-xs font-semibold">
                        <x-heroicon-o-exclamation-triangle class="w-3 h-3" />
                        {{ $this->getOverdueRequests() }} dépassent le délai de 30 jours
                    </span>
                </div>
            @endif
            <div class="mt-3">
                <a href="{{ \App\Filament\Resources\GdprRequestResource::getUrl('index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700">
                    Traiter les demandes &rarr;
                </a>
            </div>
        </div>

        {{-- Politique en vigueur --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-document-text class="w-5 h-5 text-green-600 dark:text-green-400" />
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Politique</h3>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $this->getCurrentPolicyVersion() }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                @if($this->getPolicyPublishedAt())
                    En vigueur depuis le {{ $this->getPolicyPublishedAt() }}
                @else
                    Aucune politique publiée
                @endif
            </p>
        </div>
    </div>

    {{-- Demandes récentes --}}
    @if($this->getRecentRequests()->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Demandes en attente</h3>
            <div class="space-y-3">
                @foreach($this->getRecentRequests() as $request)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium
                                {{ $request->type === 'deletion' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' }}">
                                {{ $request->getTypeLabel() }}
                            </span>
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $request->getMaskedEmail() }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400">
                                Reçue il y a {{ $request->created_at->diffForHumans(syntax: true) }}
                            </span>
                            @if($request->isOverdue())
                                <span class="inline-flex items-center px-2 py-0.5 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded text-xs font-semibold">
                                    URGENT
                                </span>
                            @endif
                            <a href="{{ \App\Filament\Resources\GdprRequestResource::getUrl('edit', ['record' => $request]) }}"
                               class="text-xs font-medium text-primary-600 hover:text-primary-700">
                                Traiter
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Alertes --}}
    @if($this->getOverdueRequests() > 0 || $this->getExpiredConsentsCount() > 0)
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-300 mb-3 flex items-center gap-2">
                <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                Alertes RGPD
            </h3>
            <ul class="space-y-2">
                @if($this->getOverdueRequests() > 0)
                    <li class="flex items-start gap-2 text-sm text-amber-700 dark:text-amber-300">
                        <span class="mt-1 w-1.5 h-1.5 bg-red-500 rounded-full flex-shrink-0"></span>
                        {{ $this->getOverdueRequests() }} demande(s) dépasse(nt) le délai légal de 30 jours — action immédiate requise
                    </li>
                @endif
                @if($this->getExpiredConsentsCount() > 0)
                    <li class="flex items-start gap-2 text-sm text-amber-700 dark:text-amber-300">
                        <span class="mt-1 w-1.5 h-1.5 bg-orange-500 rounded-full flex-shrink-0"></span>
                        {{ number_format($this->getExpiredConsentsCount()) }} consentement(s) de plus de 13 mois à purger
                    </li>
                @endif
            </ul>
        </div>
    @endif
</x-filament-panels::page>
