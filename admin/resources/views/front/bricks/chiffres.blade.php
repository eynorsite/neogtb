{{-- chiffres : compteurs animés style Lovable (gère texte et nombres) --}}
<section class="relative py-12 lg:py-24 overflow-hidden bg-dark-50/50">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.02]"></div>
    <div class="relative z-10 max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">
        @if(!empty($content['eyebrow']) || !empty($content['titre']))
            <div class="text-center mb-12 animate-fade-in-up">
                @if(!empty($content['eyebrow']))
                    <p class="text-sm font-semibold uppercase tracking-wider text-accent-600">{{ $content['eyebrow'] }}</p>
                @endif
                @if(!empty($content['titre']))
                    <h2 class="font-display mt-2 text-[28px] lg:text-[40px] font-bold text-dark-900">{{ $content['titre'] }}</h2>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            @foreach($content['stats'] ?? [] as $i => $stat)
                @php
                    $raw = $stat['valeur'] ?? '';
                    $numericPart = preg_replace('/[^0-9]/', '', $raw);
                    $isNumeric = strlen($numericPart) > 0 && $numericPart !== '0';
                    $suffix = $isNumeric ? preg_replace('/[0-9]/', '', $raw) : '';
                    $target = $isNumeric ? (int) $numericPart : 0;
                @endphp
                <div class="text-center animate-fade-in-up" style="animation-delay: {{ $i * 100 }}ms"
                     @if($isNumeric)
                     x-data="statCounter"
                     data-target="{{ $target }}"
                     data-suffix="{{ $suffix }}"
                     x-intersect.once="start()"
                     @endif
                >
                    @if($isNumeric)
                        <div class="font-display text-3xl md:text-5xl lg:text-6xl font-bold" style="color: #10B981;" x-text="count + suffix"></div>
                    @else
                        <div class="font-display text-3xl md:text-5xl lg:text-6xl font-bold" style="color: #10B981;">{{ $raw }}</div>
                    @endif
                    <p class="mt-2 text-sm text-dark-500">{{ $stat['label'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
