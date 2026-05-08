<x-filament-panels::page>
    @php
        $stats = $this->getStats();
        $budgetPct = $stats['budget_used_pct'];
        $budgetColor = $budgetPct < 60 ? 'emerald' : ($budgetPct < 85 ? 'amber' : 'rose');
        $maxDaily = max(array_map(fn ($d) => $d['count'], $stats['daily_conversations'])) ?: 1;
    @endphp

    <div wire:poll.60s class="space-y-8">

        {{-- KPI cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 shadow-sm">
                <div class="text-xs uppercase tracking-wide font-medium text-gray-500 dark:text-gray-400">
                    Conversations 7 jours
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['conversations_7d'] }}</span>
                </div>
                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    {{ $stats['conversations_today'] }} aujourd'hui
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 shadow-sm">
                <div class="text-xs uppercase tracking-wide font-medium text-gray-500 dark:text-gray-400">
                    Coût du mois
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ number_format($stats['total_cost_month'], 2, ',', ' ') }} €
                    </span>
                </div>
                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Budget : {{ number_format($stats['monthly_budget'], 2, ',', ' ') }} €
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 shadow-sm">
                <div class="text-xs uppercase tracking-wide font-medium text-gray-500 dark:text-gray-400">
                    Leads 30 jours
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['leads_count_30d'] }}</span>
                </div>
                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    sur {{ $stats['conversations_30d'] }} conversations
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 shadow-sm">
                <div class="text-xs uppercase tracking-wide font-medium text-gray-500 dark:text-gray-400">
                    Taux de conversion
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ number_format($stats['lead_conversion_rate'], 1, ',', ' ') }} %
                    </span>
                </div>
                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    leads / conversations (30j)
                </div>
            </div>
        </div>

        {{-- Budget mensuel --}}
        <x-filament::section>
            <x-slot name="heading">Budget mensuel</x-slot>
            <x-slot name="description">
                Suivi du coût cumulé Anthropic vs budget configuré.
            </x-slot>

            <div class="space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium text-gray-700 dark:text-gray-200">
                        {{ number_format($stats['total_cost_month'], 4, ',', ' ') }} € consommés
                    </span>
                    <span class="text-gray-500 dark:text-gray-400">
                        / {{ number_format($stats['monthly_budget'], 2, ',', ' ') }} € budget
                    </span>
                </div>

                <div class="w-full h-3 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                    @if($budgetColor === 'emerald')
                        <div class="h-full bg-emerald-500 transition-all" style="width: {{ $budgetPct }}%"></div>
                    @elseif($budgetColor === 'amber')
                        <div class="h-full bg-amber-500 transition-all" style="width: {{ $budgetPct }}%"></div>
                    @else
                        <div class="h-full bg-rose-500 transition-all" style="width: {{ $budgetPct }}%"></div>
                    @endif
                </div>

                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                    <span>{{ number_format($budgetPct, 1, ',', ' ') }} % utilisé</span>
                    <span>
                        @if($budgetPct < 60)
                            Marge confortable
                        @elseif($budgetPct < 85)
                            Vigilance
                        @else
                            Seuil critique
                        @endif
                    </span>
                </div>
            </div>
        </x-filament::section>

        {{-- Activité 7 jours --}}
        <x-filament::section>
            <x-slot name="heading">Activité 7 jours</x-slot>
            <x-slot name="description">
                Conversations démarrées par jour.
            </x-slot>

            <div class="flex items-end justify-between gap-2 h-40 px-2">
                @foreach($stats['daily_conversations'] as $day)
                    @php
                        $heightPct = $maxDaily > 0 ? max(2, round(($day['count'] / $maxDaily) * 100)) : 2;
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2 h-full">
                        <div class="flex-1 w-full flex items-end justify-center">
                            <div
                                class="w-full max-w-[44px] rounded-t-md bg-primary-500/80 dark:bg-primary-400/80 hover:bg-primary-600 dark:hover:bg-primary-300 transition-colors relative group"
                                style="height: {{ $heightPct }}%"
                                title="{{ $day['date'] }} : {{ $day['count'] }} conversations"
                            >
                                <div class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs font-medium text-gray-700 dark:text-gray-200 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                    {{ $day['count'] }}
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 tabular-nums">
                            {{ $day['date'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        {{-- Top 10 questions --}}
        <x-filament::section>
            <x-slot name="heading">Top 10 questions posées</x-slot>
            <x-slot name="description">
                Messages utilisateurs les plus récurrents (toutes périodes).
            </x-slot>

            @if(empty($stats['top_questions']))
                <div class="text-sm text-gray-500 dark:text-gray-400 italic">
                    Aucune question enregistrée pour le moment.
                </div>
            @else
                <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-300">
                                    Question
                                </th>
                                <th class="px-4 py-2 text-right text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-300 w-32">
                                    Occurrences
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900">
                            @foreach($stats['top_questions'] as $q)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                                        {{ \Illuminate\Support\Str::limit(trim($q['content']), 80) }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-right tabular-nums font-medium text-gray-700 dark:text-gray-300">
                                        {{ $q['occurrences'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-filament::section>

        {{-- Performance --}}
        <x-filament::section>
            <x-slot name="heading">Performance</x-slot>
            <x-slot name="description">
                Indicateurs qualité des conversations.
            </x-slot>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4 bg-gray-50/50 dark:bg-gray-800/30">
                    <div class="text-xs uppercase tracking-wide font-medium text-gray-500 dark:text-gray-400">
                        Messages / conversation
                    </div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                        {{ number_format($stats['avg_messages_per_conv'], 1, ',', ' ') }}
                    </div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        moyenne (conversations actives)
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4 bg-gray-50/50 dark:bg-gray-800/30">
                    <div class="text-xs uppercase tracking-wide font-medium text-gray-500 dark:text-gray-400">
                        Conversations 30 jours
                    </div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                        {{ $stats['conversations_30d'] }}
                    </div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        volume total période glissante
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4 bg-gray-50/50 dark:bg-gray-800/30">
                    <div class="text-xs uppercase tracking-wide font-medium text-gray-500 dark:text-gray-400">
                        Coût moyen / conversation
                    </div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                        @php
                            $avgCost = $stats['conversations_30d'] > 0
                                ? $stats['total_cost_month'] / max($stats['conversations_30d'], 1)
                                : 0;
                        @endphp
                        {{ number_format($avgCost, 4, ',', ' ') }} €
                    </div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        coût mois / conv. 30j
                    </div>
                </div>
            </div>
        </x-filament::section>

    </div>
</x-filament-panels::page>
