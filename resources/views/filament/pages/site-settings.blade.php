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

                {{-- SAVE BUTTON --}}
                @if($activeTab !== 'maintenance')
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
