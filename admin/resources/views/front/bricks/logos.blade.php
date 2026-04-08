<section class="py-12 lg:py-24 bg-gradient-to-br from-dark-900 via-primary-900 to-dark-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.03]"></div>

    {{-- Decorative blurs --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-accent-500/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 mx-auto max-w-7xl px-5 lg:px-10">
        @if(!empty($content['titre']))
            <div class="text-center mb-14 animate-fade-in-up">
                <h2 class="text-[24px] lg:text-[32px] font-heading font-extrabold">{{ $content['titre'] }}</h2>
                @if(!empty($content['sous_titre']))
                    <p class="mt-4 text-lg text-dark-300 max-w-2xl mx-auto">{{ $content['sous_titre'] }}</p>
                @endif
                <div class="mt-6 mx-auto h-1 w-16 rounded-full bg-gradient-to-r from-primary-400 to-accent-400"></div>
            </div>
        @endif

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 lg:gap-6 items-center">
            @foreach($content['logos'] ?? [] as $i => $logo)
                <div class="group flex items-center justify-center p-5 lg:p-7 rounded-2xl glass border border-white/10 transition-all duration-300 hover:bg-white/20 hover:border-white/20 hover:scale-105 animate-fade-in-up"
                     style="animation-delay: {{ $i * 80 }}ms">
                    @if(!empty($logo['image']))
                        <img src="{{ $logo['image'] }}" alt="{{ $logo['nom'] ?? '' }}"
                             class="h-10 w-auto object-contain brightness-0 invert opacity-60 group-hover:opacity-100 transition-all duration-300 group-hover:scale-110">
                    @else
                        <span class="text-sm font-heading font-bold text-white/50 group-hover:text-white/90 transition-colors duration-300">{{ $logo['nom'] ?? '' }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
