{{--
    Bandeau de réassurance NeoGTB — partial réutilisable.
    Ligne de badges discrète, light mode, sans JS.
    Usage : @include('front.partials.reassurance-badges')
    Option : passer $class pour ajuster les marges au contexte d'inclusion.
        @include('front.partials.reassurance-badges', ['class' => 'mt-8'])
--}}
@php
    // Badges factuels — engagements vérifiables, ton tiers de confiance indépendant.
    $reassuranceBadges = [
        'Indépendant',
        '0 commission',
        '0 matériel vendu',
        'ISO 52120-1',
        '0 cookie',
    ];
@endphp

<ul role="list"
    aria-label="Nos engagements"
    class="not-prose flex flex-wrap items-center justify-center gap-x-3 gap-y-2 text-[13px] text-dark-600 {{ $class ?? '' }}">
    @foreach ($reassuranceBadges as $badge)
        <li class="inline-flex items-center gap-x-3">
            @unless ($loop->first)
                {{-- Séparateur décoratif, masqué aux lecteurs d'écran --}}
                <span aria-hidden="true" class="text-dark-300 select-none">·</span>
            @endunless
            <span class="font-medium whitespace-nowrap">{{ $badge }}</span>
        </li>
    @endforeach
</ul>
