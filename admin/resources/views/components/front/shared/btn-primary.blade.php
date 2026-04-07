@props(['href' => '#', 'arrow' => true])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn-primary']) }}>
    {{ $slot }}
    @if($arrow)
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    @endif
</a>
