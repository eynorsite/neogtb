@php $style = $settings['style'] ?? 'primary'; @endphp

<section class="relative overflow-hidden py-16 lg:py-28" style="background: linear-gradient(160deg, #060e1a 0%, #0c1b2f 30%, #142b47 60%, #10233b 100%);">
    {{-- Premium orbs --}}
    <div class="hero-orb" style="width: 300px; height: 300px; top: -60px; right: 15%; background: radial-gradient(circle, var(--color-accent-500) 0%, transparent 70%); opacity: 0.12; filter: blur(60px);"></div>
    <div class="hero-orb" style="width: 200px; height: 200px; bottom: -30px; left: 10%; background: radial-gradient(circle, var(--color-primary-400) 0%, transparent 70%); opacity: 0.1; filter: blur(50px);"></div>
    {{-- Grid --}}
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.03]"></div>
    {{-- Top edge --}}
    <div class="absolute top-0 inset-x-0 h-px" style="background: linear-gradient(90deg, transparent, rgba(45,139,78,0.2), transparent);"></div>

    <div class="relative z-10 mx-auto max-w-4xl px-4 text-center sm:px-6">
        @if(!empty($content['titre']))
            <h2 class="text-[28px] lg:text-[48px] font-heading font-extrabold text-white tracking-tight" style="letter-spacing: -0.03em;">
                {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span class="text-gradient-hero">$1</span>', e($content['titre'])) !!}
            </h2>
        @endif
        @if(!empty($content['sous_titre']))
            <p class="mx-auto mt-5 max-w-2xl text-lg" style="color: rgba(203,213,225,0.85); line-height: 1.65;">{{ $content['sous_titre'] }}</p>
        @endif
        @if(!empty($content['bouton_texte']) || !empty($content['bouton2_texte']))
            <div class="mt-12 flex flex-wrap gap-4 justify-center">
                @if(!empty($content['bouton_texte']))
                    <a href="{{ $content['bouton_lien'] ?? '#' }}"
                       class="inline-flex items-center gap-2.5 rounded-xl px-8 py-4 text-[15px] font-bold text-white btn-glow transition-all duration-300"
                       style="background: linear-gradient(135deg, var(--color-accent-500), var(--color-accent-700)); box-shadow: 0 4px 20px -4px rgba(45,139,78,0.4), inset 0 1px 0 rgba(255,255,255,0.12);">
                        {{ $content['bouton_texte'] }}
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
                @if(!empty($content['bouton2_texte']))
                    <a href="{{ $content['bouton2_lien'] ?? '#' }}"
                       class="inline-flex items-center gap-2 rounded-xl px-8 py-4 text-[15px] font-bold text-white backdrop-blur-md transition-all duration-300 hover:bg-white/12"
                       style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);">
                        {{ $content['bouton2_texte'] }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
