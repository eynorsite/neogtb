<x-filament-panels::page>
    <style>
        .settings-layout { display: flex !important; gap: 24px; }
        .settings-nav { width: 240px; min-width: 240px; flex-shrink: 0; }
        .settings-content { flex: 1; min-width: 0; }
        .nav-btn {
            display: flex; width: 100%; align-items: center; gap: 12px;
            padding: 10px 14px; border-radius: 10px; border: none;
            font-size: 13px; font-weight: 500; text-align: left;
            cursor: pointer; transition: all 0.15s; font-family: inherit;
            background: transparent; color: #64748B;
        }
        .nav-btn:hover { background: #F1F5F9; color: #1E293B; }
        .nav-btn.active {
            background: linear-gradient(135deg, #1B3A5C08, #2D8B4E10);
            color: #1B3A5C; font-weight: 600;
            border-left: 3px solid #2D8B4E;
        }
        .nav-btn .nav-emoji { font-size: 18px; width: 24px; text-align: center; }
        .nav-btn .nav-label { flex: 1; }
        .nav-btn .nav-badge {
            font-size: 10px; font-weight: 600; padding: 2px 6px;
            border-radius: 10px; background: #F1F5F9; color: #94A3B8;
        }
        .nav-btn.active .nav-badge { background: #2D8B4E20; color: #2D8B4E; }
        .field-row { margin-bottom: 16px; }
        .field-label-pro {
            display: block; font-size: 13px; font-weight: 600;
            color: #334155; margin-bottom: 6px;
        }
        .field-label-pro .required { color: #EF4444; margin-left: 2px; }
        .field-hint { font-size: 11px; color: #94A3B8; margin-top: 4px; }
        .field-input-pro {
            width: 100%; padding: 10px 14px; border: 1px solid #E2E8F0;
            border-radius: 10px; font-size: 13px; font-family: inherit;
            background: #FAFBFC; transition: all 0.15s;
        }
        .field-input-pro:focus {
            border-color: #1B3A5C; background: white;
            box-shadow: 0 0 0 3px rgba(27,58,92,0.08); outline: none;
        }
        textarea.field-input-pro { resize: vertical; min-height: 80px; }
        .section-title {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.08em; color: #94A3B8; margin: 24px 0 12px;
            display: flex; align-items: center; gap: 8px;
        }
        .section-title::after { content: ''; flex: 1; height: 1px; background: #F1F5F9; }
        .section-title:first-child { margin-top: 0; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 768px) { .settings-layout { flex-direction: column; } .settings-nav { width: 100%; } .grid-2 { grid-template-columns: 1fr; } }
    </style>

    <div class="settings-layout">
        {{-- SIDEBAR --}}
        <nav class="settings-nav">
            <div style="position: sticky; top: 80px;">
                @foreach($this->tabs as $key => $tab)
                    @php
                        $count = $this->getSettingsForGroup($key)->count();
                    @endphp
                    <button wire:click="switchTab('{{ $key }}')" class="nav-btn {{ $activeTab === $key ? 'active' : '' }}">
                        <span class="nav-emoji">{{ $tab['emoji'] }}</span>
                        <span class="nav-label">{{ $tab['label'] }}</span>
                        <span class="nav-badge">{{ $count }}</span>
                    </button>
                @endforeach
            </div>
        </nav>

        {{-- CONTENT --}}
        <div class="settings-content">
            <form wire:submit="save">

                @foreach($this->getSettingsForGroup($activeTab)->groupBy(function($s) {
                    // Group by sub-category based on key prefix
                    $parts = explode('_', $s->key, 3);
                    return ucfirst($parts[1] ?? $this->activeTab);
                }) as $groupName => $groupSettings)

                    <div class="section-title">{{ $groupName }}</div>

                    <div class="{{ $groupSettings->count() > 1 && $groupSettings->every(fn($s) => $s->type !== 'textarea' && $s->type !== 'json') ? 'grid-2' : '' }}">
                        @foreach($groupSettings as $setting)
                            <div class="field-row">
                                <label class="field-label-pro">
                                    {{ $setting->label }}
                                    @if($setting->is_required)<span class="required">*</span>@endif
                                    @if($setting->is_encrypted)
                                        @if(filled($settings[$setting->key] ?? ''))
                                            <span style="font-size: 10px; color: #2D8B4E; margin-left: 6px;">✅ Configuré</span>
                                        @else
                                            <span style="font-size: 10px; color: #F59E0B; margin-left: 6px;">⚠️ Non configuré</span>
                                        @endif
                                    @endif
                                </label>

                                @if($setting->type === 'boolean')
                                    <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                                        <input type="checkbox" wire:model.defer="settings.{{ $setting->key }}" value="1"
                                            style="width: 18px; height: 18px; accent-color: #2D8B4E; cursor: pointer;">
                                        <span style="font-size: 13px; color: #64748B;">Activé</span>
                                    </label>

                                @elseif($setting->type === 'color')
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <input type="color" wire:model.defer="settings.{{ $setting->key }}"
                                            style="width: 44px; height: 36px; border: 1px solid #E2E8F0; border-radius: 8px; cursor: pointer; padding: 2px;">
                                        <input type="text" wire:model.defer="settings.{{ $setting->key }}" class="field-input-pro"
                                            style="font-family: monospace; font-size: 12px;" placeholder="#000000">
                                        @if(filled($settings[$setting->key] ?? ''))
                                            <span style="display: inline-block; width: 24px; height: 24px; border-radius: 6px; border: 1px solid #E2E8F0; background: {{ $settings[$setting->key] }};"></span>
                                        @endif
                                    </div>

                                @elseif($setting->type === 'textarea' || $setting->type === 'json')
                                    <textarea wire:model.defer="settings.{{ $setting->key }}" rows="3" class="field-input-pro"
                                        placeholder="{{ $setting->description ?? '' }}"></textarea>

                                @elseif($setting->type === 'select')
                                    <select wire:model.defer="settings.{{ $setting->key }}" class="field-input-pro">
                                        <option value="Organization">Organization</option>
                                        <option value="LocalBusiness">LocalBusiness</option>
                                    </select>

                                @elseif($setting->type === 'password' || $setting->is_encrypted)
                                    <input type="password" wire:model.defer="settings.{{ $setting->key }}" class="field-input-pro" placeholder="••••••••">

                                @elseif($setting->type === 'image')
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        @if(filled($settings[$setting->key] ?? ''))
                                            <img src="{{ asset('storage/' . $settings[$setting->key]) }}" style="height: 40px; width: 40px; object-fit: cover; border-radius: 8px; border: 1px solid #E2E8F0;">
                                        @endif
                                        <input type="text" wire:model.defer="settings.{{ $setting->key }}" class="field-input-pro" placeholder="Chemin du fichier">
                                    </div>

                                @else
                                    <input type="{{ $setting->type === 'email' ? 'email' : ($setting->type === 'url' ? 'url' : ($setting->type === 'phone' ? 'tel' : ($setting->type === 'number' ? 'number' : 'text'))) }}"
                                        wire:model.defer="settings.{{ $setting->key }}" class="field-input-pro"
                                        placeholder="{{ $setting->description ?? '' }}">
                                @endif

                                @if($setting->description && !in_array($setting->type, ['textarea', 'json']))
                                    <div class="field-hint">{{ $setting->description }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                @endforeach

                {{-- MAINTENANCE SPECIAL TAB --}}
                @if($activeTab === 'maintenance')
                    <div class="section-title">Gestion du cache</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px;">
                        <x-filament::button wire:click="clearAllCache" color="danger" icon="heroicon-o-trash" type="button">Vider tout le cache</x-filament::button>
                        <x-filament::button wire:click="optimize" color="success" icon="heroicon-o-bolt" type="button">Optimiser</x-filament::button>
                    </div>

                    <div class="section-title">Santé du système</div>
                    <div class="grid-2">
                        <div style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; background: #FAFBFC; border-radius: 10px; border: 1px solid #F1F5F9;">
                            <span>{{ !config('app.debug') ? '✅' : '❌' }}</span>
                            <span style="font-size: 13px;">APP_DEBUG = {{ config('app.debug') ? 'true' : 'false' }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; background: #FAFBFC; border-radius: 10px; border: 1px solid #F1F5F9;">
                            <span>{{ config('app.env') === 'production' ? '✅' : '⚠️' }}</span>
                            <span style="font-size: 13px;">Env : {{ config('app.env') }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; background: #FAFBFC; border-radius: 10px; border: 1px solid #F1F5F9;">
                            <span>✅</span><span style="font-size: 13px;">PHP {{ phpversion() }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; background: #FAFBFC; border-radius: 10px; border: 1px solid #F1F5F9;">
                            <span>✅</span><span style="font-size: 13px;">Laravel {{ app()->version() }}</span>
                        </div>
                    </div>
                @endif

                {{-- SEO GOOGLE PREVIEW --}}
                @if($activeTab === 'seo')
                    <div class="section-title">Aperçu Google</div>
                    <div style="padding: 16px; border: 1px solid #E2E8F0; border-radius: 12px; background: white;">
                        <div style="font-size: 12px; color: #94A3B8;">neogtb.fr</div>
                        <div style="font-size: 18px; color: #1a0dab; margin-top: 4px;">{{ $settings['seo_meta_title_defaut'] ?? 'Titre de la page' }}</div>
                        <div style="font-size: 13px; color: #4d5156; margin-top: 4px; line-height: 1.5;">{{ \Illuminate\Support\Str::limit($settings['seo_meta_description_defaut'] ?? 'Description...', 160) }}</div>
                    </div>
                @endif

                {{-- THEME TAB --}}
                @if($activeTab === 'theme')
                    <div class="section-title">Presets de thème</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px;">
                        <x-filament::button wire:click="applyPreset('gtb_pro')" wire:confirm="Les couleurs actuelles seront remplacées." color="primary" icon="heroicon-o-swatch" type="button">
                            GTB Pro
                        </x-filament::button>
                        <x-filament::button wire:click="applyPreset('eco_green')" wire:confirm="Les couleurs actuelles seront remplacées." color="success" icon="heroicon-o-swatch" type="button">
                            Éco Green
                        </x-filament::button>
                        <x-filament::button wire:click="applyPreset('tech_blue')" wire:confirm="Les couleurs actuelles seront remplacées." color="info" icon="heroicon-o-swatch" type="button">
                            Tech Blue
                        </x-filament::button>
                    </div>

                    <div class="section-title">Couleurs principales</div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                        @foreach(['theme_primary_color' => 'Couleur primaire', 'theme_secondary_color' => 'Couleur secondaire', 'theme_accent_color' => 'Couleur d\'accent'] as $key => $label)
                            <div class="field-row">
                                <label class="field-label-pro">{{ $label }}</label>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <input type="color" wire:model.defer="settings.{{ $key }}" style="width: 44px; height: 36px; border: 1px solid #E2E8F0; border-radius: 8px; cursor: pointer; padding: 2px;">
                                    <input type="text" wire:model.defer="settings.{{ $key }}" class="field-input-pro" style="font-family: monospace; font-size: 12px;" placeholder="#000000">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="section-title">Header & Footer</div>
                    <div class="grid-2">
                        @foreach(['theme_header_bg' => 'Header — Fond', 'theme_header_text' => 'Header — Texte', 'theme_footer_bg' => 'Footer — Fond', 'theme_footer_text' => 'Footer — Texte'] as $key => $label)
                            <div class="field-row">
                                <label class="field-label-pro">{{ $label }}</label>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <input type="color" wire:model.defer="settings.{{ $key }}" style="width: 44px; height: 36px; border: 1px solid #E2E8F0; border-radius: 8px; cursor: pointer; padding: 2px;">
                                    <input type="text" wire:model.defer="settings.{{ $key }}" class="field-input-pro" style="font-family: monospace; font-size: 12px;" placeholder="#000000">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="section-title">Corps & Hero</div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                        <div class="field-row">
                            <label class="field-label-pro">Fond du body</label>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="color" wire:model.defer="settings.theme_body_bg" style="width: 44px; height: 36px; border: 1px solid #E2E8F0; border-radius: 8px; cursor: pointer; padding: 2px;">
                                <input type="text" wire:model.defer="settings.theme_body_bg" class="field-input-pro" style="font-family: monospace; font-size: 12px;" placeholder="#FFFFFF">
                            </div>
                        </div>
                        <div class="field-row">
                            <label class="field-label-pro">Overlay Hero</label>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="color" wire:model.defer="settings.theme_hero_overlay" style="width: 44px; height: 36px; border: 1px solid #E2E8F0; border-radius: 8px; cursor: pointer; padding: 2px;">
                                <input type="text" wire:model.defer="settings.theme_hero_overlay" class="field-input-pro" style="font-family: monospace; font-size: 12px;" placeholder="#0F172A">
                            </div>
                        </div>
                        <div class="field-row">
                            <label class="field-label-pro">Opacité Hero</label>
                            <input type="number" wire:model.defer="settings.theme_hero_opacity" class="field-input-pro" min="0" max="100" placeholder="60" style="font-family: monospace;">
                            <div class="field-hint">Valeur entre 0 et 100 %</div>
                        </div>
                    </div>

                    <div class="section-title">Boutons CTA</div>
                    <div class="grid-2">
                        @foreach(['theme_cta_bg' => 'Fond CTA', 'theme_cta_text' => 'Texte CTA'] as $key => $label)
                            <div class="field-row">
                                <label class="field-label-pro">{{ $label }}</label>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <input type="color" wire:model.defer="settings.{{ $key }}" style="width: 44px; height: 36px; border: 1px solid #E2E8F0; border-radius: 8px; cursor: pointer; padding: 2px;">
                                    <input type="text" wire:model.defer="settings.{{ $key }}" class="field-input-pro" style="font-family: monospace; font-size: 12px;" placeholder="#000000">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="section-title">Typographie & Forme</div>
                    <div class="grid-2">
                        <div class="field-row">
                            <label class="field-label-pro">Paire de polices</label>
                            <select wire:model.defer="settings.theme_font_pair" class="field-input-pro">
                                <option value="">— Sélectionner —</option>
                                <option value="inter_dm_sans">Inter + DM Sans</option>
                                <option value="inter_merriweather">Inter + Merriweather</option>
                                <option value="poppins_lora">Poppins + Lora</option>
                                <option value="montserrat_roboto">Montserrat + Roboto</option>
                                <option value="dm_sans_dm_serif">DM Sans + DM Serif</option>
                                <option value="plus_jakarta_inter">Plus Jakarta + Inter</option>
                                <option value="outfit_inter">Outfit + Inter</option>
                                <option value="space_grotesk_inter">Space Grotesk + Inter</option>
                            </select>
                        </div>
                        <div class="field-row">
                            <label class="field-label-pro">Taille de police</label>
                            <select wire:model.defer="settings.theme_font_size" class="field-input-pro">
                                <option value="sm">Petit</option>
                                <option value="md">Moyen</option>
                                <option value="lg">Grand</option>
                            </select>
                        </div>
                        <div class="field-row">
                            <label class="field-label-pro">Arrondi des bordures</label>
                            <select wire:model.defer="settings.theme_border_radius" class="field-input-pro">
                                <option value="none">Aucun</option>
                                <option value="sm">Léger</option>
                                <option value="md">Moyen</option>
                                <option value="lg">Arrondi</option>
                                <option value="full">Très arrondi</option>
                            </select>
                        </div>
                        <div class="field-row">
                            <label class="field-label-pro">Ombres</label>
                            <select wire:model.defer="settings.theme_shadow" class="field-input-pro">
                                <option value="none">Aucune</option>
                                <option value="sm">Légère</option>
                                <option value="md">Moyenne</option>
                                <option value="lg">Forte</option>
                            </select>
                        </div>
                    </div>
                @endif

                {{-- LEGAL TAB --}}
                @if($activeTab === 'legal')
                    <div class="section-title">Mentions légales</div>
                    <div class="field-row">
                        <label class="field-label-pro">Contenu des mentions légales</label>
                        <textarea wire:model.defer="settings.legal_mentions_legales" rows="12" class="field-input-pro" placeholder="Rédigez vos mentions légales ici..."></textarea>
                    </div>

                    <div class="section-title">Politique de confidentialité</div>
                    <div class="field-hint" style="margin-bottom: 8px;">La modification crée automatiquement une nouvelle version.</div>
                    <div class="field-row">
                        <label class="field-label-pro">Contenu de la politique de confidentialité</label>
                        <textarea wire:model.defer="settings.legal_politique_confidentialite" rows="12" class="field-input-pro" placeholder="Rédigez votre politique de confidentialité ici..."></textarea>
                    </div>

                    <div class="section-title">CGU</div>
                    <div class="field-row">
                        <label class="field-label-pro">Conditions générales d'utilisation</label>
                        <textarea wire:model.defer="settings.legal_cgu" rows="12" class="field-input-pro" placeholder="Rédigez vos CGU ici..."></textarea>
                    </div>

                    <div class="section-title">Politique de cookies</div>
                    <div class="field-row">
                        <label class="field-label-pro">Contenu de la politique de cookies</label>
                        <textarea wire:model.defer="settings.legal_politique_cookies" rows="12" class="field-input-pro" placeholder="Rédigez votre politique de cookies ici..."></textarea>
                    </div>
                @endif

                {{-- NAVIGATION TAB --}}
                @if($activeTab === 'navigation')
                    <div class="section-title">Style</div>
                    <div class="grid-2">
                        <div class="field-row">
                            <label class="field-label-pro">Style de navigation</label>
                            <select wire:model.defer="settings.navigation_style" class="field-input-pro">
                                <option value="sticky">Sticky</option>
                                <option value="transparent">Transparent</option>
                                <option value="solid">Solid</option>
                            </select>
                        </div>
                        <div class="field-row">
                            <label class="field-label-pro">Navigation sticky</label>
                            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" wire:model.defer="settings.navigation_sticky" value="1"
                                    style="width: 18px; height: 18px; accent-color: #2D8B4E; cursor: pointer;">
                                <span style="font-size: 13px; color: #64748B;">Activé</span>
                            </label>
                        </div>
                    </div>

                    <div class="section-title">Bouton CTA header</div>
                    <div class="grid-2">
                        <div class="field-row">
                            <label class="field-label-pro">Afficher le CTA</label>
                            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" wire:model.live="settings.navigation_cta_visible" value="1"
                                    style="width: 18px; height: 18px; accent-color: #2D8B4E; cursor: pointer;">
                                <span style="font-size: 13px; color: #64748B;">Activé</span>
                            </label>
                        </div>
                        <div></div>
                        @if(!empty($settings['navigation_cta_visible']))
                            <div class="field-row">
                                <label class="field-label-pro">Texte du CTA</label>
                                <input type="text" wire:model.defer="settings.navigation_cta_text" class="field-input-pro" placeholder="Demander un audit">
                            </div>
                            <div class="field-row">
                                <label class="field-label-pro">URL du CTA</label>
                                <input type="text" wire:model.defer="settings.navigation_cta_url" class="field-input-pro" placeholder="/audit">
                            </div>
                        @endif
                    </div>

                    <div class="section-title">Téléphone</div>
                    <div class="field-row">
                        <label class="field-label-pro">Afficher le téléphone</label>
                        <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" wire:model.defer="settings.navigation_show_phone" value="1"
                                style="width: 18px; height: 18px; accent-color: #2D8B4E; cursor: pointer;">
                            <span style="font-size: 13px; color: #64748B;">Activé</span>
                        </label>
                        <div class="field-hint">Affiche le numéro de téléphone dans la barre de navigation</div>
                    </div>
                @endif

                {{-- EMAIL TAB --}}
                @if($activeTab === 'email')
                    <div class="section-title">Expéditeur</div>
                    <div class="grid-2">
                        <div class="field-row">
                            <label class="field-label-pro">Nom de l'expéditeur <span class="required">*</span></label>
                            <input type="text" wire:model.defer="settings.email_from_name" class="field-input-pro" placeholder="NeoGTB" required>
                        </div>
                        <div class="field-row">
                            <label class="field-label-pro">Adresse de l'expéditeur <span class="required">*</span></label>
                            <input type="email" wire:model.defer="settings.email_from_address" class="field-input-pro" placeholder="contact@neogtb.fr" required>
                        </div>
                    </div>

                    <div class="section-title">Notifications admin</div>
                    <div class="grid-2">
                        <div class="field-row">
                            <label class="field-label-pro">Email de notification <span class="required">*</span></label>
                            <input type="email" wire:model.defer="settings.email_notification_to" class="field-input-pro" placeholder="admin@neogtb.fr" required>
                        </div>
                        <div class="field-row">
                            <label class="field-label-pro">Email en copie (CC)</label>
                            <input type="email" wire:model.defer="settings.email_notification_cc" class="field-input-pro" placeholder="backup@neogtb.fr">
                        </div>
                    </div>

                    <div class="section-title">Test</div>
                    <div style="margin-bottom: 24px;">
                        <x-filament::button wire:click="sendTestEmail" wire:confirm="Envoyer un email de test à l'adresse de notification ?" color="primary" icon="heroicon-o-paper-airplane" type="button">
                            Envoyer un email de test
                        </x-filament::button>
                    </div>
                @endif

                {{-- SAVE BUTTON --}}
                @if(!in_array($activeTab, ['maintenance']))
                    <div style="margin-top: 24px; display: flex; justify-content: flex-end;">
                        <button type="submit" style="padding: 12px 32px; background: #1B3A5C; color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: inherit; transition: all 0.15s;"
                            onmouseover="this.style.background='#142b47'" onmouseout="this.style.background='#1B3A5C'">
                            💾 Enregistrer les paramètres
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-filament-panels::page>
