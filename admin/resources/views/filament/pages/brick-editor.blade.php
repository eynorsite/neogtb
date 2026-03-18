<x-filament-panels::page>
    {{-- Header with page info --}}
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('filament.admin.resources.pages.edit', $page->id) }}"
               class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-primary-600 transition">
                ← Retour à la page
            </a>
            <span class="text-gray-300">|</span>
            <span class="font-semibold text-lg">{{ $page->name }}</span>
            <span class="rounded-full bg-primary-100 px-2 py-0.5 text-xs text-primary-700">
                {{ count($bricks) }} brick(s)
            </span>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4" style="min-height: 600px;">

        {{-- LEFT PANEL: Bibliothèque de bricks --}}
        <div class="col-span-3">
            <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-gray-500">
                    🧱 Bibliothèque
                </h3>

                @foreach($this->availableBricks as $category => $categoryBricks)
                    <div class="mb-4">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">{{ $category }}</p>
                        <div class="space-y-1">
                            @foreach($categoryBricks as $type => $brick)
                                <button
                                    wire:click="addBrick('{{ $type }}')"
                                    class="flex w-full items-center gap-2 rounded-lg border border-gray-100 bg-gray-50 px-3 py-2 text-left text-sm transition hover:border-primary-300 hover:bg-primary-50 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600"
                                >
                                    <span class="text-lg">{{ $brick->icon() }}</span>
                                    <div>
                                        <div class="font-medium">{{ $brick->name() }}</div>
                                        <div class="text-xs text-gray-400">{{ $brick->description() }}</div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- CENTER PANEL: Canvas --}}
        <div class="col-span-5">
            <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-gray-500">
                    📋 Canvas — {{ $page->name }}
                </h3>

                @if(count($bricks) === 0)
                    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                        <span class="text-4xl mb-2">🧱</span>
                        <p class="text-sm">Aucune brick sur cette page</p>
                        <p class="text-xs mt-1">Cliquez sur une brick dans la bibliothèque pour l'ajouter</p>
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach($bricks as $index => $brick)
                            @php
                                $def = $this->getBrickDefinition($brick['brick_type']);
                                $isSelected = $selectedBrickIndex === $index;
                            @endphp
                            <div
                                wire:click="selectBrick({{ $index }})"
                                class="group relative cursor-pointer rounded-lg border-2 p-3 transition
                                    {{ $isSelected
                                        ? 'border-primary-500 bg-primary-50 shadow-sm dark:bg-primary-900/20'
                                        : 'border-gray-100 bg-white hover:border-gray-300 dark:border-gray-600 dark:bg-gray-700' }}
                                    {{ !$brick['is_visible'] ? 'opacity-40' : '' }}"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg">{{ $def['icon'] ?? '🧱' }}</span>
                                        <div>
                                            <span class="font-medium text-sm">{{ $def['name'] ?? $brick['brick_type'] }}</span>
                                            @if($brick['is_locked'])
                                                <span class="ml-1 text-xs">🔒</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                        @if($index > 0)
                                            <button wire:click.stop="moveBrick({{ $index }}, 'up')"
                                                class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-700 text-xs">
                                                ▲
                                            </button>
                                        @endif
                                        @if($index < count($bricks) - 1)
                                            <button wire:click.stop="moveBrick({{ $index }}, 'down')"
                                                class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-700 text-xs">
                                                ▼
                                            </button>
                                        @endif
                                        <button wire:click.stop="toggleVisibility({{ $index }})"
                                            class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-700 text-xs"
                                            title="{{ $brick['is_visible'] ? 'Masquer' : 'Afficher' }}">
                                            {{ $brick['is_visible'] ? '👁' : '👁‍🗨' }}
                                        </button>
                                    </div>
                                </div>

                                {{-- Preview content --}}
                                @php
                                    $brickDef = \App\Filament\Bricks\BrickRegistry::get($brick['brick_type']);
                                    $previewHtml = $brickDef ? $brickDef->preview($brick['content'] ?? []) : '';
                                @endphp
                                @if($previewHtml)
                                    <div class="mt-1 text-xs text-gray-500">
                                        {!! $previewHtml !!}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- RIGHT PANEL: Propriétés --}}
        <div class="col-span-4">
            <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                @if($selectedBrickIndex !== null && isset($bricks[$selectedBrickIndex]))
                    @php
                        $selectedBrick = $bricks[$selectedBrickIndex];
                        $brickDef = \App\Filament\Bricks\BrickRegistry::get($selectedBrick['brick_type']);
                    @endphp

                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-sm font-bold uppercase tracking-wide text-gray-500">
                            ✏️ {{ $brickDef?->name() ?? $selectedBrick['brick_type'] }}
                        </h3>
                        <button wire:click="deleteBrick({{ $selectedBrickIndex }})"
                            wire:confirm="Supprimer cette brick ?"
                            class="rounded px-2 py-1 text-xs text-red-600 hover:bg-red-50 transition">
                            🗑️ Supprimer
                        </button>
                    </div>

                    <form wire:submit="saveBrick" class="space-y-3">
                        <p class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Contenu</p>

                        @foreach($selectedBrick['content'] ?? [] as $key => $value)
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                </label>
                                @if(is_array($value))
                                    <p class="text-xs text-gray-400 italic">Champ complexe — éditez via le formulaire de page</p>
                                @elseif(strlen((string)$value) > 100)
                                    <textarea wire:model.defer="editingContent.content.{{ $key }}" rows="3"
                                        class="fi-input block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    ></textarea>
                                @else
                                    <input type="text" wire:model.defer="editingContent.content.{{ $key }}"
                                        class="fi-input block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    >
                                @endif
                            </div>
                        @endforeach

                        @if(!empty($selectedBrick['settings'] ?? []))
                            <p class="text-xs text-gray-400 uppercase font-semibold tracking-wider mt-4">Apparence</p>
                            @foreach($selectedBrick['settings'] ?? [] as $key => $value)
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                                    </label>
                                    @if(is_bool($value))
                                        <label class="relative inline-flex cursor-pointer items-center">
                                            <input type="checkbox" wire:model.defer="editingContent.settings.{{ $key }}" class="peer sr-only">
                                            <div class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:bg-white after:transition-all peer-checked:bg-primary-600 peer-checked:after:translate-x-full dark:bg-gray-700"></div>
                                        </label>
                                    @elseif(str_starts_with((string)$value, '#'))
                                        <input type="color" wire:model.defer="editingContent.settings.{{ $key }}"
                                            class="h-10 w-14 cursor-pointer rounded border-gray-300">
                                    @else
                                        <input type="text" wire:model.defer="editingContent.settings.{{ $key }}"
                                            class="fi-input block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                        >
                                    @endif
                                </div>
                            @endforeach
                        @endif

                        <div class="pt-3 border-t">
                            <x-filament::button type="submit" class="w-full">
                                💾 Enregistrer la brick
                            </x-filament::button>
                        </div>
                    </form>
                @else
                    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                        <span class="text-3xl mb-2">👆</span>
                        <p class="text-sm font-medium">Aucune brick sélectionnée</p>
                        <p class="text-xs mt-1">Cliquez sur une brick dans le canvas pour l'éditer</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>
