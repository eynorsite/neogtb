<x-filament-panels::page>
    {{-- Force full width --}}
    <style>
        .fi-page > .fi-page-content { max-width: 100% !important; }
        .sortable-ghost { opacity: 0.4; }
        .sortable-drag { box-shadow: 0 8px 24px rgba(0,0,0,0.15); transform: rotate(1deg); }
        .drag-handle { cursor: grab; }
        .drag-handle:active { cursor: grabbing; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>

    {{-- Header --}}
    <div class="mb-4 flex items-center justify-between rounded-lg bg-white px-4 py-3 shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <a href="{{ route('filament.admin.resources.pages.edit', $page->id) }}"
               class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-100 transition dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                ← Retour
            </a>
            <div>
                <span class="font-bold text-lg">{{ $page->name }}</span>
                <span class="ml-2 rounded-full bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-700 dark:bg-primary-900/30 dark:text-primary-300">
                    {{ count($bricks) }} brick(s)
                </span>
            </div>
        </div>
        <a href="/{{ $page->slug }}" target="_blank"
           class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-50 transition dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
            👁 Voir le site
        </a>
    </div>

    {{-- 3-column layout --}}
    <div style="display: grid; grid-template-columns: 240px 1fr 320px; gap: 16px; min-height: 550px;">

        {{-- LEFT: Bibliothèque --}}
        <div>
            <div class="sticky top-4 rounded-xl border border-gray-200 bg-white p-3 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-3 flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-gray-400">
                    <span>🧱</span> Bibliothèque
                </h3>

                @foreach($this->availableBricks as $category => $categoryBricks)
                    <div class="mb-3">
                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-300">{{ $category }}</p>
                        <div class="space-y-1">
                            @foreach($categoryBricks as $type => $brick)
                                <button
                                    wire:click="addBrick('{{ $type }}')"
                                    class="flex w-full items-center gap-2 rounded-lg border border-transparent px-2.5 py-2 text-left transition hover:border-primary-200 hover:bg-primary-50 dark:hover:bg-primary-900/20"
                                >
                                    <span class="text-base shrink-0">{{ $brick->icon() }}</span>
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $brick->name() }}</div>
                                        <div class="truncate text-[10px] text-gray-400">{{ $brick->description() }}</div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- CENTER: Canvas --}}
        <div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/50" style="min-height: 500px;">
                <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-gray-400">
                    📋 Canvas
                </h3>

                @if(count($bricks) === 0)
                    <div class="flex flex-col items-center justify-center py-20 text-gray-400">
                        <span class="text-5xl mb-3">🧱</span>
                        <p class="text-sm font-medium">Page vide</p>
                        <p class="text-xs mt-1">Cliquez sur une brick dans la bibliothèque pour l'ajouter</p>
                    </div>
                @else
                    <div id="brick-sortable" class="space-y-2">
                        @foreach($bricks as $index => $brick)
                            @php
                                $def = $this->getBrickDefinition($brick['brick_type']);
                                $isSelected = $selectedBrickIndex === $index;
                                $brickDef = \App\Filament\Bricks\BrickRegistry::get($brick['brick_type']);
                                $previewHtml = $brickDef ? $brickDef->preview($brick['content'] ?? []) : '';
                            @endphp
                            <div
                                data-id="{{ $brick['id'] }}"
                                wire:click="selectBrick({{ $index }})"
                                class="group relative cursor-pointer rounded-lg border-2 bg-white p-3 transition-all
                                    {{ $isSelected
                                        ? 'border-primary-500 bg-primary-50/50 shadow-md ring-1 ring-primary-200'
                                        : 'border-gray-200 hover:border-gray-300 hover:shadow-sm' }}
                                    {{ !$brick['is_visible'] ? 'opacity-40' : '' }}
                                    dark:bg-gray-800"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <span class="drag-handle flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 transition" title="Glisser pour réordonner">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                                        </span>
                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-base dark:bg-gray-700">
                                            {{ $def['icon'] ?? '🧱' }}
                                        </span>
                                        <div>
                                            <span class="font-semibold text-sm text-gray-800 dark:text-gray-200">
                                                {{ $def['name'] ?? $brick['brick_type'] }}
                                            </span>
                                            @if($brick['is_locked'])
                                                <span class="ml-1 text-xs">🔒</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-0.5 opacity-0 group-hover:opacity-100 transition">
                                        @if($index > 0)
                                            <button wire:click.stop="moveBrick({{ $index }}, 'up')"
                                                class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                            </button>
                                        @endif
                                        @if($index < count($bricks) - 1)
                                            <button wire:click.stop="moveBrick({{ $index }}, 'down')"
                                                class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </button>
                                        @endif
                                        <button wire:click.stop="toggleVisibility({{ $index }})"
                                            class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition"
                                            title="{{ $brick['is_visible'] ? 'Masquer' : 'Afficher' }}">
                                            @if($brick['is_visible'])
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            @else
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                            @endif
                                        </button>
                                    </div>
                                </div>

                                @if($previewHtml)
                                    <div class="mt-2 border-t border-gray-100 pt-2 text-xs text-gray-500 dark:border-gray-700">
                                        {!! $previewHtml !!}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- RIGHT: Propriétés --}}
        <div>
            <div class="sticky top-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800" style="max-height: calc(100vh - 120px); overflow-y: auto;">
                @if($selectedBrickIndex !== null && isset($bricks[$selectedBrickIndex]))
                    @php
                        $selectedBrick = $bricks[$selectedBrickIndex];
                        $brickDef = \App\Filament\Bricks\BrickRegistry::get($selectedBrick['brick_type']);
                    @endphp

                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-gray-400">
                            <span>✏️</span> {{ $brickDef?->name() ?? $selectedBrick['brick_type'] }}
                        </h3>
                        <button wire:click="deleteBrick({{ $selectedBrickIndex }})"
                            wire:confirm="Supprimer cette brick ?"
                            class="rounded-md px-2 py-1 text-xs text-red-500 hover:bg-red-50 hover:text-red-700 transition">
                            🗑️
                        </button>
                    </div>

                    <form wire:submit="saveBrick" class="space-y-3">
                        <p class="flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest text-gray-300">
                            <span class="h-px flex-1 bg-gray-200"></span> Contenu <span class="h-px flex-1 bg-gray-200"></span>
                        </p>

                        @foreach($selectedBrick['content'] ?? [] as $key => $value)
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-400">
                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                </label>
                                @if(is_array($value))
                                    <div class="rounded-lg bg-gray-50 border border-dashed border-gray-200 p-2 text-xs text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                                        {{ count($value) }} élément(s) — éditez via le formulaire
                                    </div>
                                @elseif(strlen((string)$value) > 80)
                                    <textarea wire:model.defer="editingContent.content.{{ $key }}" rows="3"
                                        class="block w-full rounded-lg border-gray-200 bg-gray-50 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    ></textarea>
                                @else
                                    <input type="text" wire:model.defer="editingContent.content.{{ $key }}"
                                        class="block w-full rounded-lg border-gray-200 bg-gray-50 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    >
                                @endif
                            </div>
                        @endforeach

                        @if(!empty($selectedBrick['settings'] ?? []))
                            <p class="flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest text-gray-300 mt-4">
                                <span class="h-px flex-1 bg-gray-200"></span> Apparence <span class="h-px flex-1 bg-gray-200"></span>
                            </p>
                            @foreach($selectedBrick['settings'] ?? [] as $key => $value)
                                <div>
                                    <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-400">
                                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                                    </label>
                                    @if(is_bool($value))
                                        <label class="relative inline-flex cursor-pointer items-center">
                                            <input type="checkbox" wire:model.defer="editingContent.settings.{{ $key }}" class="peer sr-only">
                                            <div class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:bg-white after:transition-all peer-checked:bg-primary-600 peer-checked:after:translate-x-full dark:bg-gray-700"></div>
                                        </label>
                                    @elseif(str_starts_with((string)$value, '#'))
                                        <div class="flex items-center gap-2">
                                            <input type="color" wire:model.defer="editingContent.settings.{{ $key }}"
                                                class="h-8 w-12 cursor-pointer rounded border-gray-200">
                                            <input type="text" wire:model.defer="editingContent.settings.{{ $key }}"
                                                class="block w-full rounded-lg border-gray-200 bg-gray-50 text-xs font-mono dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </div>
                                    @else
                                        <input type="text" wire:model.defer="editingContent.settings.{{ $key }}"
                                            class="block w-full rounded-lg border-gray-200 bg-gray-50 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                        >
                                    @endif
                                </div>
                            @endforeach
                        @endif

                        <div class="pt-3 mt-2 border-t border-gray-100">
                            <x-filament::button type="submit" class="w-full">
                                💾 Enregistrer
                            </x-filament::button>
                        </div>
                    </form>
                @else
                    <div class="flex flex-col items-center justify-center py-20 text-gray-400">
                        <span class="text-3xl mb-2">👆</span>
                        <p class="text-sm font-medium">Sélectionnez une brick</p>
                        <p class="text-xs mt-1 text-center">Cliquez dans le canvas pour éditer</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- SortableJS init --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initSortable();
        });

        document.addEventListener('livewire:navigated', function() {
            initSortable();
        });

        function initSortable() {
            const el = document.getElementById('brick-sortable');
            if (!el || el._sortable) return;

            el._sortable = new Sortable(el, {
                handle: '.drag-handle',
                animation: 200,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                onEnd: function(evt) {
                    const items = el.querySelectorAll('[data-id]');
                    const orderedIds = Array.from(items).map(item => parseInt(item.dataset.id));
                    @this.call('reorderBricks', orderedIds);
                }
            });
        }
    </script>
</x-filament-panels::page>
