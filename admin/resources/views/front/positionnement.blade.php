@extends('front.layouts.app')


@section('content')

<!-- HERO -->
<x-front.shared.hero
    image="/images/hero-gtb-illustration.webp"
    imageAlt="Conseil GTB indépendant — NeoGTB"
    eyebrow="Pourquoi NeoGTB"
    title="Vous cherchez un conseil GTB qui ne cherche rien à vous vendre"
    highlight="vendre"
    subtitle="Sur le marché français, celui qui conseille est souvent celui qui vend. NeoGTB est né pour offrir l'alternative : un regard technique, sans conflit d'intérêts."
    :tags="['0 € commission', '0 affiliation', '100 % indépendant']"
    :cta="['text' => 'Lancer le pré-diagnostic', 'url' => '/audit']"
    :cta2="['text' => 'Prendre contact', 'url' => '/contact']"
    minHeight="480px"
    overlay="gradient"
/>

<!-- PREUVES EN CHIFFRES -->
<section class="py-14 border-t border-b border-dark-200 bg-dark-50">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <p class="text-4xl font-medium text-dark-900 tracking-tight">0 &euro;</p>
                <p class="text-[13px] text-dark-400 mt-1.5 leading-snug">commission fabricant<br>depuis la création</p>
            </div>
            <div>
                <p class="text-4xl font-medium text-dark-900 tracking-tight">0</p>
                <p class="text-[13px] text-dark-400 mt-1.5 leading-snug">lien d'affiliation<br>sur le site</p>
            </div>
            <div>
                <p class="text-4xl font-medium text-dark-900 tracking-tight">10+</p>
                <p class="text-[13px] text-dark-400 mt-1.5 leading-snug">fabricants évalués<br>sur critères identiques</p>
            </div>
            <div>
                <p class="text-4xl font-medium text-accent-600 tracking-tight">100 %</p>
                <p class="text-[13px] text-dark-400 mt-1.5 leading-snug">du revenu vient<br>du conseil, pas de la vente</p>
            </div>
        </div>
    </div>
</section>

<!-- LE PROBLÈME -->
<section class="py-16">
    <div class="max-w-[760px] mx-auto px-6 md:px-10">
        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Le problème</p>
        <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-5">
            Pourquoi le conseil GTB classique pose problème
        </h2>
        <div class="space-y-4">
            @foreach([
                "L'intégrateur recommande le système qu'il installe. Son revenu dépend du volume vendu.",
                "Le fabricant oriente ses guides vers sa propre gamme. Le &laquo; conseil gratuit &raquo; n'est jamais gratuit.",
                "Résultat : systèmes surdimensionnés, protocoles choisis par habitude, maintenance qui explose.",
            ] as $i => $text)
            <div class="flex gap-3.5 items-start">
                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-red-100 text-red-600 text-[13px] font-semibold flex items-center justify-center">{{ $i + 1 }}</span>
                <p class="text-[15px] text-dark-600 leading-relaxed">{!! $text !!}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- COMMENT VÉRIFIER -->
<section class="py-16 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-[760px] mx-auto px-6 md:px-10">
        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Vérifiez vous-même</p>
        <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-6">
            Comment savoir si un conseil GTB est vraiment indépendant
        </h2>

        <div class="border border-dark-200 rounded-xl overflow-x-auto">
         <div class="min-w-[560px]">
            <div class="grid grid-cols-3 bg-dark-100 border-b border-dark-200">
                <p class="text-xs font-medium text-dark-400 p-3">Question à poser</p>
                <p class="text-xs font-medium text-dark-400 p-3 text-center">Intégrateur classique</p>
                <p class="text-xs font-medium text-accent-600 p-3 text-center">NeoGTB</p>
            </div>
            @foreach([
                ['q' => 'Vendez-vous du matériel ?', 'classic' => 'Oui', 'neo' => 'Non'],
                ['q' => 'Commission sur les ventes ?', 'classic' => 'Souvent', 'neo' => '0 &euro;, toujours'],
                ['q' => 'Critères de comparaison publics ?', 'classic' => 'Rarement', 'neo' => 'Oui, sur le site'],
                ['q' => 'Outils accessibles sans inscription ?', 'classic' => 'Non', 'neo' => 'Oui, 3 outils gratuits'],
            ] as $row)
            <div class="grid grid-cols-3 border-b border-dark-100 last:border-b-0">
                <p class="text-sm text-dark-600 p-3">{!! $row['q'] !!}</p>
                <p class="text-sm text-dark-400 p-3 text-center">{{ $row['classic'] }}</p>
                <p class="text-sm text-accent-600 font-medium p-3 text-center">{!! $row['neo'] !!}</p>
            </div>
            @endforeach
         </div>
        </div>
        @include('front.bricks.cta-mini.cta-text-link-underline', ['beforeText' => 'Envie de confronter ces critères à un cas concret ?', 'linkText' => 'Le pré-diagnostic est un bon test de la méthode', 'href' => '/audit', 'afterText' => '.'])
    </div>
</section>

<!-- MODÈLE ÉCONOMIQUE -->
<section class="py-16">
    <div class="max-w-[760px] mx-auto px-6 md:px-10">
        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Transparence</p>
        <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">
            Comment NeoGTB gagne de l'argent
        </h2>
        <p class="text-[15px] text-dark-500 leading-relaxed mb-7">
            Un site gratuit qui ne vend rien — vous avez raison de vous demander où est le piège. Il n'y en a pas. Voici le modèle, en clair.
        </p>

        <!-- Le modèle -->
        <div class="bg-dark-50 border border-dark-200 rounded-xl p-7 mb-6">
            <p class="text-xs font-medium text-dark-400 uppercase tracking-widest mb-4">Le modèle</p>
            <div class="space-y-4">
                @foreach([
                    '<strong class="font-medium text-dark-900">NeoGTB vend du conseil, pas du matériel.</strong> Audits sur site, cahiers des charges neutres, assistance à maîtrise d\'ouvrage GTB. C\'est une activité de conseil technique facturée, comme un bureau d\'études.',
                    '<strong class="font-medium text-dark-900">Les outils en ligne restent gratuits.</strong> Diagnostic, comparateur, générateur CEE : ils sont là pour démontrer l\'approche, pas pour capturer des leads. Pas d\'inscription obligatoire, pas de relance commerciale.',
                    '<strong class="font-medium text-dark-900">Zéro commission, zéro affiliation.</strong> Si BACnet est recommandé plutôt que LON, c\'est technique, pas commercial. Aucun fabricant ne rémunère NeoGTB, directement ou indirectement.',
                ] as $text)
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-accent-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm text-dark-700 leading-relaxed">{!! $text !!}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Ce que NeoGTB ne fait PAS -->
        <div class="border border-dark-200 rounded-xl p-7">
            <p class="text-xs font-medium text-dark-400 uppercase tracking-widest mb-4">Ce que NeoGTB ne fait pas</p>
            <div class="space-y-3">
                @foreach([
                    'Revendre vos données de diagnostic à des tiers',
                    'Transmettre vos coordonnées à des installateurs ou fabricants',
                    'Utiliser les outils gratuits comme produit d\'appel vers une offre cachée',
                    'Toucher des commissions si vous choisissez un fournisseur recommandé',
                ] as $text)
                <div class="flex items-start gap-2.5">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    <p class="text-sm text-dark-500 leading-snug">{{ $text }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <p class="text-[13px] text-dark-400 leading-relaxed mt-5">
            Vous avez encore un doute ? C'est normal. <a href="/contact" class="text-accent-600 hover:text-accent-700">Posez la question</a>, on y répond.
        </p>
    </div>
</section>

<!-- CTA -->
<section class="relative overflow-hidden py-12 md:py-20 bg-dark-100 border-t border-dark-200">
    <img src="/images/hero-gtb-illustration.webp" alt="" aria-hidden="true" width="1200" height="630" loading="lazy" class="absolute right-0 top-0 h-full w-auto object-cover opacity-20" />
    <div class="absolute inset-0 bg-gradient-to-r from-dark-100 via-dark-100/80 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10 flex items-center min-h-[200px]">
        <div class="max-w-lg">
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Testez l'approche</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">Pré-diagnostic ISO 52120-1 gratuit, comparateur sans biais, générateur CEE. Aucune inscription requise.</p>
            <div class="flex flex-wrap gap-3">
                <a href="/audit" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
                    Diagnostic gratuit
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="/contact" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-600 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                    Prendre contact
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Related pages -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['href' => '/about', 'title' => "À propos d'Ulrich Calmo", 'desc' => 'Parcours et méthode du fondateur de NeoGTB.'],
                ['href' => '/audit', 'title' => 'Audit GTB gratuit', 'desc' => 'Testez notre approche avec un pré-diagnostic ISO 52120-1.'],
                ['href' => '/contact', 'title' => 'Contactez-nous', 'desc' => 'Un projet GTB ? Parlons-en sans engagement.'],
            ] as $link)
            <a href="{{ $link['href'] }}" class="block bg-dark-50 rounded-xl p-6 border border-dark-200 card-hover-glow">
                <h3 class="text-[15px] font-medium text-dark-900 mb-1">{{ $link['title'] }}</h3>
                <p class="text-sm text-dark-500">{{ $link['desc'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
