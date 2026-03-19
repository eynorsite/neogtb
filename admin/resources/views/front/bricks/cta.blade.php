@php
    $style = $settings['style'] ?? 'primary';
    $bg = match($style) {
        'dark' => 'bg-dark text-white',
        'light' => 'bg-gray-50 text-gray-900',
        default => 'bg-primary-600 text-white',
    };
    $btnClass = match($style) {
        'dark' => 'bg-white text-dark hover:bg-gray-100',
        'light' => 'bg-primary-600 text-white hover:bg-primary-700',
        default => 'bg-white text-primary-700 hover:bg-primary-50',
    };
@endphp

<section class="{{ $bg }} py-16 lg:py-20">
    <div class="mx-auto max-w-4xl px-4 text-center sm:px-6">
        @if(!empty($content['titre']))
            <h2 class="text-3xl font-bold sm:text-4xl">{{ $content['titre'] }}</h2>
        @endif
        @if(!empty($content['sous_titre']))
            <p class="mx-auto mt-4 max-w-2xl text-lg opacity-90">{{ $content['sous_titre'] }}</p>
        @endif
        @if(!empty($content['bouton_texte']))
            <a href="{{ $content['bouton_lien'] ?? '#' }}"
               class="mt-8 inline-flex items-center gap-2 rounded-xl px-8 py-4 text-base font-bold shadow-lg transition {{ $btnClass }}">
                {{ $content['bouton_texte'] }}
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        @endif
    </div>
</section>
