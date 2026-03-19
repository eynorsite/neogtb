@php
    $style = $settings['style'] ?? 'primary';
@endphp

@if($style === 'dark' || $style === 'primary')
<section class="relative overflow-hidden bg-gradient-to-br from-dark-950 via-primary-900 to-dark-900 py-20 lg:py-24">
    <div class="absolute top-10 right-10 w-64 h-64 bg-accent-500/15 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-10 left-10 w-48 h-48 bg-primary-500/20 rounded-full blur-3xl animate-float" style="animation-delay: -2s;"></div>
    <div class="relative z-10 mx-auto max-w-4xl px-4 text-center sm:px-6">
        @if(!empty($content['titre']))
            <h2 class="text-3xl font-heading font-extrabold text-white sm:text-4xl lg:text-5xl">{{ $content['titre'] }}</h2>
        @endif
        @if(!empty($content['sous_titre']))
            <p class="mx-auto mt-4 max-w-2xl text-lg text-dark-300">{{ $content['sous_titre'] }}</p>
        @endif
        @if(!empty($content['bouton_texte']))
            <div class="mt-10 flex flex-wrap gap-4 justify-center">
                <a href="{{ $content['bouton_lien'] ?? '#' }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-accent-500 px-8 py-4 text-base font-bold text-dark-900 shadow-lg transition hover:bg-accent-600 btn-glow">
                    {{ $content['bouton_texte'] }}
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        @endif
    </div>
</section>
@else
<section class="bg-dark-50 py-16 lg:py-20">
    <div class="mx-auto max-w-4xl px-4 text-center sm:px-6">
        @if(!empty($content['titre']))
            <h2 class="text-3xl font-heading font-extrabold text-dark-900 sm:text-4xl">{{ $content['titre'] }}</h2>
        @endif
        @if(!empty($content['sous_titre']))
            <p class="mx-auto mt-4 max-w-2xl text-lg text-dark-500">{{ $content['sous_titre'] }}</p>
        @endif
        @if(!empty($content['bouton_texte']))
            <a href="{{ $content['bouton_lien'] ?? '#' }}"
               class="mt-8 inline-flex items-center gap-2 rounded-xl bg-primary-600 px-8 py-4 text-base font-bold text-white shadow-lg transition hover:bg-primary-700 btn-glow">
                {{ $content['bouton_texte'] }}
            </a>
        @endif
    </div>
</section>
@endif
