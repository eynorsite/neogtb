@php
    $hauteur = match($settings['hauteur'] ?? 'medium') {
        'full' => 'min-h-screen',
        'medium' => 'min-h-[60vh]',
        'compact' => 'min-h-[40vh]',
        default => 'min-h-[60vh]',
    };
    $align = match($settings['alignement'] ?? 'center') {
        'left' => 'text-left items-start',
        'right' => 'text-right items-end',
        default => 'text-center items-center',
    };
@endphp

<section class="hero-gradient {{ $hauteur }} relative flex items-center justify-center overflow-hidden">
    @if(!empty($content['image']))
        <div class="absolute inset-0">
            <img src="{{ asset('storage/' . $content['image']) }}" alt="" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-black/{{ $settings['overlay'] ?? 40 }}"></div>
        </div>
    @endif

    <div class="relative z-10 mx-auto max-w-4xl px-4 py-20 {{ $align }}">
        @if(!empty($content['titre']))
            <h1 class="text-4xl font-black leading-tight text-white sm:text-5xl lg:text-6xl">
                {{ $content['titre'] }}
            </h1>
        @endif

        @if(!empty($content['sous_titre']))
            <p class="mt-4 text-lg text-blue-100 sm:text-xl lg:text-2xl">
                {{ $content['sous_titre'] }}
            </p>
        @endif

        @if(!empty($content['description']))
            <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-gray-300">
                {{ $content['description'] }}
            </p>
        @endif

        @if(!empty($content['cta_texte']))
            <a href="{{ $content['cta_lien'] ?? '#' }}"
               class="mt-8 inline-flex items-center gap-2 rounded-xl bg-white px-8 py-4 text-base font-bold text-primary-700 shadow-lg transition hover:bg-primary-50 hover:shadow-xl">
                {{ $content['cta_texte'] }}
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        @endif
    </div>
</section>
