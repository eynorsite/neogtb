@php
    $hauteur = match($settings['hauteur'] ?? 'medium') {
        'full' => 'min-h-screen',
        'medium' => 'min-h-[85vh]',
        'compact' => 'min-h-[60vh]',
        default => 'min-h-[85vh]',
    };
    $align = match($settings['alignement'] ?? 'center') {
        'left' => 'text-left items-start',
        'right' => 'text-right items-end',
        default => 'text-center items-center',
    };
    $style = $settings['style'] ?? 'premium-dark';
@endphp

@if($style === 'premium-light')
{{-- STYLE PREMIUM LIGHT — fond blanc avec accents --}}
<section class="{{ $hauteur }} relative flex items-center justify-center overflow-hidden bg-white">
    {{-- Subtle gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-radial opacity-60"></div>
    
    {{-- Grid pattern --}}
    <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
    
    {{-- Floating accent elements --}}
    <div class="absolute top-[15%] left-[10%] w-[400px] h-[400px] bg-accent-500/5 rounded-full blur-[100px] animate-float"></div>
    <div class="absolute bottom-[20%] right-[15%] w-[300px] h-[300px] bg-primary-500/5 rounded-full blur-[80px] animate-float" style="animation-delay: -3s;"></div>

    @if(!empty($content['image']))
        <div class="absolute inset-0">
            @php $heroImg = $content['image']; $heroImgUrl = str_starts_with($heroImg, '/') || str_starts_with($heroImg, 'http') ? $heroImg : asset('storage/' . $heroImg); @endphp
            <img src="{{ $heroImgUrl }}" alt="{{ $content['image_alt'] ?? '' }}" class="h-full w-full object-cover opacity-[0.07]">
        </div>
    @endif

    <div class="relative z-10 mx-auto max-w-5xl px-6 py-32 {{ $align }}">
        @if(!empty($content['badge']))
            <div class="mb-8 badge-premium animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-accent-500 animate-pulse-soft"></span>
                {{ $content['badge'] }}
            </div>
        @endif

        @if(!empty($content['titre']))
            <h1 class="heading-premium text-5xl text-dark-900 sm:text-6xl lg:text-7xl animate-fade-in-up" style="animation-delay: 0.1s;">
                {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span class="text-gradient">$1</span>', e($content['titre'])) !!}
            </h1>
        @endif

        @if(!empty($content['sous_titre']))
            <p class="subheading-premium mt-8 text-xl text-dark-500 sm:text-2xl max-w-3xl mx-auto animate-fade-in-up" style="animation-delay: 0.2s;">
                {{ $content['sous_titre'] }}
            </p>
        @endif

        @if(!empty($content['description']))
            <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-dark-400 animate-fade-in-up" style="animation-delay: 0.3s;">
                {{ $content['description'] }}
            </p>
        @endif

        @if(!empty($content['cta_texte']) || !empty($content['cta2_texte']))
            <div class="mt-12 flex flex-wrap gap-4 {{ ($settings['alignement'] ?? 'center') === 'center' ? 'justify-center' : '' }} animate-fade-in-up" style="animation-delay: 0.4s;">
                @if(!empty($content['cta_texte']))
                    <a href="{{ $content['cta_lien'] ?? '#' }}" class="btn-primary btn-glow">
                        {{ $content['cta_texte'] }}
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
                @if(!empty($content['cta2_texte']))
                    <a href="{{ $content['cta2_lien'] ?? '#' }}" class="btn-secondary">
                        {{ $content['cta2_texte'] }}
                    </a>
                @endif
            </div>
        @endif
        
        {{-- Trust indicators --}}
        @if(!empty($content['trust_text']))
        <div class="mt-16 flex items-center justify-center gap-8 animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="flex items-center gap-3">
                <div class="flex -space-x-2">
                    <div class="w-8 h-8 rounded-full bg-dark-100 border-2 border-white flex items-center justify-center text-xs font-medium text-dark-600">A</div>
                    <div class="w-8 h-8 rounded-full bg-dark-100 border-2 border-white flex items-center justify-center text-xs font-medium text-dark-600">B</div>
                    <div class="w-8 h-8 rounded-full bg-dark-100 border-2 border-white flex items-center justify-center text-xs font-medium text-dark-600">C</div>
                </div>
                <p class="text-sm text-dark-500">{{ $content['trust_text'] }}</p>
            </div>
        </div>
        @endif
    </div>
</section>

@else
{{-- STYLE PREMIUM DARK (défaut) — fond sombre sophistiqué --}}
<section class="{{ $hauteur }} relative flex items-center justify-center overflow-hidden bg-dark-950">
    {{-- Premium gradient background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-dark-950 via-primary-900/50 to-dark-950"></div>
    
    {{-- Subtle noise texture --}}
    <div class="absolute inset-0 opacity-[0.015]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.8%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22/%3E%3C/svg%3E');"></div>
    
    {{-- Premium floating orbs --}}
    <div class="absolute top-[10%] left-[5%] w-[500px] h-[500px] bg-accent-500/10 rounded-full blur-[120px] animate-float"></div>
    <div class="absolute bottom-[15%] right-[10%] w-[400px] h-[400px] bg-primary-400/15 rounded-full blur-[100px] animate-float" style="animation-delay: -4s;"></div>
    <div class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-accent-600/5 rounded-full blur-[150px]"></div>
    
    {{-- Grid overlay --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 64px 64px;"></div>

    @if(!empty($content['image']))
        <div class="absolute inset-0">
            @php $heroImg = $content['image']; $heroImgUrl = str_starts_with($heroImg, '/') || str_starts_with($heroImg, 'http') ? $heroImg : asset('storage/' . $heroImg); @endphp
            <img src="{{ $heroImgUrl }}" alt="{{ $content['image_alt'] ?? '' }}" class="h-full w-full object-cover opacity-15 mix-blend-luminosity">
            <div class="absolute inset-0 bg-gradient-to-t from-dark-950 via-dark-950/80 to-transparent"></div>
        </div>
    @endif

    <div class="relative z-10 mx-auto max-w-5xl px-6 py-32 {{ $align }}">
        @if(!empty($content['badge']))
            <div class="mb-8 inline-flex items-center gap-3 rounded-full bg-white/[0.05] border border-white/[0.08] px-5 py-2.5 text-sm font-medium text-white/80 backdrop-blur-sm animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-accent-400 animate-pulse-soft"></span>
                {{ $content['badge'] }}
            </div>
        @endif

        @if(!empty($content['titre']))
            <h1 class="heading-premium text-5xl text-white sm:text-6xl lg:text-7xl animate-fade-in-up" style="animation-delay: 0.1s;">
                {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span class="text-gradient">$1</span>', e($content['titre'])) !!}
            </h1>
        @endif

        @if(!empty($content['sous_titre']))
            <p class="subheading-premium mt-8 text-xl text-white/60 sm:text-2xl max-w-3xl mx-auto animate-fade-in-up" style="animation-delay: 0.2s;">
                {{ $content['sous_titre'] }}
            </p>
        @endif

        @if(!empty($content['description']))
            <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-white/40 animate-fade-in-up" style="animation-delay: 0.3s;">
                {{ $content['description'] }}
            </p>
        @endif

        @if(!empty($content['cta_texte']) || !empty($content['cta2_texte']))
            <div class="mt-12 flex flex-wrap gap-4 {{ ($settings['alignement'] ?? 'center') === 'center' ? 'justify-center' : '' }} animate-fade-in-up" style="animation-delay: 0.4s;">
                @if(!empty($content['cta_texte']))
                    <a href="{{ $content['cta_lien'] ?? '#' }}"
                       class="group inline-flex items-center gap-3 rounded-2xl bg-white px-8 py-4 text-base font-semibold text-dark-900 shadow-xl transition-all duration-300 hover:shadow-2xl hover:shadow-white/10 hover:-translate-y-1">
                        {{ $content['cta_texte'] }}
                        <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
                @if(!empty($content['cta2_texte']))
                    <a href="{{ $content['cta2_lien'] ?? '#' }}"
                       class="group inline-flex items-center gap-3 rounded-2xl border border-white/15 bg-white/5 px-8 py-4 text-base font-semibold text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:bg-white/10 hover:border-white/25 hover:-translate-y-1">
                        {{ $content['cta2_texte'] }}
                        <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
            </div>
        @endif
        
        {{-- Scroll indicator --}}
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 animate-fade-in-up" style="animation-delay: 0.6s;">
            <div class="flex flex-col items-center gap-3 text-white/30">
                <span class="text-xs font-medium uppercase tracking-[0.2em]">Découvrir</span>
                <div class="w-6 h-10 rounded-full border border-white/20 flex items-start justify-center p-2">
                    <div class="w-1.5 h-3 rounded-full bg-white/40 animate-bounce"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
