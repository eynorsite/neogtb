<x-filament-panels::page>
    <div style="display: flex !important; gap: 24px;">
        {{-- Sidebar navigation --}}
        <nav style="width: 220px; min-width: 220px; flex-shrink: 0;" class="space-y-1">
            @foreach($this->tabs as $key => $tab)
                <button
                    wire:click="switchTab('{{ $key }}')"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ $activeTab === $key
                            ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400'
                            : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800' }}"
                >
                    <span class="text-base">{{ $tab['emoji'] }}</span>
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </nav>

        {{-- Main content --}}
        <div style="flex: 1; min-width: 0;">
            <form wire:submit="save">
                {{-- CONTACT --}}
                @if($activeTab === 'contact')
                    <x-filament::section heading="Coordonnées">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach($this->getSettingsForGroup('contact') as $setting)
                                <div @if(in_array($setting->key, ['contact_adresse', 'contact_horaires', 'contact_google_maps_url', 'contact_google_maps_embed'])) class="md:col-span-2" @endif>
                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $setting->label }}
                                        @if($setting->is_required) <span class="text-red-500">*</span> @endif
                                    </label>
                                    @if($setting->type === 'textarea' || $setting->type === 'json')
                                        <textarea wire:model.defer="settings.{{ $setting->key }}" rows="3"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm transition focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        ></textarea>
                                    @else
                                        <input type="{{ $setting->type === 'email' ? 'email' : ($setting->type === 'phone' ? 'tel' : 'text') }}"
                                            wire:model.defer="settings.{{ $setting->key }}"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm transition focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        >
                                    @endif
                                    @if($setting->description)
                                        <p class="mt-1 text-xs text-gray-500">{{ $setting->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </x-filament::section>
                @endif

                {{-- RÉSEAUX SOCIAUX --}}
                @if($activeTab === 'reseaux_sociaux')
                    <x-filament::section heading="Réseaux sociaux">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach($this->getSettingsForGroup('reseaux_sociaux') as $setting)
                                <div>
                                    <label class="mb-1 flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        @php
                                            $icons = [
                                                'social_linkedin' => '🔗',
                                                'social_facebook' => '📘',
                                                'social_instagram' => '📸',
                                                'social_youtube' => '🎬',
                                                'social_twitter_x' => '𝕏',
                                                'social_tiktok' => '🎵',
                                                'social_google_reviews' => '⭐',
                                            ];
                                        @endphp
                                        <span>{{ $icons[$setting->key] ?? '🌐' }}</span>
                                        {{ $setting->label }}
                                    </label>
                                    <input type="{{ $setting->type === 'number' ? 'number' : ($setting->type === 'url' ? 'url' : 'text') }}"
                                        wire:model.defer="settings.{{ $setting->key }}"
                                        step="{{ $setting->key === 'social_google_reviews_score' ? '0.1' : '1' }}"
                                        placeholder="{{ $setting->type === 'url' ? 'https://...' : '' }}"
                                        class="fi-input block w-full rounded-lg border-gray-300 shadow-sm transition focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                    >
                                    @if($setting->key === 'social_google_reviews_score' && filled($settings[$setting->key] ?? ''))
                                        <div class="mt-1 flex items-center gap-1 text-yellow-500">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor((float)($settings[$setting->key] ?? 0)))
                                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                                @else
                                                    <svg class="h-4 w-4 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                                @endif
                                            @endfor
                                            <span class="ml-1 text-sm text-gray-600">{{ $settings[$setting->key] ?? '' }}/5</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </x-filament::section>
                @endif

                {{-- ENTREPRISE --}}
                @if($activeTab === 'entreprise')
                    <x-filament::section heading="Identité">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach($this->getSettingsForGroup('entreprise')->whereIn('type', ['text', 'textarea', 'number']) as $setting)
                                <div @if($setting->type === 'textarea') class="md:col-span-2" @endif>
                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $setting->label }}
                                        @if($setting->is_required) <span class="text-red-500">*</span> @endif
                                    </label>
                                    @if($setting->is_encrypted)
                                        <input type="password"
                                            wire:model.defer="settings.{{ $setting->key }}"
                                            placeholder="••••••••"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        >
                                        <p class="mt-1 text-xs text-gray-500">
                                            @if(filled($settings[$setting->key] ?? ''))
                                                <span class="text-green-600">Configuré ✅</span>
                                            @else
                                                <span class="text-yellow-600">Non configuré ⚠️</span>
                                            @endif
                                        </p>
                                    @elseif($setting->type === 'textarea')
                                        <textarea wire:model.defer="settings.{{ $setting->key }}" rows="2"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        ></textarea>
                                        @if($setting->description)
                                            <p class="mt-1 text-xs text-gray-500">{{ $setting->description }} — {{ strlen($settings[$setting->key] ?? '') }} car.</p>
                                        @endif
                                    @else
                                        <input type="{{ $setting->type === 'number' ? 'number' : 'text' }}"
                                            wire:model.defer="settings.{{ $setting->key }}"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        >
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </x-filament::section>

                    <x-filament::section heading="Visuels" class="mt-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            @foreach($this->getSettingsForGroup('entreprise')->where('type', 'image') as $setting)
                                <div class="text-center">
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $setting->label }}</label>
                                    <div class="mx-auto flex h-32 w-32 items-center justify-center overflow-hidden rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-800">
                                        @if(filled($settings[$setting->key] ?? ''))
                                            <img src="{{ asset('storage/' . $settings[$setting->key]) }}" class="max-h-full max-w-full object-contain" alt="{{ $setting->label }}">
                                        @else
                                            <span class="text-xs text-gray-400">Aucun fichier</span>
                                        @endif
                                    </div>
                                    <input type="text" wire:model.defer="settings.{{ $setting->key }}" placeholder="Chemin du fichier"
                                        class="mt-2 fi-input block w-full rounded-lg border-gray-300 text-xs shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    >
                                    @if($setting->description)
                                        <p class="mt-1 text-xs text-gray-500">{{ $setting->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </x-filament::section>

                    <x-filament::section heading="Couleurs" class="mt-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            @foreach($this->getSettingsForGroup('entreprise')->where('type', 'color') as $setting)
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $setting->label }}</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" wire:model.defer="settings.{{ $setting->key }}"
                                            class="h-10 w-14 cursor-pointer rounded border-gray-300">
                                        <input type="text" wire:model.defer="settings.{{ $setting->key }}"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                            placeholder="#000000"
                                        >
                                    </div>
                                    {{-- Preview --}}
                                    <div class="mt-2 flex gap-2">
                                        <span class="inline-block rounded px-3 py-1 text-xs text-white" style="background-color: {{ $settings[$setting->key] ?? '#2563eb' }}">
                                            Bouton preview
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-filament::section>
                @endif

                {{-- SEO --}}
                @if($activeTab === 'seo')
                    <x-filament::section heading="SEO Global">
                        <div class="space-y-4">
                            @foreach($this->getSettingsForGroup('seo') as $setting)
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $setting->label }}</label>
                                    @if($setting->type === 'textarea')
                                        <textarea wire:model.defer="settings.{{ $setting->key }}" rows="{{ $setting->key === 'seo_robots_txt' ? 6 : 2 }}"
                                            class="fi-input block w-full rounded-lg border-gray-300 font-mono shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        ></textarea>
                                        @if(str_contains($setting->description ?? '', 'Max'))
                                            <p class="mt-1 text-xs {{ strlen($settings[$setting->key] ?? '') > 160 ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                                {{ strlen($settings[$setting->key] ?? '') }} caractères — {{ $setting->description }}
                                            </p>
                                        @endif
                                    @elseif($setting->type === 'image')
                                        <input type="text" wire:model.defer="settings.{{ $setting->key }}" placeholder="Chemin de l'image"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                        @if($setting->description)
                                            <p class="mt-1 text-xs text-gray-500">{{ $setting->description }}</p>
                                        @endif
                                    @elseif($setting->type === 'select')
                                        <select wire:model.defer="settings.{{ $setting->key }}"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                            <option value="Organization">Organization</option>
                                            <option value="LocalBusiness">LocalBusiness</option>
                                        </select>
                                    @else
                                        <input type="{{ $setting->type === 'url' ? 'url' : 'text' }}"
                                            wire:model.defer="settings.{{ $setting->key }}"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                        @if(str_contains($setting->description ?? '', 'Max'))
                                            <p class="mt-1 text-xs {{ strlen($settings[$setting->key] ?? '') > 55 ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                                {{ strlen($settings[$setting->key] ?? '') }} caractères — {{ $setting->description }}
                                            </p>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </x-filament::section>

                    {{-- Google Preview --}}
                    <x-filament::section heading="Aperçu Google" class="mt-6">
                        <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                            <p class="text-sm text-gray-500">neogtb.fr</p>
                            <p class="text-lg text-blue-700 hover:underline dark:text-blue-400">
                                {{ $settings['seo_meta_title_defaut'] ?? 'Titre de la page' }}
                            </p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ \Illuminate\Support\Str::limit($settings['seo_meta_description_defaut'] ?? 'Description de la page...', 160) }}
                            </p>
                        </div>
                    </x-filament::section>
                @endif

                {{-- ANALYTICS --}}
                @if($activeTab === 'analytics')
                    <x-filament::section heading="Tracking & Analytics">
                        <div class="space-y-4">
                            @foreach($this->getSettingsForGroup('analytics') as $setting)
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $setting->label }}
                                        @if($setting->is_encrypted)
                                            @if(filled($settings[$setting->key] ?? ''))
                                                <span class="ml-2 text-xs text-green-600">Configuré ✅</span>
                                            @else
                                                <span class="ml-2 text-xs text-yellow-600">Non configuré ⚠️</span>
                                            @endif
                                        @endif
                                    </label>
                                    @if($setting->type === 'boolean')
                                        <label class="relative inline-flex cursor-pointer items-center">
                                            <input type="checkbox" wire:model.defer="settings.{{ $setting->key }}" value="1" class="peer sr-only">
                                            <div class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:bg-white after:transition-all peer-checked:bg-primary-600 peer-checked:after:translate-x-full dark:bg-gray-700"></div>
                                        </label>
                                    @elseif($setting->type === 'textarea')
                                        <textarea wire:model.defer="settings.{{ $setting->key }}" rows="3"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        ></textarea>
                                    @else
                                        <input type="{{ $setting->is_encrypted ? 'password' : 'text' }}"
                                            wire:model.defer="settings.{{ $setting->key }}"
                                            placeholder="{{ $setting->description ?? '' }}"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        >
                                    @endif
                                    @if($setting->description && $setting->type !== 'boolean')
                                        <p class="mt-1 text-xs text-gray-500">{{ $setting->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </x-filament::section>
                @endif

                {{-- APPARENCE --}}
                @if($activeTab === 'apparence')
                    <x-filament::section heading="Mode maintenance">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between rounded-lg border p-4 {{ ($settings['apparence_maintenance_mode'] ?? '0') === '1' ? 'border-red-300 bg-red-50 dark:border-red-800 dark:bg-red-900/20' : 'border-green-300 bg-green-50 dark:border-green-800 dark:bg-green-900/20' }}">
                                <div>
                                    <span class="text-sm font-medium">
                                        @if(($settings['apparence_maintenance_mode'] ?? '0') === '1')
                                            Mode maintenance ACTIF
                                        @else
                                            Site en ligne
                                        @endif
                                    </span>
                                </div>
                                <label class="relative inline-flex cursor-pointer items-center">
                                    <input type="checkbox" wire:model.defer="settings.apparence_maintenance_mode" value="1" class="peer sr-only">
                                    <div class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:bg-white after:transition-all peer-checked:bg-red-600 peer-checked:after:translate-x-full dark:bg-gray-700"></div>
                                </label>
                            </div>

                            @foreach($this->getSettingsForGroup('apparence')->whereIn('key', ['apparence_maintenance_message', 'apparence_maintenance_image']) as $setting)
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $setting->label }}</label>
                                    @if($setting->type === 'textarea')
                                        <textarea wire:model.defer="settings.{{ $setting->key }}" rows="3"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"></textarea>
                                    @else
                                        <input type="text" wire:model.defer="settings.{{ $setting->key }}"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </x-filament::section>

                    <x-filament::section heading="Bandeau d'information" class="mt-6">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <label class="relative inline-flex cursor-pointer items-center">
                                    <input type="checkbox" wire:model.defer="settings.apparence_bandeau_info" value="1" class="peer sr-only">
                                    <div class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:bg-white after:transition-all peer-checked:bg-primary-600 peer-checked:after:translate-x-full dark:bg-gray-700"></div>
                                </label>
                                <span class="text-sm">Bandeau actif</span>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Texte</label>
                                    <input type="text" wire:model.defer="settings.apparence_bandeau_texte"
                                        class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                </div>
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Lien</label>
                                    <input type="url" wire:model.defer="settings.apparence_bandeau_lien"
                                        class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Couleur de fond</label>
                                <div class="flex items-center gap-3">
                                    <input type="color" wire:model.defer="settings.apparence_bandeau_couleur" class="h-10 w-14 cursor-pointer rounded">
                                    <input type="text" wire:model.defer="settings.apparence_bandeau_couleur"
                                        class="fi-input block w-40 rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                </div>
                            </div>

                            {{-- Preview --}}
                            @if(filled($settings['apparence_bandeau_texte'] ?? ''))
                                <div class="mt-2 rounded px-4 py-2 text-center text-sm text-white"
                                     style="background-color: {{ $settings['apparence_bandeau_couleur'] ?? '#2563eb' }}">
                                    {{ $settings['apparence_bandeau_texte'] }}
                                </div>
                            @endif
                        </div>
                    </x-filament::section>
                @endif

                {{-- SÉCURITÉ --}}
                @if($activeTab === 'securite')
                    <x-filament::section heading="reCAPTCHA">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach($this->getSettingsForGroup('securite')->whereIn('key', ['securite_recaptcha_site_key', 'securite_recaptcha_secret_key']) as $setting)
                                <div>
                                    <label class="mb-1 flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $setting->label }}
                                        @if(filled($settings[$setting->key] ?? ''))
                                            <span class="text-xs text-green-600">Configuré ✅</span>
                                        @else
                                            <span class="text-xs text-yellow-600">Non configuré ⚠️</span>
                                        @endif
                                    </label>
                                    <input type="password" wire:model.defer="settings.{{ $setting->key }}" placeholder="••••••••"
                                        class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                </div>
                            @endforeach
                        </div>
                    </x-filament::section>

                    <x-filament::section heading="Configuration SMTP" class="mt-6">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach($this->getSettingsForGroup('securite')->whereNotIn('key', ['securite_recaptcha_site_key', 'securite_recaptcha_secret_key']) as $setting)
                                <div>
                                    <label class="mb-1 flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $setting->label }}
                                        @if($setting->is_encrypted)
                                            @if(filled($settings[$setting->key] ?? ''))
                                                <span class="text-xs text-green-600">✅</span>
                                            @else
                                                <span class="text-xs text-yellow-600">⚠️</span>
                                            @endif
                                        @endif
                                    </label>
                                    @if($setting->type === 'select')
                                        <select wire:model.defer="settings.{{ $setting->key }}"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                            <option value="tls">TLS</option>
                                            <option value="ssl">SSL</option>
                                            <option value="none">Aucun</option>
                                        </select>
                                    @elseif($setting->type === 'password')
                                        <input type="password" wire:model.defer="settings.{{ $setting->key }}" placeholder="••••••••"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                    @else
                                        <input type="{{ $setting->is_encrypted ? 'password' : ($setting->type === 'number' ? 'number' : ($setting->type === 'email' ? 'email' : 'text')) }}"
                                            wire:model.defer="settings.{{ $setting->key }}"
                                            class="fi-input block w-full rounded-lg border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </x-filament::section>
                @endif

                {{-- MAINTENANCE --}}
                @if($activeTab === 'maintenance')
                    <x-filament::section heading="Gestion du cache">
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            <x-filament::button wire:click="clearAllCache" color="danger" icon="heroicon-o-trash" type="button">
                                Vider tout le cache
                            </x-filament::button>
                            <x-filament::button wire:click="optimize" color="success" icon="heroicon-o-bolt" type="button">
                                Optimiser l'application
                            </x-filament::button>
                        </div>
                    </x-filament::section>

                    <x-filament::section heading="Santé du système" class="mt-6">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="flex items-center gap-2">
                                @if(!config('app.debug'))
                                    <span class="text-green-500">✅</span> <span>APP_DEBUG = false</span>
                                @else
                                    <span class="text-red-500">❌</span> <span class="text-red-600">APP_DEBUG = true</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                @if(config('app.env') === 'production')
                                    <span class="text-green-500">✅</span> <span>Environnement : production</span>
                                @else
                                    <span class="text-yellow-500">⚠️</span> <span>Environnement : {{ config('app.env') }}</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-green-500">✅</span> <span>PHP {{ phpversion() }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-green-500">✅</span> <span>Laravel {{ app()->version() }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                @php $diskFree = round(disk_free_space('/') / 1024 / 1024 / 1024, 1); @endphp
                                <span class="text-green-500">✅</span> <span>Espace disque libre : {{ $diskFree }} Go</span>
                            </div>
                            <div class="flex items-center gap-2">
                                @php $dbSize = round(filesize(database_path('database.sqlite')) / 1024, 1); @endphp
                                <span class="text-green-500">✅</span> <span>BDD SQLite : {{ $dbSize }} Ko</span>
                            </div>
                        </div>
                    </x-filament::section>
                @endif

                {{-- Save button (not shown for maintenance tab) --}}
                @if($activeTab !== 'maintenance')
                    <div class="mt-6 flex justify-end">
                        <x-filament::button type="submit" size="lg">
                            Enregistrer les paramètres
                        </x-filament::button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-filament-panels::page>
