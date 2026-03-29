<x-filament-panels::page>
    <form wire:submit="save">

        <div class="hp-layout">

            {{-- ====== COLONNE GAUCHE : FORMULAIRE ====== --}}
            <div class="hp-form">

                {{-- SECTION 1 : Image --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-icon" style="background: #DBEAFE; color: #2563EB;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v13.5a1.5 1.5 0 0 0 1.5 1.5Z" /></svg>
                        </div>
                        <div>
                            <h3 class="hp-card-title">Image de fond</h3>
                            <p class="hp-card-desc">L'image en arrière-plan tout en haut du site</p>
                        </div>
                    </div>

                    @if($current_image)
                        <div class="hp-current-image">
                            <img src="{{ $current_image }}" alt="Image actuelle">
                        </div>
                    @endif

                    <div class="hp-field" x-data="{ uploading: false, progress: 0 }"
                         x-on:livewire-upload-start="uploading = true"
                         x-on:livewire-upload-finish="uploading = false; progress = 0"
                         x-on:livewire-upload-cancel="uploading = false"
                         x-on:livewire-upload-error="uploading = false"
                         x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <label class="hp-label">Changer l'image</label>
                        <label class="hp-upload-zone">
                            <input type="file" wire:model="hero_image" accept="image/jpeg,image/png,image/webp" class="sr-only">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" style="color: #94a3b8;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" /></svg>
                            <span style="font-size: 0.8rem; font-weight: 600; color: #475569;">Cliquez pour choisir une image</span>
                            <span style="font-size: 0.72rem; color: #94a3b8;">JPG, PNG ou WebP — 10 Mo max</span>
                        </label>
                        <div x-show="uploading" class="hp-progress-bar">
                            <div class="hp-progress-fill" x-bind:style="'width: ' + progress + '%'"></div>
                        </div>
                        @if($hero_image)
                            <p class="hp-success">Image prête. Cliquez sur « Enregistrer » pour l'appliquer.</p>
                        @endif
                        @error('hero_image') <span class="hp-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="hp-field">
                        <label class="hp-label">Description de l'image</label>
                        <input type="text" wire:model="image_alt" class="hp-input" placeholder="Ex : Salle technique avec armoire GTB">
                        <p class="hp-hint">Pour le référencement Google et l'accessibilité</p>
                    </div>
                </div>

                {{-- SECTION 2 : Textes --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-icon" style="background: #FEF3C7; color: #D97706;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                        </div>
                        <div>
                            <h3 class="hp-card-title">Textes d'accroche</h3>
                            <p class="hp-card-desc">Ce que les visiteurs voient en premier sur votre site</p>
                        </div>
                    </div>

                    <div class="hp-field">
                        <label class="hp-label">Petit texte en haut <span class="hp-label-tag">Badge</span></label>
                        <input type="text" wire:model.live.debounce.300ms="badge" class="hp-input" placeholder="Ex : Décret BACS 2027 · Êtes-vous en conformité ?">
                        <p class="hp-hint">Attire l'attention au-dessus du titre</p>
                    </div>

                    <div class="hp-field">
                        <label class="hp-label">Titre principal</label>
                        <input type="text" wire:model.live.debounce.300ms="title_text" class="hp-input hp-input-lg" placeholder="Ex : Votre bâtiment consomme trop. On vous montre où et pourquoi.">
                        <p class="hp-hint">La phrase d'accroche — c'est la première chose que les visiteurs lisent</p>
                    </div>

                    <div class="hp-field">
                        <label class="hp-label">Texte d'accompagnement</label>
                        <textarea wire:model.live.debounce.300ms="description" rows="3" class="hp-input" placeholder="Ex : Diagnostic EN 15232 gratuit, comparateur de solutions sans biais commercial..."></textarea>
                        <p class="hp-hint">Un court paragraphe qui complète le titre</p>
                    </div>
                </div>

                {{-- SECTION 3 : Boutons --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-icon" style="background: #F0FDF4; color: #16A34A;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" /></svg>
                        </div>
                        <div>
                            <h3 class="hp-card-title">Boutons d'action</h3>
                            <p class="hp-card-desc">Les boutons qui incitent vos visiteurs à passer à l'action</p>
                        </div>
                    </div>

                    <div class="hp-btn-group">
                        <p class="hp-btn-group-label">Bouton principal</p>
                        <div class="hp-field-row">
                            <div class="hp-field" style="flex: 1;">
                                <label class="hp-label">Texte affiché</label>
                                <input type="text" wire:model.live.debounce.300ms="cta_text" class="hp-input" placeholder="Diagnostiquer mon bâtiment">
                            </div>
                            <div class="hp-field" style="flex: 1;">
                                <label class="hp-label">Vers quelle page ?</label>
                                <input type="text" wire:model.live.debounce.300ms="cta_url" class="hp-input" placeholder="/audit">
                            </div>
                        </div>
                    </div>

                    <div class="hp-btn-group">
                        <p class="hp-btn-group-label">Bouton secondaire</p>
                        <div class="hp-field-row">
                            <div class="hp-field" style="flex: 1;">
                                <label class="hp-label">Texte affiché</label>
                                <input type="text" wire:model.live.debounce.300ms="cta2_text" class="hp-input" placeholder="Comparer les solutions GTB">
                            </div>
                            <div class="hp-field" style="flex: 1;">
                                <label class="hp-label">Vers quelle page ?</label>
                                <input type="text" wire:model.live.debounce.300ms="cta2_url" class="hp-input" placeholder="/comparateur">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BOUTON SAUVEGARDER --}}
                <div class="hp-save-bar">
                    <button type="submit" class="hp-save-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </div>

            {{-- ====== COLONNE DROITE : APERÇU EN DIRECT ====== --}}
            <div class="hp-preview-col">
                <div class="hp-preview-sticky">
                    <div class="hp-preview-header">
                        <div class="hp-preview-dot"></div>
                        <div class="hp-preview-dot"></div>
                        <div class="hp-preview-dot"></div>
                        <span class="hp-preview-url">neogtb.fr</span>
                    </div>
                    <div class="hp-preview-body">
                        {{-- Simulation du hero --}}
                        <div class="hp-hero-preview" style="background-image: url('{{ $current_image }}');">
                            <div class="hp-hero-overlay"></div>
                            <div class="hp-hero-content">
                                @if($badge)
                                    <span class="hp-hero-badge">{{ $badge }}</span>
                                @endif

                                <p class="hp-hero-brand">Néo<span>GTB</span></p>

                                <h2 class="hp-hero-title">{{ $title_text ?: 'Votre titre ici...' }}</h2>

                                @if($description)
                                    <p class="hp-hero-desc">{{ $description }}</p>
                                @endif

                                <div class="hp-hero-buttons">
                                    @if($cta_text)
                                        <span class="hp-hero-btn-primary">{{ $cta_text }} →</span>
                                    @endif
                                    @if($cta2_text)
                                        <span class="hp-hero-btn-secondary">{{ $cta2_text }} →</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="hp-preview-label">Aperçu en direct</p>
                </div>
            </div>
        </div>
    </form>

    <style>
        /* ========== LAYOUT ========== */
        .hp-layout {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 2rem;
            align-items: start;
        }

        @media (max-width: 1200px) {
            .hp-layout {
                grid-template-columns: 1fr;
            }
            .hp-preview-col { order: -1; }
        }

        .hp-form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        /* ========== CARDS ========== */
        .hp-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.5rem;
        }

        .dark .hp-card {
            background: rgb(17 24 39);
            border-color: rgb(55 65 81);
        }

        .hp-card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .dark .hp-card-header {
            border-bottom-color: rgb(55 65 81);
        }

        .hp-card-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .hp-card-title {
            font-size: 0.925rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            line-height: 1.3;
        }

        .dark .hp-card-title { color: #f1f5f9; }

        .hp-card-desc {
            font-size: 0.78rem;
            color: #94a3b8;
            margin: 0.1rem 0 0;
            line-height: 1.3;
        }

        /* ========== FIELDS ========== */
        .hp-field {
            margin-bottom: 1rem;
        }

        .hp-field:last-child {
            margin-bottom: 0;
        }

        .hp-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.35rem;
        }

        .dark .hp-label { color: #cbd5e1; }

        .hp-label-tag {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 500;
            color: #94a3b8;
            background: #f1f5f9;
            padding: 1px 6px;
            border-radius: 4px;
            margin-left: 4px;
            vertical-align: middle;
        }

        .dark .hp-label-tag {
            background: rgb(55 65 81);
            color: #94a3b8;
        }

        .hp-input {
            display: block;
            width: 100%;
            padding: 0.55rem 0.75rem;
            font-size: 0.85rem;
            color: #1e293b;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 9px;
            transition: all 0.15s ease;
            outline: none;
        }

        .dark .hp-input {
            background: rgb(31 41 55);
            border-color: rgb(75 85 99);
            color: #f1f5f9;
        }

        .hp-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .hp-input-lg {
            font-size: 0.95rem;
            font-weight: 600;
            padding: 0.65rem 0.75rem;
        }

        textarea.hp-input {
            resize: vertical;
            min-height: 70px;
        }

        .hp-hint {
            font-size: 0.72rem;
            color: #94a3b8;
            margin: 0.3rem 0 0;
            line-height: 1.3;
        }

        .hp-error {
            font-size: 0.78rem;
            color: #ef4444;
            margin-top: 0.2rem;
            display: block;
        }

        .hp-upload-zone {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
            padding: 1.25rem;
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.15s;
            text-align: center;
            background: #fafbfc;
        }

        .dark .hp-upload-zone {
            background: rgb(31 41 55);
            border-color: rgb(75 85 99);
        }

        .hp-upload-zone:hover {
            border-color: #93c5fd;
            background: #f0f7ff;
        }

        .dark .hp-upload-zone:hover {
            border-color: #3b82f6;
            background: rgb(30 58 92 / 0.3);
        }

        .hp-progress-bar {
            height: 4px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .hp-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            border-radius: 4px;
            transition: width 0.15s;
        }

        .hp-success {
            font-size: 0.78rem;
            color: #16a34a;
            font-weight: 600;
            margin-top: 0.4rem;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .hp-field-row {
            display: flex;
            gap: 0.75rem;
        }

        @media (max-width: 640px) {
            .hp-field-row { flex-direction: column; }
        }

        /* ========== BUTTON GROUPS ========== */
        .hp-btn-group {
            padding: 1rem;
            background: #f8fafc;
            border-radius: 10px;
            margin-bottom: 0.75rem;
        }

        .hp-btn-group:last-of-type {
            margin-bottom: 0;
        }

        .dark .hp-btn-group {
            background: rgb(31 41 55);
        }

        .hp-btn-group-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            margin: 0 0 0.6rem;
        }

        /* ========== CURRENT IMAGE ========== */
        .hp-current-image {
            margin-bottom: 1rem;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .dark .hp-current-image {
            border-color: rgb(75 85 99);
        }

        .hp-current-image img {
            display: block;
            width: 100%;
            height: 140px;
            object-fit: cover;
        }

        /* ========== SAVE BAR ========== */
        .hp-save-bar {
            display: flex;
            justify-content: flex-end;
        }

        .hp-save-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.5rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, #1B3A5C, #2D5F8A);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(27, 58, 92, 0.25);
        }

        .hp-save-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(27, 58, 92, 0.35);
        }

        /* ========== PREVIEW ========== */
        .hp-preview-col {
            min-width: 0;
        }

        .hp-preview-sticky {
            position: sticky;
            top: 5rem;
        }

        .hp-preview-header {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 10px 14px;
            background: #1e293b;
            border-radius: 12px 12px 0 0;
        }

        .hp-preview-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #334155;
        }

        .hp-preview-dot:nth-child(1) { background: #ef4444; }
        .hp-preview-dot:nth-child(2) { background: #f59e0b; }
        .hp-preview-dot:nth-child(3) { background: #22c55e; }

        .hp-preview-url {
            font-size: 0.7rem;
            color: #94a3b8;
            margin-left: 8px;
            background: #0f172a;
            padding: 3px 12px;
            border-radius: 6px;
            flex: 1;
            text-align: center;
        }

        .hp-preview-body {
            border: 1px solid #334155;
            border-top: none;
            border-radius: 0 0 12px 12px;
            overflow: hidden;
            background: #0f172a;
        }

        .hp-preview-label {
            text-align: center;
            font-size: 0.72rem;
            color: #94a3b8;
            margin-top: 0.6rem;
            font-weight: 500;
        }

        /* ========== HERO PREVIEW ========== */
        .hp-hero-preview {
            position: relative;
            min-height: 360px;
            display: flex;
            align-items: center;
            background-size: cover;
            background-position: center;
            background-color: #1e293b;
        }

        .hp-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to left, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.45) 50%, rgba(0,0,0,0.15) 100%);
        }

        .hp-hero-content {
            position: relative;
            z-index: 1;
            padding: 2rem 1.5rem;
            max-width: 320px;
            margin-left: auto;
        }

        .hp-hero-badge {
            display: inline-block;
            font-size: 0.55rem;
            font-weight: 500;
            color: rgba(255,255,255,0.85);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(8px);
            padding: 3px 10px;
            border-radius: 12px;
            border: 0.5px solid rgba(255,255,255,0.15);
            margin-bottom: 0.75rem;
        }

        .hp-hero-brand {
            font-size: 0.85rem;
            font-weight: 500;
            color: rgba(255,255,255,0.5);
            margin: 0 0 0.4rem;
        }

        .hp-hero-brand span {
            color: #ffffff;
            font-weight: 600;
        }

        .hp-hero-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin: 0 0 0.6rem;
        }

        .hp-hero-desc {
            font-size: 0.68rem;
            color: rgba(255,255,255,0.55);
            line-height: 1.6;
            margin: 0 0 1rem;
        }

        .hp-hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .hp-hero-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.65rem;
            font-weight: 600;
            color: #ffffff;
            background: #2D8B4E;
            padding: 5px 12px;
            border-radius: 7px;
        }

        .hp-hero-btn-secondary {
            font-size: 0.65rem;
            font-weight: 500;
            color: rgba(255,255,255,0.5);
            padding: 5px 0;
        }
    </style>
</x-filament-panels::page>
