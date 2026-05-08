<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6 flex justify-end gap-2">
            <x-filament::button type="submit" icon="heroicon-o-check">
                Enregistrer la configuration
            </x-filament::button>
        </div>
    </form>

    <div class="mt-10">
        <x-filament::section>
            <x-slot name="heading">
                <span class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-beaker" class="h-5 w-5 text-primary-600" />
                    Tester le bot ici
                </span>
            </x-slot>
            <x-slot name="description">
                Pose une question, le bot répondra avec la configuration actuelle (sauvegardée d'abord). Pratique pour itérer sur le persona ou la base de connaissances avant de publier.
            </x-slot>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        Question test
                    </label>
                    <textarea
                        wire:model="testMessage"
                        rows="3"
                        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
                        placeholder="Ex: Quelles sont les obligations du décret BACS pour un bâtiment de 800 m² ?"
                    ></textarea>
                </div>

                <div class="flex justify-end">
                    <x-filament::button
                        type="button"
                        wire:click="runTest"
                        icon="heroicon-o-play"
                        wire:loading.attr="disabled"
                        wire:target="runTest"
                    >
                        <span wire:loading.remove wire:target="runTest">Tester</span>
                        <span wire:loading wire:target="runTest">Génération…</span>
                    </x-filament::button>
                </div>

                @if(!empty($testResult))
                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-900/40">
                        @if(isset($testResult['error']))
                            <div class="text-sm text-red-600">{{ $testResult['error'] }}</div>
                        @else
                            <div class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                                Réponse du bot
                            </div>
                            <div class="prose prose-sm max-w-none text-gray-800 dark:text-gray-200 whitespace-pre-wrap">{{ $testResult['reply'] }}</div>

                            <div class="mt-4 grid grid-cols-2 sm:grid-cols-5 gap-3 text-xs text-gray-600 dark:text-gray-400">
                                <div>
                                    <span class="block font-medium">Modèle</span>
                                    {{ $testResult['model'] ?? '—' }}
                                </div>
                                <div>
                                    <span class="block font-medium">Tokens IN</span>
                                    {{ $testResult['tokens_in'] ?? 0 }}
                                </div>
                                <div>
                                    <span class="block font-medium">Tokens OUT</span>
                                    {{ $testResult['tokens_out'] ?? 0 }}
                                </div>
                                <div>
                                    <span class="block font-medium">Coût</span>
                                    {{ number_format($testResult['cost_eur'] ?? 0, 6) }} €
                                </div>
                                <div>
                                    <span class="block font-medium">Latence</span>
                                    {{ $testResult['latency_ms'] ?? 0 }} ms
                                </div>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                Taille prompt système : {{ number_format($testResult['system_prompt_chars'] ?? 0) }} caractères
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
