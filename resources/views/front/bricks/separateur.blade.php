@php $h = $settings['hauteur'] ?? 40; $style = $settings['style'] ?? 'ligne'; @endphp

<div style="height: {{ $h }}px" class="flex items-center justify-center">
    @if($style === 'ligne')
        <div class="mx-auto h-px w-full max-w-7xl bg-gray-200"></div>
    @elseif($style === 'pointilles')
        <div class="mx-auto h-px w-full max-w-7xl border-t border-dashed border-gray-300"></div>
    @endif
</div>
