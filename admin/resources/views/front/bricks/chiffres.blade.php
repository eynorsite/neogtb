<section class="py-24 relative overflow-hidden" style="background-color: {{ $settings['couleur_fond'] ?? '#F8FAFC' }}">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.02]"></div>
    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if(!empty($content['titre']))
            <div class="text-center mb-16 animate-fade-in-up">
                <h2 class="text-3xl font-heading font-extrabold text-dark-900 sm:text-4xl lg:text-5xl">{{ $content['titre'] }}</h2>
                @if(!empty($content['sous_titre']))
                    <p class="mt-4 text-lg text-dark-500 max-w-2xl mx-auto">{{ $content['sous_titre'] }}</p>
                @endif
                <div class="mt-6 mx-auto h-1 w-16 rounded-full bg-gradient-to-r from-primary-500 to-accent-500"></div>
            </div>
        @endif

        <div class="grid grid-cols-2 gap-6 sm:gap-8 lg:gap-10 sm:grid-cols-3 lg:grid-cols-{{ min(count($content['stats'] ?? []), 4) }}">
            @foreach($content['stats'] ?? [] as $i => $stat)
                <div class="relative text-center p-8 rounded-2xl bg-white shadow-sm border border-dark-100 card-hover group animate-fade-in-up"
                     style="animation-delay: {{ $i * 120 }}ms"
                     x-data="{ shown: false, val: 0 }"
                     x-intersect.once="shown = true; let target = parseInt('{{ preg_replace('/[^0-9]/', '', $stat['valeur'] ?? '0') }}'); let step = Math.ceil(target / 40); let interval = setInterval(() => { val += step; if (val >= target) { val = target; clearInterval(interval); } }, 30);">

                    {{-- Decorative gradient --}}
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50 to-accent-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    <div class="relative">
                        @if(!empty($stat['icone']))
                            <span class="inline-block text-4xl mb-4 group-hover:scale-110 transition-transform duration-300">{{ $stat['icone'] }}</span>
                        @endif

                        <div class="text-4xl sm:text-5xl font-heading font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-primary-800">
                            <span x-text="val">{{ preg_replace('/[^0-9]/', '', $stat['valeur'] ?? '0') }}</span>{{ $stat['suffixe'] ?? '' }}
                        </div>

                        <div class="mt-3 text-sm font-semibold text-dark-500 uppercase tracking-wide">{{ $stat['label'] ?? '' }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
