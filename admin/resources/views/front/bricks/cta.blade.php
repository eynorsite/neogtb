@php $style = $settings['style'] ?? 'primary'; @endphp

<section class="relative overflow-hidden bg-accent-500 py-12 lg:py-24">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,_rgba(255,255,255,0.15),_transparent_60%)]"></div>
    <div class="relative z-10 mx-auto max-w-3xl px-4 text-center sm:px-6">
        @if(!empty($content['titre']))
            <h2 class="font-display text-3xl font-bold text-white md:text-4xl">
                {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span style="opacity: 0.9;">$1</span>', e($content['titre'])) !!}
            </h2>
        @endif
        @if(!empty($content['sous_titre']))
            <p class="mt-4 text-lg text-white/80">{{ $content['sous_titre'] }}</p>
        @endif
        @if(!empty($content['bouton_texte']) || !empty($content['bouton2_texte']))
            <div class="mt-8 flex flex-wrap gap-4 justify-center">
                @if(!empty($content['bouton_texte']))
                    <a href="{{ $content['bouton_lien'] ?? '#' }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-white px-8 py-4 text-base font-semibold text-dark-900 shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        {{ $content['bouton_texte'] }}
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
                @if(!empty($content['bouton2_texte']))
                    <a href="{{ $content['bouton2_lien'] ?? '#' }}"
                       class="inline-flex items-center gap-2 rounded-lg border-2 border-white/30 px-8 py-4 text-base font-semibold text-white transition-all duration-300 hover:bg-white/10">
                        {{ $content['bouton2_texte'] }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
