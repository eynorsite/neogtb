@props([
    'name' => '',          // clé de l'icône (voir @switch ci-dessous)
    'size' => 24,          // taille en px (carré)
    'stroke' => 1.7,       // épaisseur du trait
])

{{--
    Jeu d'icônes SVG GTB — style line/outline, héritent de la couleur via currentColor.
    Inline (pas de fetch externe) => compatible CSP nonce, colorable par le parent.
    Usage : <x-front.shared.icon name="capteur" class="w-6 h-6 text-accent-600" />
    Réutilisé par le brick `cartes` quand `icone` vaut "icon:<name>".
    Ajouter une icône = ajouter un @case ci-dessous (viewBox 0 0 24 24).
--}}
<svg {{ $attributes->merge(['class' => 'inline-block']) }}
     width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24"
     fill="none" stroke="currentColor" stroke-width="{{ $stroke }}"
     stroke-linecap="round" stroke-linejoin="round"
     aria-hidden="true" focusable="false">
    @switch($name)
        @case('batiment')
            <path d="M4 21V4a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v17"/>
            <path d="M15 21V9h4a1 1 0 0 1 1 1v11"/>
            <line x1="2.5" y1="21" x2="21.5" y2="21"/>
            <path d="M7.5 7h1.5M11 7h1.5M7.5 10.5h1.5M11 10.5h1.5M7.5 14h1.5M11 14h1.5"/>
            @break

        @case('capteur')
            <circle cx="12" cy="17" r="1.3" fill="currentColor" stroke="none"/>
            <path d="M8.5 13.8a5 5 0 0 1 7 0"/>
            <path d="M6 11.2a8.5 8.5 0 0 1 12 0"/>
            @break

        @case('audit')
            <circle cx="10.5" cy="10.5" r="6"/>
            <line x1="15" y1="15" x2="20" y2="20"/>
            <path d="M8 10.6l2 2 3.4-3.6"/>
            @break

        @case('energie')
            <path d="M13 2 4.5 13.5H10l-1 8.5 9.5-12H13l.5-8Z"/>
            @break

        @case('eco')
            <path d="M5 19C5 11 11 5 19 5c0 8-6 14-14 14Z"/>
            <path d="M5.5 18.5c3-5 6-7 11-9"/>
            @break

        @case('conformite')
            <path d="M12 3l7 3v5c0 4.5-3 7.6-7 9-4-1.4-7-4.5-7-9V6l7-3Z"/>
            <path d="M9 11.8l2 2 4-4.2"/>
            @break

        @case('supervision')
            <rect x="3" y="4" width="18" height="13" rx="1.6"/>
            <line x1="8" y1="21" x2="16" y2="21"/>
            <line x1="12" y1="17" x2="12" y2="21"/>
            <path d="M7 13.5v-2.5M11 13.5V8.5M15 13.5v-4"/>
            @break

        @case('thermometre')
            <path d="M10 13.6V5a2 2 0 0 1 4 0v8.6a4 4 0 1 1-4 0Z"/>
            <line x1="12" y1="9" x2="12" y2="15"/>
            @break

        @case('compteur')
            <path d="M4 16a8 8 0 0 1 16 0"/>
            <line x1="12" y1="16" x2="16.2" y2="11.4"/>
            <circle cx="12" cy="16" r="1.3" fill="currentColor" stroke="none"/>
            @break

        @case('reseau')
            <circle cx="6" cy="6" r="2.3"/>
            <circle cx="18" cy="6" r="2.3"/>
            <circle cx="12" cy="18" r="2.3"/>
            <line x1="8.1" y1="6" x2="15.9" y2="6"/>
            <line x1="7.6" y1="7.6" x2="10.7" y2="16.2"/>
            <line x1="16.4" y1="7.6" x2="13.3" y2="16.2"/>
            @break

        @case('document')
            <path d="M6 3h7l5 5v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
            <path d="M13 3v5h5"/>
            <path d="M8.5 13l1.6 1.6L14 11"/>
            @break

        @case('euro')
            <circle cx="12" cy="12" r="8.5"/>
            <path d="M15.5 9.2a4 4 0 1 0 0 5.6"/>
            <line x1="6.8" y1="11" x2="12.5" y2="11"/>
            <line x1="6.8" y1="13.2" x2="11.8" y2="13.2"/>
            @break

        @default
            {{-- repli : pastille neutre --}}
            <circle cx="12" cy="12" r="8.5"/>
    @endswitch
</svg>
