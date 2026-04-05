<section class="py-20 bg-gradient-to-br from-dark-900 via-primary-900 to-dark-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.03]"></div>
    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if(!empty($content['titre']))
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-extrabold sm:text-4xl">{{ $content['titre'] }}</h2>
                @if(!empty($content['sous_titre']))
                    <p class="mt-4 text-lg text-dark-300 max-w-2xl mx-auto">{{ $content['sous_titre'] }}</p>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center">
            @foreach($content['logos'] ?? [] as $logo)
                <div class="flex items-center justify-center p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10 transition hover:bg-white/20">
                    @if(!empty($logo['image']))
                        <img src="{{ $logo['image'] }}" alt="{{ $logo['nom'] ?? '' }}" class="h-10 w-auto object-contain brightness-0 invert opacity-80">
                    @else
                        <span class="text-sm font-semibold text-white/70">{{ $logo['nom'] ?? '' }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
