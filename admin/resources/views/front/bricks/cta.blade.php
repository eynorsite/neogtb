@php $style = $settings['style'] ?? 'premium'; @endphp

@if($style === 'minimal')
{{-- STYLE MINIMAL — CTA épuré sur fond blanc --}}
<section class="py-24 lg:py-32 bg-white">
    <div class="max-w-[900px] mx-auto px-6 md:px-10 text-center">
        @if(!empty($content['titre']))
            <h2 class="heading-premium text-3xl sm:text-4xl lg:text-5xl text-dark-900 animate-fade-in-up">
                {{ $content['titre'] }}
            </h2>
        @endif
        @if(!empty($content['sous_titre']))
            <p class="subheading-premium mt-6 text-lg text-dark-500 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s;">
                {{ $content['sous_titre'] }}
            </p>
        @endif
        @if(!empty($content['bouton_texte']) || !empty($content['bouton2_texte']))
            <div class="mt-10 flex flex-wrap gap-4 justify-center animate-fade-in-up" style="animation-delay: 0.2s;">
                @if(!empty($content['bouton_texte']))
                    <a href="{{ $content['bouton_lien'] ?? '#' }}" class="btn-primary btn-glow">
                        {{ $content['bouton_texte'] }}
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
                @if(!empty($content['bouton2_texte']))
                    <a href="{{ $content['bouton2_lien'] ?? '#' }}" class="btn-secondary">
                        {{ $content['bouton2_texte'] }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>

@elseif($style === 'card')
{{-- STYLE CARD — CTA dans une carte centrée --}}
<section class="py-24 lg:py-32 bg-dark-50/50">
    <div class="max-w-[1000px] mx-auto px-6 md:px-10">
        <div class="card-premium p-12 lg:p-16 text-center animate-fade-in-up">
            @if(!empty($content['titre']))
                <h2 class="heading-premium text-2xl sm:text-3xl lg:text-4xl text-dark-900">
                    {{ $content['titre'] }}
                </h2>
            @endif
            @if(!empty($content['sous_titre']))
                <p class="subheading-premium mt-4 text-base text-dark-500 max-w-xl mx-auto">
                    {{ $content['sous_titre'] }}
                </p>
            @endif
            @if(!empty($content['bouton_texte']) || !empty($content['bouton2_texte']))
                <div class="mt-8 flex flex-wrap gap-4 justify-center">
                    @if(!empty($content['bouton_texte']))
                        <a href="{{ $content['bouton_lien'] ?? '#' }}" class="btn-primary btn-glow">
                            {{ $content['bouton_texte'] }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @endif
                    @if(!empty($content['bouton2_texte']))
                        <a href="{{ $content['bouton2_lien'] ?? '#' }}" class="btn-secondary">
                            {{ $content['bouton2_texte'] }}
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>

@else
{{-- STYLE PREMIUM (défaut) — CTA immersif fond sombre --}}
<section class="relative overflow-hidden py-24 lg:py-32">
    {{-- Dark gradient background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-dark-950 via-primary-900/60 to-dark-950"></div>
    
    {{-- Subtle noise --}}
    <div class="absolute inset-0 opacity-[0.02]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.8%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22/%3E%3C/svg%3E');"></div>
    
    {{-- Floating elements --}}
    <div class="absolute top-[20%] left-[10%] w-[300px] h-[300px] bg-accent-500/15 rounded-full blur-[100px] animate-float"></div>
    <div class="absolute bottom-[20%] right-[15%] w-[250px] h-[250px] bg-primary-400/20 rounded-full blur-[80px] animate-float" style="animation-delay: -3s;"></div>
    
    {{-- Content --}}
    <div class="relative z-10 mx-auto max-w-[900px] px-6 md:px-10 text-center">
        @if(!empty($content['titre']))
            <h2 class="heading-premium text-3xl sm:text-4xl lg:text-5xl text-white animate-fade-in-up">
                {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span class="text-gradient">$1</span>', e($content['titre'])) !!}
            </h2>
        @endif
        @if(!empty($content['sous_titre']))
            <p class="subheading-premium mt-6 text-lg text-white/60 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s;">
                {{ $content['sous_titre'] }}
            </p>
        @endif
        @if(!empty($content['bouton_texte']) || !empty($content['bouton2_texte']))
            <div class="mt-10 flex flex-wrap gap-4 justify-center animate-fade-in-up" style="animation-delay: 0.2s;">
                @if(!empty($content['bouton_texte']))
                    <a href="{{ $content['bouton_lien'] ?? '#' }}"
                       class="group inline-flex items-center gap-3 rounded-2xl bg-white px-8 py-4 text-base font-semibold text-dark-900 shadow-xl transition-all duration-300 hover:shadow-2xl hover:shadow-white/10 hover:-translate-y-1">
                        {{ $content['bouton_texte'] }}
                        <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
                @if(!empty($content['bouton2_texte']))
                    <a href="{{ $content['bouton2_lien'] ?? '#' }}"
                       class="group inline-flex items-center gap-3 rounded-2xl border border-white/15 bg-white/5 px-8 py-4 text-base font-semibold text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:bg-white/10 hover:border-white/25 hover:-translate-y-1">
                        {{ $content['bouton2_texte'] }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endif
