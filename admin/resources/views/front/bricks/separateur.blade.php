@php $h = $settings['hauteur'] ?? 40; $style = $settings['style'] ?? 'ligne'; @endphp

<div style="height: {{ $h }}px" class="flex items-center justify-center" aria-hidden="true">
    @if($style === 'ligne')
        <div class="mx-auto h-px w-full max-w-7xl bg-gradient-to-r from-transparent via-dark-200 to-transparent"></div>
    @elseif($style === 'pointilles')
        <div class="mx-auto w-full max-w-7xl flex items-center justify-center gap-2">
            <div class="h-px flex-1 bg-gradient-to-r from-transparent to-dark-200"></div>
            <div class="flex gap-1.5">
                <div class="h-1.5 w-1.5 rounded-full bg-primary-300"></div>
                <div class="h-1.5 w-1.5 rounded-full bg-accent-400"></div>
                <div class="h-1.5 w-1.5 rounded-full bg-primary-300"></div>
            </div>
            <div class="h-px flex-1 bg-gradient-to-l from-transparent to-dark-200"></div>
        </div>
    @endif
</div>
