@props([
    'active' => 'B',          // letter A/B/C/D currently active
    'progressFrom' => null,   // optional letter to mark "moving from" with arrow
])

@php
    $levels = ['D', 'C', 'B', 'A'];
@endphp

<div {{ $attributes->merge(['class' => 'gauge-en15232']) }}>
    @foreach($levels as $level)
        @php
            $isActive = $level === $active;
            $isFrom = $level === $progressFrom;
            $classes = 'gauge-en15232-bar level-' . strtolower($level);
            if ($isActive) {
                $classes .= ' active';
            } elseif (!$isFrom) {
                $classes .= ' dimmed';
            }
        @endphp
        <div class="{{ $classes }}" @if($isFrom) style="position: relative;" @endif>
            {{ $level }}
            @if($isFrom)
                <svg style="position: absolute; top: -10px; right: -6px;" width="12" height="12" viewBox="0 0 12 12">
                    <path d="M6 0l2 4h-4z" fill="var(--color-accent-600)" transform="rotate(90 6 6)"/>
                </svg>
            @endif
        </div>
    @endforeach
</div>
