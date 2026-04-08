{{-- Premium Cards Grid — Services/Features display --}}
@php
    $columns = $settings['colonnes'] ?? 3;
    $style = $settings['style'] ?? 'light';
    $gridCols = match((int)$columns) {
        2 => 'lg:grid-cols-2',
        4 => 'sm:grid-cols-2 lg:grid-cols-4',
        default => 'sm:grid-cols-2 lg:grid-cols-3',
    };
@endphp

<section class="py-24 lg:py-32 {{ $style === 'dark' ? 'bg-dark-950' : 'bg-white' }} relative overflow-hidden">
    @if($style !== 'dark')
        <div class="absolute inset-0 bg-gradient-radial opacity-30"></div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-dark-950 via-primary-900/20 to-dark-950"></div>
        <div class="absolute top-[20%] right-[10%] w-[400px] h-[400px] bg-accent-500/10 rounded-full blur-[120px]"></div>
    @endif
    
    <div class="relative z-10 max-w-[1280px] mx-auto px-6 md:px-10">
        {{-- Section Header --}}
        @if(!empty($content['titre_section']) || !empty($content['sous_titre']))
            <div class="text-center mb-16 lg:mb-20 max-w-3xl mx-auto">
                @if(!empty($content['eyebrow']))
                    <div class="badge-premium mb-6 animate-fade-in-up">
                        {{ $content['eyebrow'] }}
                    </div>
                @endif
                @if(!empty($content['titre_section']))
                    <h2 class="heading-premium text-3xl sm:text-4xl lg:text-5xl {{ $style === 'dark' ? 'text-white' : 'text-dark-900' }} animate-fade-in-up" style="animation-delay: 0.1s;">
                        {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span class="text-gradient">$1</span>', e($content['titre_section'])) !!}
                    </h2>
                @endif
                @if(!empty($content['sous_titre']))
                    <p class="subheading-premium mt-6 text-lg {{ $style === 'dark' ? 'text-white/60' : 'text-dark-500' }} animate-fade-in-up" style="animation-delay: 0.2s;">
                        {{ $content['sous_titre'] }}
                    </p>
                @endif
            </div>
        @endif

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 {{ $gridCols }} gap-6 lg:gap-8">
            @foreach($content['cartes'] ?? [] as $i => $carte)
                @if($style === 'dark')
                    {{-- Dark style card --}}
                    <a href="{{ $carte['lien'] ?? '#' }}" 
                       class="group relative rounded-2xl bg-white/[0.03] border border-white/[0.06] p-8 lg:p-10 transition-all duration-500 hover:bg-white/[0.06] hover:border-white/[0.1] hover:-translate-y-1 block animate-fade-in-up" 
                       style="animation-delay: {{ $i * 80 }}ms;">
                        
                        @if(!empty($carte['icone']))
                            <div class="mb-6 inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-accent-500/10 border border-accent-500/20 text-3xl transition-all duration-300 group-hover:scale-110 group-hover:bg-accent-500/15">
                                {{ $carte['icone'] }}
                            </div>
                        @endif
                        
                        @if(!empty($carte['titre']))
                            <h3 class="text-xl font-bold text-white mb-3 tracking-tight group-hover:text-accent-400 transition-colors duration-300">{{ $carte['titre'] }}</h3>
                        @endif
                        
                        @if(!empty($carte['description']))
                            <p class="text-white/50 leading-relaxed text-[15px]">{{ $carte['description'] }}</p>
                        @endif
                        
                        @if(!empty($carte['lien']))
                            <span class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-accent-400 transition-all duration-300 group-hover:gap-3">
                                En savoir plus
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        @endif
                    </a>
                @else
                    {{-- Light style card (premium) --}}
                    <a href="{{ $carte['lien'] ?? '#' }}" 
                       class="group card-premium p-8 lg:p-10 block animate-fade-in-up" 
                       style="animation-delay: {{ $i * 80 }}ms;">
                        
                        {{-- Accent bar on hover --}}
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-accent-500 to-accent-400 rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        @if(!empty($carte['icone']))
                            <div class="mb-6 inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-accent-50 text-3xl transition-all duration-300 group-hover:scale-110 group-hover:bg-accent-100">
                                {{ $carte['icone'] }}
                            </div>
                        @endif
                        
                        @if(!empty($carte['titre']))
                            <h3 class="text-xl font-bold text-dark-900 mb-3 tracking-tight group-hover:text-accent-600 transition-colors duration-300">{{ $carte['titre'] }}</h3>
                        @endif
                        
                        @if(!empty($carte['description']))
                            <p class="text-dark-500 leading-relaxed text-[15px]">{{ $carte['description'] }}</p>
                        @endif
                        
                        @if(!empty($carte['lien']))
                            <span class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-accent-600 transition-all duration-300 group-hover:gap-3">
                                En savoir plus
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        @endif
                    </a>
                @endif
            @endforeach
        </div>

        {{-- Optional bottom CTA --}}
        @if(!empty($content['cta_texte']))
            <div class="text-center mt-16 animate-fade-in-up" style="animation-delay: 0.4s;">
                <a href="{{ $content['cta_lien'] ?? '#' }}" class="{{ $style === 'dark' ? 'text-white border-white/20 hover:bg-white/10' : 'text-dark-900 border-dark-200 hover:bg-dark-50' }} inline-flex items-center gap-2 px-6 py-3 rounded-xl border font-medium transition-all duration-300">
                    {{ $content['cta_texte'] }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        @endif
    </div>
</section>
