<div>
    {{-- TOPBAR --}}
    <div class="topbar">
        <div style="display: flex; align-items: center; gap: 16px;">
            <span class="topbar-brand">NeoGTB</span>
            <a href="{{ route('filament.admin.resources.pages.edit', $page->id) }}">← Retour</a>
            <span class="topbar-page">{{ $page->name }}</span>
            <span style="background: rgba(255,255,255,0.15); padding: 2px 10px; border-radius: 20px; font-size: 12px;">
                {{ count($bricks) }} bloc(s)
            </span>
        </div>
        <div class="topbar-actions">
            <a href="/{{ $page->slug }}" target="_blank">Voir le site ↗</a>
        </div>
    </div>

    {{-- 3 COLUMNS --}}
    <div class="editor-container">

        {{-- LEFT: Bibliothèque --}}
        <div class="panel-left">
            <div class="panel-title">Bibliothèque</div>
            @foreach($availableBricks as $category => $categoryBricks)
                <div class="brick-category">{{ $category }}</div>
                @foreach($categoryBricks as $type => $brick)
                    <button wire:click="addBrick('{{ $type }}')" class="brick-btn">
                        <span class="icon">{{ $brick->icon() }}</span>
                        <div>
                            <div class="label">{{ $brick->name() }}</div>
                            <div class="desc">{{ $brick->description() }}</div>
                        </div>
                    </button>
                @endforeach
            @endforeach
        </div>

        {{-- CENTER: Canvas --}}
        <div class="panel-center">
            <div class="canvas-header">Canvas</div>

            @if(count($bricks) === 0)
                <div class="canvas-empty">
                    <div class="icon">🧱</div>
                    <div style="font-weight: 600; font-size: 14px;">Page vide</div>
                    <div style="font-size: 12px; margin-top: 4px;">Ajoutez un bloc depuis la bibliothèque</div>
                </div>
            @else
                <div id="brick-sortable">
                    @foreach($bricks as $brick)
                        @php
                            $def = \App\Filament\Bricks\BrickRegistry::get($brick['type']);
                            $preview = $def ? strip_tags($def->preview($brick['content'])) : '';
                        @endphp
                        <div
                            data-id="{{ $brick['id'] }}"
                            wire:click="selectBrick({{ $brick['id'] }})"
                            class="brick-card {{ $selectedBrickId === $brick['id'] ? 'selected' : '' }} {{ !$brick['visible'] ? 'hidden' : '' }}"
                        >
                            <div class="brick-card-left">
                                <div class="drag-handle" title="Glisser pour réordonner">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                                </div>
                                <div class="brick-card-icon">{{ $def?->icon() ?? '🧱' }}</div>
                                <div>
                                    <div class="brick-card-name">{{ $def?->name() ?? $brick['type'] }}</div>
                                    @if($preview)
                                        <div class="brick-card-preview">{{ \Illuminate\Support\Str::limit($preview, 50) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="brick-card-actions">
                                <button wire:click.stop="toggleVisibility({{ $brick['id'] }})" class="brick-action" title="{{ $brick['visible'] ? 'Masquer' : 'Afficher' }}">
                                    {{ $brick['visible'] ? '👁' : '🚫' }}
                                </button>
                                <button wire:click.stop="deleteBrick({{ $brick['id'] }})" wire:confirm="Supprimer ce bloc ?" class="brick-action danger" title="Supprimer">
                                    🗑
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- RIGHT: Propriétés --}}
        <div class="panel-right">
            @if($selectedBrick)
                @php $def = \App\Filament\Bricks\BrickRegistry::get($selectedBrick['type']); @endphp
                <div class="props-header">
                    <span class="props-title">{{ $def?->icon() }} {{ $def?->name() }}</span>
                    <button wire:click="deleteBrick({{ $selectedBrick['id'] }})" wire:confirm="Supprimer ?" class="brick-action danger">🗑</button>
                </div>

                <form wire:submit="saveBrick">
                    <div class="props-section">Contenu</div>
                    @foreach($selectedBrick['content'] ?? [] as $key => $value)
                        <div class="field-group">
                            <div class="field-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</div>
                            @if(is_array($value))
                                <div class="field-complex">{{ count($value) }} élément(s)</div>
                            @elseif(strlen((string)$value) > 80)
                                <textarea wire:model.defer="editForm.content.{{ $key }}" class="field-input" rows="3"></textarea>
                            @else
                                <input type="text" wire:model.defer="editForm.content.{{ $key }}" class="field-input">
                            @endif
                        </div>
                    @endforeach

                    @if(!empty($selectedBrick['settings'] ?? []))
                        <div class="props-section">Apparence</div>
                        @foreach($selectedBrick['settings'] ?? [] as $key => $value)
                            <div class="field-group">
                                <div class="field-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</div>
                                @if(is_bool($value))
                                    <input type="checkbox" wire:model.defer="editForm.settings.{{ $key }}">
                                @elseif(str_starts_with((string)$value, '#'))
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <input type="color" wire:model.defer="editForm.settings.{{ $key }}" style="width: 40px; height: 32px; border: 1px solid #E2E8F0; border-radius: 6px; cursor: pointer;">
                                        <input type="text" wire:model.defer="editForm.settings.{{ $key }}" class="field-input" style="font-family: monospace; font-size: 12px;">
                                    </div>
                                @else
                                    <input type="text" wire:model.defer="editForm.settings.{{ $key }}" class="field-input">
                                @endif
                            </div>
                        @endforeach
                    @endif

                    <button type="submit" class="btn-save" style="width: 100%; margin-top: 16px;">
                        💾 Enregistrer
                    </button>
                </form>
            @else
                <div class="panel-empty">
                    <div class="icon">👆</div>
                    <div style="font-weight: 600; font-size: 13px;">Sélectionnez un bloc</div>
                    <div style="font-size: 12px; margin-top: 4px;">Cliquez dans le canvas pour éditer</div>
                </div>
            @endif
        </div>
    </div>

    {{-- SortableJS --}}
    <script>
        document.addEventListener('livewire:navigated', initSort);
        document.addEventListener('DOMContentLoaded', initSort);
        function initSort() {
            const el = document.getElementById('brick-sortable');
            if (!el || el._sortable) return;
            el._sortable = new Sortable(el, {
                handle: '.drag-handle',
                animation: 200,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                onEnd: function() {
                    const ids = Array.from(el.querySelectorAll('[data-id]')).map(e => parseInt(e.dataset.id));
                    @this.call('reorderBricks', ids);
                }
            });
        }

        Livewire.on('notify', ({ message }) => {
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        });
    </script>
</div>
