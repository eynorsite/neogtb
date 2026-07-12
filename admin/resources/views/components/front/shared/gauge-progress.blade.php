@props([
    'label' => '',          // libellé à gauche (ex. "Audit validé")
    'value' => 0,           // pourcentage 0..100 — TOUJOURS une donnée réelle, jamais inventée (R1)
    'valueText' => null,    // texte affiché à droite ; si absent, on anime "{value} %"
    'caption' => null,      // légende discrète sous la barre (optionnel)
    'color' => 'accent',    // accent (vert) | gold (doré) | marine
])

@php
    $value = max(0, min(100, (int) $value));
    $bar = match ($color) {
        'gold'   => 'linear-gradient(90deg, var(--color-highlight-400), var(--color-highlight-500))',
        'marine' => 'linear-gradient(90deg, var(--color-primary-400), var(--color-primary-600))',
        default  => 'linear-gradient(90deg, var(--color-accent-500), var(--color-accent-600))',
    };
@endphp

{{--
    Barre de progression KPI (style "Audit validé X%" de la réf. SMT), palette NeoGTB.
    Animée à l'entrée dans le viewport via Alpine x-intersect (@alpinejs/intersect déjà chargé).
    La valeur est TOUJOURS passée en paramètre => aucune métrique fabriquée (garde-fou R1).
--}}
<div {{ $attributes->merge(['class' => 'w-full']) }}
     x-data="{ w: 0 }" x-intersect.once="w = {{ $value }}">
    <div class="flex items-center justify-between mb-2">
        @if($label)
            <span class="text-sm font-medium text-dark-700">{{ $label }}</span>
        @endif
        @if($valueText !== null)
            <span class="text-sm font-semibold text-dark-900">{{ $valueText }}</span>
        @else
            <span class="text-sm font-semibold text-dark-900" x-text="Math.round(w) + ' %'">{{ $value }} %</span>
        @endif
    </div>
    <div class="h-2.5 w-full rounded-full overflow-hidden" style="background: var(--color-dark-100);" role="progressbar" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="100" @if($label) aria-label="{{ $label }}" @endif>
        <div class="h-full rounded-full transition-[width] duration-1000 ease-out"
             style="width: 0%; background: {{ $bar }};"
             :style="`width: ${w}%`"></div>
    </div>
    @if($caption)
        <p class="mt-2 text-xs text-dark-400">{{ $caption }}</p>
    @endif
</div>
