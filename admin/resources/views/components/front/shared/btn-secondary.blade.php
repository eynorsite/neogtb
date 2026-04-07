@props(['href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn-secondary']) }}>
    {{ $slot }}
</a>
