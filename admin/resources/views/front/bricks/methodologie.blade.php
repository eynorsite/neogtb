<section class="py-12 lg:py-24">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">
        @if(!empty($content['eyebrow']) || !empty($content['titre']))
            <div class="mx-auto max-w-2xl text-center mb-12 animate-fade-in-up">
                @if(!empty($content['eyebrow']))
                    <p class="text-sm font-semibold uppercase tracking-wider text-accent-600">{{ $content['eyebrow'] }}</p>
                @endif
                @if(!empty($content['titre']))
                    <h2 class="font-display mt-2 text-3xl font-bold md:text-4xl text-dark-900">{{ $content['titre'] }}</h2>
                @endif
                @if(!empty($content['sous_titre']))
                    <p class="mt-4 text-dark-500">{{ $content['sous_titre'] }}</p>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-{{ count($content['etapes'] ?? []) }} gap-6">
            @foreach($content['etapes'] ?? [] as $i => $etape)
                @php $isActive = ($etape['active'] ?? false); @endphp
                <div class="glass-card relative rounded-2xl p-6 pt-8 {{ $isActive ? 'ring-2 ring-accent-500/30 shadow-lg shadow-accent-500/10' : '' }} transition-all duration-300 animate-fade-in-up"
                     style="animation-delay: {{ $i * 100 }}ms">

                    @if($isActive)
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-accent-500 px-4 py-1 text-xs font-semibold text-white shadow-lg shadow-accent-500/30 z-10">
                            Recommandé
                        </div>
                    @endif

                    <div class="flex flex-col items-center text-center">
                        <div class="mb-4 relative">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-500 to-accent-600 flex items-center justify-center text-white font-bold text-lg font-display"
                                 style="box-shadow: 0 0 20px rgba(45, 139, 78, 0.3);">
                                {{ $etape['numero'] ?? ($i + 1) }}
                            </div>
                        </div>
                        <h3 class="font-display font-semibold text-dark-900 mb-2">{{ $etape['titre'] ?? '' }}</h3>
                        <p class="text-sm text-dark-500">{{ $etape['description'] ?? '' }}</p>

                        @if(!empty($etape['features']))
                            <ul class="mt-4 space-y-2 text-left w-full">
                                @foreach($etape['features'] ?? [] as $feature)
                                    <li class="flex items-center gap-2 text-sm text-dark-700/80">
                                        <svg class="h-4 w-4 text-accent-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    @if(!empty($etape['cta_texte']))
                        <a href="{{ $etape['cta_lien'] ?? '#' }}"
                           class="mt-6 w-full inline-flex items-center justify-center gap-2 rounded-lg {{ $isActive ? 'bg-accent-500 text-white shadow-lg shadow-accent-500/20' : 'border border-dark-200 text-dark-700 hover:border-accent-500/30' }} px-4 py-2.5 text-sm font-semibold transition-all duration-300">
                            {{ $etape['cta_texte'] }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        @if(!empty($content['cta_texte']))
            <div class="text-center mt-8 animate-fade-in-up">
                <a href="{{ $content['cta_lien'] ?? '#' }}"
                   class="text-sm font-medium text-accent-600 hover:text-accent-700 transition-colors border-b border-accent-200 hover:border-accent-600">
                    {{ $content['cta_texte'] }}
                </a>
            </div>
        @endif
    </div>
</section>
