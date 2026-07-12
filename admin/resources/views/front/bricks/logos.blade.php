<section class="py-12 lg:py-24 bg-white relative overflow-hidden">
    {{-- Fond clair cohérent avec la signature "light mode" du site (DESIGN.md §2). --}}
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.4]" aria-hidden="true"></div>
    <div class="absolute -top-24 right-1/4 w-96 h-96 glow-halo glow-halo--accent" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto max-w-7xl px-5 lg:px-10">
        @if(!empty($content['titre']))
            <div class="text-center mb-14 animate-fade-in-up">
                <h2 class="text-[24px] lg:text-[32px] font-heading font-extrabold text-[#111827]">{{ $content['titre'] }}</h2>
                @if(!empty($content['sous_titre']))
                    <p class="mt-4 text-lg text-dark-600 max-w-2xl mx-auto">{{ $content['sous_titre'] }}</p>
                @endif
                <div class="mt-6 mx-auto h-1 w-16 rounded-full bg-gradient-to-r from-primary-500 to-accent-500"></div>
            </div>
        @endif

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 lg:gap-6 items-stretch">
            @foreach($content['logos'] ?? [] as $i => $logo)
                @php $nom = $logo['nom'] ?? 'Marque'; @endphp
                {{-- Chaque logo pointe vers le comparateur (posture "au-dessus des marques").
                     Gris par défaut -> couleur au survol (social-proof pattern), sur fond clair. --}}
                <a href="/comparateur"
                   title="Technologie maîtrisée par NeoGTB — voir le comparateur"
                   aria-label="{{ $nom }} : technologie maîtrisée par NeoGTB, ouvrir le comparateur indépendant"
                   class="group flex items-center justify-center p-5 lg:p-7 rounded-2xl bg-white border border-dark-200 transition-all duration-300 hover:border-accent-200 hover:shadow-[0_8px_24px_-8px_rgba(45,139,78,0.15)] hover:-translate-y-0.5 animate-fade-in-up"
                   style="animation-delay: {{ $i * 80 }}ms">
                    @if(!empty($logo['image']))
                        <img src="{{ $logo['image'] }}" alt="Logo {{ $nom }}"
                             loading="lazy"
                             class="h-10 w-auto object-contain grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                    @else
                        <span class="text-sm font-heading font-bold text-dark-500 group-hover:text-accent-600 transition-colors duration-300">{{ $nom }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Mention légale de neutralité — OBLIGATOIRE, non supprimable (DESIGN.md §10, LOGOS_PARTENAIRES.md).
             En dur volontairement : garantit qu'elle ne peut pas être retirée par erreur depuis l'admin. --}}
        <p class="mt-10 text-center text-sm text-dark-500 max-w-3xl mx-auto">
            NeoGTB est <strong class="text-dark-600 font-semibold">indépendant de ces marques</strong> et ne perçoit aucune
            commission. Ces technologies sont analysées en toute objectivité dans notre
            <a href="/comparateur" class="text-accent-600 font-medium underline decoration-accent-200 underline-offset-2 hover:decoration-accent-600 transition-colors">comparateur indépendant</a>.
        </p>
    </div>
</section>
