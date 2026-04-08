{{-- Premium Fondateur — About the founder section --}}
<section class="py-24 lg:py-32 bg-white relative overflow-hidden">
    {{-- Subtle background --}}
    <div class="absolute inset-0 bg-gradient-radial opacity-20"></div>
    
    <div class="relative z-10 max-w-[1200px] mx-auto px-6 md:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">

            {{-- Photo + identité card --}}
            <div class="lg:col-span-4 animate-fade-in-up">
                <div class="card-premium p-8 lg:p-10 text-center">
                    @if(!empty($content['photo']))
                        <div class="relative inline-block mb-6">
                            <img src="{{ $content['photo'] }}"
                                 alt="{{ $content['photo_alt'] ?? $content['nom'] ?? '' }}"
                                 width="140" height="140" loading="lazy" decoding="async"
                                 class="w-[140px] h-[140px] rounded-full object-cover border-4 border-white shadow-xl" />
                            {{-- Status indicator --}}
                            <div class="absolute bottom-2 right-2 w-5 h-5 bg-accent-500 rounded-full border-3 border-white shadow-lg"></div>
                        </div>
                    @endif

                    @if(!empty($content['nom']))
                        <h3 class="text-xl font-bold text-dark-900 mb-1">{{ $content['nom'] }}</h3>
                    @endif

                    @if(!empty($content['role']))
                        <p class="text-sm font-semibold text-accent-600 mb-6">{{ $content['role'] }}</p>
                    @endif

                    @if(!empty($content['identite']))
                        <div class="divider-gradient mb-6"></div>
                        <ul class="space-y-3 text-left">
                            @foreach($content['identite'] as $item)
                                <li class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-accent-500 flex-shrink-0"></div>
                                    <span class="text-[14px] text-dark-500">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    
                    {{-- Social links --}}
                    @if(!empty($content['linkedin']))
                        <div class="mt-6 pt-6 border-t border-dark-100">
                            <a href="{{ $content['linkedin'] }}" target="_blank" rel="noopener noreferrer" 
                               class="inline-flex items-center gap-2 text-sm font-medium text-dark-500 hover:text-accent-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                LinkedIn
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Content --}}
            <div class="lg:col-span-8 animate-fade-in-up" style="animation-delay: 0.1s;">
                @if(!empty($content['eyebrow']))
                    <div class="badge-premium mb-6">
                        {{ $content['eyebrow'] }}
                    </div>
                @endif

                @if(!empty($content['titre']))
                    <h2 class="heading-premium text-3xl sm:text-4xl lg:text-5xl text-dark-900 mb-8">
                        {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span class="text-gradient">$1</span>', $content['titre']) !!}
                    </h2>
                @endif

                @if(!empty($content['texte']))
                    <p class="text-[17px] text-dark-500 leading-relaxed mb-10">{{ $content['texte'] }}</p>
                @endif

                @if(!empty($content['modele_economique']))
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                        @foreach($content['modele_economique'] as $bloc)
                            <div class="p-6 rounded-2xl bg-dark-50/50 border border-dark-100 transition-all duration-300 hover:border-accent-200 hover:bg-accent-50/30">
                                <p class="text-[15px] font-bold text-dark-900 mb-2">{{ $bloc['titre'] ?? '' }}</p>
                                <p class="text-[14px] text-dark-500 leading-relaxed">{{ $bloc['description'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(!empty($content['cta_texte']))
                    <a href="{{ $content['cta_lien'] ?? '#' }}" class="btn-ghost">
                        {{ $content['cta_texte'] }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
