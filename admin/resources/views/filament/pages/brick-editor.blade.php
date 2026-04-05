<x-filament-panels::page>
    <style>
        .fi-page > .fi-page-content { max-width: 100% !important; }
        .sortable-ghost { opacity: 0.4; }
        .sortable-drag { box-shadow: 0 8px 24px rgba(0,0,0,0.15); transform: rotate(1deg); }
        .drag-handle { cursor: grab; }
        .drag-handle:active { cursor: grabbing; }
        .brick-editor-grid { display: grid; gap: 16px; min-height: 600px; }
        .brick-editor-grid.with-preview {
            grid-template-columns: 200px 1fr 380px 1fr;
        }
        .brick-editor-grid.without-preview {
            grid-template-columns: 200px 1fr 420px;
        }
        .preview-frame { border: none; width: 100%; height: 100%; min-height: 600px; border-radius: 0 0 8px 8px; }
        .brick-card { transition: all 0.15s ease; }
        .brick-card:hover { transform: translateY(-1px); }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>

    {{-- Header bar --}}
    <div class="mb-4 flex items-center justify-between rounded-xl bg-white px-5 py-3 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <a href="{{ url('/admin/pages') }}"
               class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Pages
            </a>
            <div>
                <h1 class="font-bold text-lg text-gray-900">{{ $page->name }}</h1>
                <span class="text-xs text-gray-400">neogtb.fr/{{ $page->slug === 'index' ? '' : $page->slug }}</span>
            </div>
            <span class="rounded-full bg-primary-50 px-2.5 py-0.5 text-xs font-semibold text-primary-700">
                {{ count($bricks) }} bloc{{ count($bricks) > 1 ? 's' : '' }}
            </span>
        </div>

        <div class="flex items-center gap-2">
            {{-- Toggle preview --}}
            <button wire:click="togglePreview"
                class="inline-flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-sm transition
                    {{ $showPreview
                        ? 'border-primary-300 bg-primary-50 text-primary-700'
                        : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Apercu
            </button>

            {{-- View on site --}}
            <a href="{{ $this->previewUrl }}" target="_blank"
               class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Voir le site
            </a>

            {{-- Publish --}}
            <button wire:click="publishPage" wire:loading.attr="disabled"
                class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-4 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition disabled:opacity-50">
                <svg wire:loading.remove wire:target="publishPage" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <svg wire:loading wire:target="publishPage" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                <span wire:loading.remove wire:target="publishPage">Publier</span>
                <span wire:loading wire:target="publishPage">Publication...</span>
            </button>
        </div>
    </div>

    {{-- Main layout --}}
    <div class="brick-editor-grid {{ $showPreview ? 'with-preview' : 'without-preview' }}">

        {{-- LEFT: Bibliothèque --}}
        <div>
            <div class="sticky top-4 rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
                <h3 class="mb-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">Ajouter un bloc</h3>

                @foreach($this->availableBricks as $category => $categoryBricks)
                    <div class="mb-3">
                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-300">{{ $category }}</p>
                        <div class="space-y-0.5">
                            @foreach($categoryBricks as $type => $brick)
                                <button
                                    wire:click="addBrick('{{ $type }}')"
                                    class="flex w-full items-center gap-2 rounded-lg px-2 py-1.5 text-left transition hover:bg-primary-50 group"
                                >
                                    <span class="text-sm shrink-0 grayscale group-hover:grayscale-0 transition">{{ $brick->icon() }}</span>
                                    <span class="text-xs font-medium text-gray-600 group-hover:text-primary-700">{{ $brick->name() }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- CENTER: Canvas --}}
        <div>
            <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-4" style="min-height: 580px;">
                @if(count($bricks) === 0)
                    <div class="flex flex-col items-center justify-center py-24 text-gray-400">
                        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <p class="text-sm font-medium">Page vide</p>
                        <p class="text-xs mt-1">Ajoutez des blocs depuis le menu de gauche</p>
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
                                class="brick-card group relative cursor-pointer rounded-lg border-2 bg-white p-3 transition-all
                                    {{ $isSelected
                                        ? 'border-primary-500 shadow-md ring-2 ring-primary-100'
                                        : 'border-transparent hover:border-gray-200 hover:shadow-sm' }}
                                    {{ !$brick['is_visible'] ? 'opacity-40' : '' }}"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="drag-handle flex h-7 w-7 items-center justify-center rounded text-gray-300 hover:bg-gray-100 hover:text-gray-500 transition" title="Glisser">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                                        </span>
                                        <span class="text-sm">{{ $def['icon'] ?? '?' }}</span>
                                        <div>
                                            <span class="font-medium text-sm text-gray-800">
                                                {{ $brick['brick_name'] ?: ($def['name'] ?? $brick['brick_type']) }}
                                            </span>
                                            @if($brick['is_locked'])
                                                <span class="ml-1 text-[10px]">🔒</span>
                                            @endif
                                            @if(!$brick['is_visible'])
                                                <span class="ml-1 text-[10px] text-gray-400">(masque)</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-0.5 opacity-0 group-hover:opacity-100 transition">
                                        @if($index > 0)
                                            <button wire:click.stop="moveBrick({{ $index }}, 'up')" class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition" title="Monter">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                            </button>
                                        @endif
                                        @if($index < count($bricks) - 1)
                                            <button wire:click.stop="moveBrick({{ $index }}, 'down')" class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition" title="Descendre">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </button>
                                        @endif
                                        <button wire:click.stop="duplicateBrick({{ $index }})" class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition" title="Dupliquer">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        </button>
                                        <button wire:click.stop="toggleVisibility({{ $index }})" class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition"
                                            title="{{ $brick['is_visible'] ? 'Masquer' : 'Afficher' }}">
                                            @if($brick['is_visible'])
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            @else
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l18 18"/></svg>
                                            @endif
                                        </button>
                                        @if(!$brick['is_locked'])
                                            <button wire:click.stop="deleteBrick({{ $index }})" wire:confirm="Supprimer ce bloc ?"
                                                class="rounded p-1 text-gray-400 hover:bg-red-50 hover:text-red-600 transition" title="Supprimer">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                @if($previewHtml)
                                    <div class="mt-2 border-t border-gray-50 pt-2 text-xs text-gray-500">
                                        {!! $previewHtml !!}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- RIGHT: Properties panel --}}
        <div>
            <div class="sticky top-4 rounded-xl border border-gray-200 bg-white shadow-sm" style="max-height: calc(100vh - 100px); overflow-y: auto;">
                @if($selectedBrickIndex !== null && isset($bricks[$selectedBrickIndex]))
                    @php
                        $selectedBrick = $bricks[$selectedBrickIndex];
                        $brickDef = \App\Filament\Bricks\BrickRegistry::get($selectedBrick['brick_type']);
                    @endphp

                    {{-- Panel header --}}
                    <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-100 bg-white px-4 py-3 rounded-t-xl">
                        <div class="flex items-center gap-2">
                            <span class="text-base">{{ $brickDef?->icon() ?? '?' }}</span>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800">{{ $selectedBrick['brick_name'] ?: ($brickDef?->name() ?? 'Bloc') }}</h3>
                                <p class="text-[10px] text-gray-400">{{ $brickDef?->description() }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form wire:submit="saveBrick" class="p-4 space-y-4">
                        {{-- Content fields --}}
                        <div>
                            <p class="flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3">
                                <span class="h-px flex-1 bg-gray-100"></span> Contenu <span class="h-px flex-1 bg-gray-100"></span>
                            </p>

                            <div class="space-y-3">
                                @foreach($selectedBrick['content'] ?? [] as $key => $value)
                                    <div>
                                        @php
                                            $label = ucfirst(str_replace('_', ' ', $key));
                                            $isLong = is_string($value) && strlen($value) > 100;
                                        @endphp
                                        <label class="mb-1 block text-xs font-semibold text-gray-600">{{ $label }}</label>

                                        @if(is_array($value))
                                            {{-- Array items --}}
                                            <div class="space-y-2" x-data="{ items: @entangle('editingContent.content.' . $key) }">
                                                <template x-for="(item, idx) in items" :key="idx">
                                                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <span class="text-[10px] font-bold uppercase text-gray-400" x-text="'#' + (idx + 1)"></span>
                                                            <button type="button" @click="items.splice(idx, 1)" class="text-xs text-red-400 hover:text-red-600">Supprimer</button>
                                                        </div>
                                                        <template x-if="typeof item === 'object' && item !== null">
                                                            <div class="space-y-2">
                                                                <template x-for="(val, subKey) in item" :key="subKey">
                                                                    <div>
                                                                        <label class="mb-0.5 block text-[10px] font-medium text-gray-500 capitalize" x-text="subKey.replace(/_/g, ' ')"></label>
                                                                        <template x-if="typeof val === 'string' && val.length > 80">
                                                                            <textarea x-model="items[idx][subKey]" rows="2"
                                                                                class="block w-full rounded-md border-gray-200 bg-white text-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                                                                        </template>
                                                                        <template x-if="typeof val !== 'string' || val.length <= 80">
                                                                            <input type="text" x-model="items[idx][subKey]"
                                                                                class="block w-full rounded-md border-gray-200 bg-white text-sm focus:border-primary-500 focus:ring-primary-500">
                                                                        </template>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                        </template>
                                                        <template x-if="typeof item === 'string'">
                                                            <input type="text" x-model="items[idx]"
                                                                class="block w-full rounded-md border-gray-200 bg-white text-sm focus:border-primary-500 focus:ring-primary-500">
                                                        </template>
                                                    </div>
                                                </template>
                                                <button type="button"
                                                    @click="
                                                        if (items.length > 0 && typeof items[0] === 'object') {
                                                            let template = {};
                                                            Object.keys(items[0]).forEach(k => template[k] = '');
                                                            items.push(JSON.parse(JSON.stringify(template)));
                                                        } else {
                                                            items.push('');
                                                        }
                                                    "
                                                    class="w-full rounded-lg border border-dashed border-gray-300 py-2 text-xs text-gray-500 hover:border-primary-400 hover:text-primary-600 transition">
                                                    + Ajouter un element
                                                </button>
                                            </div>
                                        @elseif($key === 'contenu')
                                            <textarea wire:model.defer="editingContent.content.{{ $key }}" rows="8"
                                                class="block w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-primary-500 focus:ring-primary-500"
                                                placeholder="Contenu HTML..."></textarea>
                                        @elseif($isLong)
                                            <textarea wire:model.defer="editingContent.content.{{ $key }}" rows="3"
                                                class="block w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                                        @elseif($key === 'image')
                                            <input type="text" wire:model.defer="editingContent.content.{{ $key }}"
                                                class="block w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-primary-500 focus:ring-primary-500"
                                                placeholder="/images/...">
                                        @else
                                            <input type="text" wire:model.defer="editingContent.content.{{ $key }}"
                                                class="block w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-primary-500 focus:ring-primary-500">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Settings fields --}}
                        @if(!empty($selectedBrick['settings'] ?? []))
                            <div>
                                <p class="flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3">
                                    <span class="h-px flex-1 bg-gray-100"></span> Apparence <span class="h-px flex-1 bg-gray-100"></span>
                                </p>
                                <div class="space-y-3">
                                    @foreach($selectedBrick['settings'] ?? [] as $key => $value)
                                        <div>
                                            <label class="mb-1 block text-xs font-semibold text-gray-600">
                                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                                            </label>
                                            @if(is_bool($value))
                                                <label class="relative inline-flex cursor-pointer items-center">
                                                    <input type="checkbox" wire:model.defer="editingContent.settings.{{ $key }}" class="peer sr-only">
                                                    <div class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:bg-primary-600 peer-checked:after:translate-x-full"></div>
                                                </label>
                                            @elseif(is_string($value) && str_starts_with($value, '#'))
                                                <div class="flex items-center gap-2">
                                                    <input type="color" wire:model.defer="editingContent.settings.{{ $key }}" class="h-8 w-12 cursor-pointer rounded border-gray-200">
                                                    <input type="text" wire:model.defer="editingContent.settings.{{ $key }}"
                                                        class="block flex-1 rounded-md border-gray-200 bg-gray-50 text-xs font-mono focus:border-primary-500 focus:ring-primary-500">
                                                </div>
                                            @else
                                                <input type="text" wire:model.defer="editingContent.settings.{{ $key }}"
                                                    class="block w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-primary-500 focus:ring-primary-500">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Save button --}}
                        <div class="pt-2 border-t border-gray-100">
                            <button type="submit"
                                class="w-full rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Enregistrer le bloc
                            </button>
                        </div>
                    </form>
                @else
                    <div class="flex flex-col items-center justify-center py-24 text-gray-400 px-6">
                        <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Selectionnez un bloc</p>
                        <p class="text-xs mt-1 text-center text-gray-400">Cliquez sur un bloc dans le canvas pour le modifier</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- PREVIEW (conditional) --}}
        @if($showPreview)
            <div>
                <div class="sticky top-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden" style="height: calc(100vh - 100px);">
                    <div class="flex items-center justify-between border-b border-gray-100 bg-gray-50 px-3 py-2">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Apercu du site</span>
                        <button onclick="document.getElementById('preview-iframe').src = document.getElementById('preview-iframe').src"
                            class="rounded p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-700 transition" title="Rafraichir">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </button>
                    </div>
                    <iframe id="preview-iframe" src="{{ $this->previewUrl }}" style="border: none; width: 100%; height: calc(100% - 36px); border-radius: 0 0 8px 8px;"></iframe>
                </div>
            </div>
        @endif
    </div>

    {{-- SortableJS --}}
    <script>
        document.addEventListener('DOMContentLoaded', initSortable);
        document.addEventListener('livewire:navigated', initSortable);

        function initSortable() {
            const el = document.getElementById('brick-sortable');
            if (!el || el._sortable) return;

            el._sortable = new Sortable(el, {
                handle: '.drag-handle',
                animation: 200,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                onEnd: function() {
                    const items = el.querySelectorAll('[data-id]');
                    const orderedIds = Array.from(items).map(item => parseInt(item.dataset.id));
                    @this.call('reorderBricks', orderedIds);
                }
            });
        }
    </script>
</x-filament-panels::page>
