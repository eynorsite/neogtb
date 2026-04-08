{{-- Premium Stats Bar —  impactant et minimal --}}
@php
    $style = $settings['style'] ?? 'bar';
@endphp

@if($style === 'cards')
{{-- STYLE CARDS — Grande mise en avant avec cartes premium --}}
<section class="py-24 lg:py-32 bg-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-radial opacity-40"></div>
    
    <div class="relative z-10 max-w-[1280px] mx-auto px-6 md:px-10">
        @if(!empty($content['titre']))
            <div class="text-center mb-16 animate-fade-in-up">
                <h2 class="heading-premium text-3xl sm:text-4xl lg:text-5xl text-dark-900">{{ $content['titre'] }}</h2>
                @if(!empty($content['sous_titre']))
                    <p class="subheading-premium mt-4 text-lg text-dark-500 max-w-2xl mx-auto">{{ $content['sous_titre'] }}</p>
                @endif
            </div>
        @endif
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($content['stats'] ?? [] as $i => $stat)
                <div class="card-premium p-8 text-center animate-fade-in-up" style="animation-delay: {{ $i * 100 }}ms;">
                    <p class="stat-number mb-3">{{ $stat['valeur'] ?? '' }}</p>
                    <p class="text-sm text-dark-500 font-medium">{{ $stat['label'] ?? '' }}</p>
                    @if(!empty($stat['description']))
                        <p class="mt-2 text-xs text-dark-400">{{ $stat['description'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

@elseif($style === 'inline')
{{-- STYLE INLINE — Compact dans une section --}}
<section class="py-16 bg-dark-50/50 border-y border-dark-100">
    <div class="max-w-[1280px] mx-auto px-6 md:px-10">
        <div class="flex flex-wrap justify-center gap-x-16 gap-y-8">
            @foreach($content['stats'] ?? [] as $i => $stat)
                <div class="flex items-baseline gap-3 animate-fade-in-up" style="animation-delay: {{ $i * 100 }}ms;">
                    <span class="text-4xl lg:text-5xl font-bold tracking-tight text-dark-900">{{ $stat['valeur'] ?? '' }}</span>
                    <span class="text-sm text-dark-500 font-medium max-w-[120px]">{{ $stat['label'] ?? '' }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

@else
{{-- STYLE BAR (défaut) — Barre minimaliste premium --}}
<section class="relative overflow-hidden" style="background: linear-gradient(180deg, #fafafa 0%, #fff 100%); border-top: 1px solid rgba(0,0,0,0.04); border-bottom: 1px solid rgba(0,0,0,0.04);">
    <div class="max-w-[1280px] mx-auto px-6 md:px-10 py-12 lg:py-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">
            @foreach($content['stats'] ?? [] as $i => $stat)
                <div class="relative text-center animate-fade-in-up" style="animation-delay: {{ $i * 80 }}ms;">
                    {{-- Subtle separator --}}
                    @if($i > 0)
                        <div class="hidden md:block absolute left-0 top-1/2 -translate-y-1/2 w-px h-12 bg-gradient-to-b from-transparent via-dark-200 to-transparent"></div>
                    @endif
                    
                    <p class="text-3xl lg:text-4xl font-bold tracking-tight text-dark-900 mb-1">
                        {{ $stat['valeur'] ?? '' }}
                    </p>
                    <p class="text-xs lg:text-sm text-dark-500 font-medium tracking-wide">
                        {{ $stat['label'] ?? '' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
