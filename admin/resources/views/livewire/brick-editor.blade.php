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
            <div style="display: flex; gap: 8px;">
                <button onclick="togglePreview()" class="topbar-preview-btn" id="preview-toggle">👁 Preview</button>
                <a href="/{{ $page->slug }}" target="_blank">Voir le site ↗</a>
            </div>
        </div>
    </div>

    {{-- PREVIEW PANEL (hidden by default) --}}
    <div id="preview-panel" style="display: none; position: fixed; top: 56px; right: 0; width: 50%; height: calc(100vh - 56px); z-index: 40; background: white; border-left: 2px solid #E2E8F0; box-shadow: -4px 0 24px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 16px; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
            <span style="font-size: 12px; font-weight: 600; color: #64748B;">PREVIEW EN DIRECT</span>
            <div style="display: flex; gap: 4px;">
                <button onclick="setPreviewSize('100%')" style="padding: 2px 8px; border: 1px solid #E2E8F0; border-radius: 4px; background: white; cursor: pointer; font-size: 11px;">Desktop</button>
                <button onclick="setPreviewSize('390px')" style="padding: 2px 8px; border: 1px solid #E2E8F0; border-radius: 4px; background: white; cursor: pointer; font-size: 11px;">Mobile</button>
                <button onclick="togglePreview()" style="padding: 2px 8px; border: none; background: none; cursor: pointer; font-size: 14px;">✕</button>
            </div>
        </div>
        <iframe id="preview-iframe" src="/{{ $page->slug === 'accueil' ? '' : $page->slug }}" style="width: 100%; height: calc(100% - 40px); border: none;"></iframe>
    </div>

    {{-- 3 COLUMNS --}}
    <div class="editor-container" id="editor-container">

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
                                {{-- Array fields (cartes, stats, etc.) --}}
                                <div class="field-complex">{{ count($value) }} élément(s) — modifier via l'admin Filament</div>

                            @elseif(str_contains($key, 'image') || str_contains($key, 'logo'))
                                {{-- Image upload field --}}
                                @if(!empty($value))
                                    <div style="margin-bottom: 8px; position: relative;">
                                        <img src="{{ asset('storage/' . $value) }}" alt="" style="width: 100%; max-height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid #E2E8F0;">
                                        <button type="button" wire:click="$set('editForm.content.{{ $key }}', '')" style="position: absolute; top: 4px; right: 4px; background: rgba(0,0,0,0.6); color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 12px;">✕</button>
                                    </div>
                                @endif
                                <div style="border: 2px dashed #E2E8F0; border-radius: 8px; padding: 12px; text-align: center; background: #FAFBFC;">
                                    <input type="file" wire:model="imageUpload" accept="image/*"
                                        style="font-size: 12px; width: 100%;"
                                        wire:click="setImageField('{{ $key }}')">
                                    <div wire:loading wire:target="imageUpload" style="margin-top: 8px; font-size: 12px; color: #2D8B4E; font-weight: 600;">
                                        ⏳ Upload en cours...
                                    </div>
                                </div>

                            @elseif(str_contains($key, 'contenu') || str_contains($key, 'description') && strlen((string)$value) > 100)
                                {{-- Rich text field --}}
                                <div style="border: 1px solid #E2E8F0; border-radius: 8px; overflow: hidden;">
                                    <div style="background: #F8FAFC; padding: 4px 8px; border-bottom: 1px solid #E2E8F0; display: flex; gap: 2px;">
                                        <button type="button" onclick="wrapSelection(this, 'b')" style="padding: 2px 6px; border: none; background: none; cursor: pointer; font-weight: bold; font-size: 13px;" title="Gras">B</button>
                                        <button type="button" onclick="wrapSelection(this, 'i')" style="padding: 2px 6px; border: none; background: none; cursor: pointer; font-style: italic; font-size: 13px;" title="Italique">I</button>
                                        <button type="button" onclick="wrapSelection(this, 'strong')" style="padding: 2px 6px; border: none; background: none; cursor: pointer; font-size: 13px;" title="Important">S</button>
                                    </div>
                                    <textarea wire:model.defer="editForm.content.{{ $key }}" class="field-input" rows="5" style="border: none; border-radius: 0;"></textarea>
                                </div>

                            @elseif(strlen((string)$value) > 60)
                                {{-- Long text --}}
                                <textarea wire:model.defer="editForm.content.{{ $key }}" class="field-input" rows="3"></textarea>

                            @else
                                {{-- Short text --}}
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

        // Preview toggle
        function togglePreview() {
            const panel = document.getElementById('preview-panel');
            const container = document.getElementById('editor-container');
            const btn = document.getElementById('preview-toggle');
            if (panel.style.display === 'none') {
                panel.style.display = 'block';
                container.style.marginRight = '50%';
                btn.textContent = '✕ Fermer preview';
                refreshPreview();
            } else {
                panel.style.display = 'none';
                container.style.marginRight = '0';
                btn.textContent = '👁 Preview';
            }
        }
        window.togglePreview = togglePreview;

        function setPreviewSize(w) {
            document.getElementById('preview-iframe').style.maxWidth = w;
            document.getElementById('preview-iframe').style.margin = w !== '100%' ? '0 auto' : '0';
        }
        window.setPreviewSize = setPreviewSize;

        function refreshPreview() {
            const iframe = document.getElementById('preview-iframe');
            if (iframe) iframe.src = iframe.src;
        }

        // Auto-refresh preview after save
        Livewire.on('notify', ({ message }) => {
            if (message.includes('enregistr') || message.includes('upload')) {
                setTimeout(refreshPreview, 500);
            }
        });

        // Rich text helper
        function wrapSelection(btn, tag) {
            const textarea = btn.closest('.field-group')?.querySelector('textarea');
            if (!textarea) return;
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;
            const selected = text.substring(start, end);
            const wrapped = '<' + tag + '>' + selected + '</' + tag + '>';
            textarea.value = text.substring(0, start) + wrapped + text.substring(end);
            textarea.dispatchEvent(new Event('input'));
        }
        window.wrapSelection = wrapSelection;

        Livewire.on('notify', ({ message }) => {
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        });
    </script>
</div>
