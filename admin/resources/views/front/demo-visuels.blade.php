@extends('front.layouts.app')

{{-- Page vitrine interne : bibliothèque des visuels « inspiration SMT » en palette NeoGTB.
     NON indexée (interne). Sert à valider le rendu et de guide de placement en admin. --}}
@section('noindex', 'true')

@section('content')

{{-- HERO --}}
<x-front.shared.hero
    image="/images/hero-neogtb.webp"
    imageAlt="Bâtiment tertiaire équipé d'une GTB"
    eyebrow="Bibliothèque interne"
    title="Visuels NeoGTB"
    subtitle="Schémas pédagogiques, icônes, bandeaux de chiffres et barres de progression — inspirés des dispositifs de smt-en.com, mais calés sur l'identité claire NeoGTB (marine, vert, touches dorées). Aperçu et guide de placement."
    minHeight="420px"
    overlay="gradient"
/>

{{-- 1 — SCHÉMAS PÉDAGOGIQUES GTB (SVG) --}}
<section class="py-12 lg:py-20">
    <div class="max-w-[1280px] mx-auto px-5 lg:px-10">
        <x-front.shared.section-header
            eyebrow="Schémas pédagogiques"
            title="3 schémas GTB prêts à l'emploi"
            intro="Vectoriels (SVG), nets à toutes les tailles, sans dépendance externe. À utiliser comme image dans un brick (hero, carte, texte enrichi) ou une page GTB/GTC/Solutions."
            align="center"
            maxWidth="2xl"
        />

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Architecture 3 niveaux --}}
            <x-front.shared.card padding="p-6 lg:p-8">
                <img src="/images/schemas/architecture-gtb-3-niveaux.svg"
                     alt="Architecture fonctionnelle d'une GTB en 3 niveaux : gestion, automation, terrain"
                     class="w-full h-auto" loading="lazy" decoding="async" />
                <h3 class="mt-5 font-display font-semibold text-dark-900">Architecture GTB — 3 niveaux</h3>
                <p class="mt-1 text-sm text-dark-500">Gestion · Automation · Terrain. Idéal sur la page GTB ou Solutions.</p>
                <code class="mt-3 inline-block text-[11px] text-dark-400">/images/schemas/architecture-gtb-3-niveaux.svg</code>
            </x-front.shared.card>

            {{-- Pyramide EN 15232 --}}
            <x-front.shared.card padding="p-6 lg:p-8">
                <img src="/images/schemas/pyramide-en15232.svg"
                     alt="Pyramide des classes d'efficacité énergétique EN 15232 / ISO 52120-1, de D à A"
                     class="w-full h-auto" loading="lazy" decoding="async" />
                <h3 class="mt-5 font-display font-semibold text-dark-900">Classes EN 15232 / ISO 52120-1</h3>
                <p class="mt-1 text-sm text-dark-500">Classes D → A. Idéal sur Réglementation / Décret BACS.</p>
                <code class="mt-3 inline-block text-[11px] text-dark-400">/images/schemas/pyramide-en15232.svg</code>
            </x-front.shared.card>

            {{-- Flux de données --}}
            <x-front.shared.card padding="p-6 lg:p-8" class="lg:col-span-2">
                <img src="/images/schemas/flux-donnees-gtb.svg"
                     alt="Chaîne de données d'une GTB : capteurs, bus de terrain, superviseur, pilotage et reporting"
                     class="w-full h-auto" loading="lazy" decoding="async" />
                <h3 class="mt-5 font-display font-semibold text-dark-900">Flux de données d'une GTB</h3>
                <p class="mt-1 text-sm text-dark-500">Capteurs → Bus de terrain → Superviseur → Pilotage. Idéal en bandeau pleine largeur.</p>
                <code class="mt-3 inline-block text-[11px] text-dark-400">/images/schemas/flux-donnees-gtb.svg</code>
            </x-front.shared.card>
        </div>
    </div>
</section>

{{-- 2 — CARTES À ICÔNES (jeu d'icônes SVG) --}}
<section class="py-12 lg:py-20 bg-dark-50/50">
    <div class="max-w-[1280px] mx-auto px-5 lg:px-10">
        <x-front.shared.section-header
            eyebrow="Cartes à icônes"
            title="Jeu d'icônes GTB"
            intro="Icônes vectorielles cohérentes (style trait), colorées via le thème. Dans le brick « Cartes », saisissez simplement icon:nom dans le champ icône."
            align="center"
            maxWidth="2xl"
        />

        @php
            $iconCards = [
                ['icon' => 'batiment',    'titre' => 'Bâtiment tertiaire',  'desc' => 'Bureaux, écoles, hôpitaux, collectivités concernés par le décret BACS.', 'key' => 'icon:batiment'],
                ['icon' => 'capteur',     'titre' => 'Capteurs & terrain',  'desc' => 'Température, CO₂, présence, comptage d\'énergie.', 'key' => 'icon:capteur'],
                ['icon' => 'supervision', 'titre' => 'Supervision GTB',     'desc' => 'Pilotage centralisé, tableaux de bord, alarmes.', 'key' => 'icon:supervision'],
                ['icon' => 'conformite',  'titre' => 'Conformité BACS',     'desc' => 'GTB de classe B selon NF EN ISO 52120-1.', 'key' => 'icon:conformite'],
                ['icon' => 'audit',       'titre' => 'Pré-diagnostic',      'desc' => 'État des lieux de l\'installation selon ISO 52120-1.', 'key' => 'icon:audit'],
                ['icon' => 'reseau',      'titre' => 'Interopérabilité',    'desc' => 'Modbus, KNX, BACnet, LON — architecture ouverte.', 'key' => 'icon:reseau'],
                ['icon' => 'thermometre', 'titre' => 'CVC & confort',       'desc' => 'Chauffage, ventilation, climatisation pilotés.', 'key' => 'icon:thermometre'],
                ['icon' => 'euro',        'titre' => 'CEE & financement',   'desc' => 'Valorisation des économies (BAT-TH-116).', 'key' => 'icon:euro'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            @foreach($iconCards as $c)
                <div class="group glass-card rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-accent-500/10 text-accent-600 transition-all duration-300 group-hover:bg-accent-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-accent-500/30">
                        <x-front.shared.icon :name="$c['icon']" class="w-6 h-6" />
                    </div>
                    <h3 class="font-display font-semibold text-dark-900">{{ $c['titre'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-dark-500">{{ $c['desc'] }}</p>
                    <code class="mt-3 inline-block text-[11px] text-dark-400">{{ $c['key'] }}</code>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 3 — BANDEAU DE CHIFFRES (KPI honnêtes, R1) --}}
<section class="relative py-14 lg:py-20 overflow-hidden bg-primary-900">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.04]"></div>
    <div class="glow-halo glow-halo--accent absolute -top-32 left-1/2 -translate-x-1/2 w-[480px] h-[480px]" aria-hidden="true"></div>
    <div class="relative z-10 max-w-[1280px] mx-auto px-5 lg:px-10">
        <div class="text-center mb-10 lg:mb-12">
            <p class="text-sm font-semibold uppercase tracking-wider text-accent-400">Bandeau de chiffres</p>
            <h2 class="font-display mt-2 text-[28px] lg:text-[40px] font-bold text-white">Le modèle NeoGTB en clair</h2>
            <p class="mt-3 text-sm text-primary-200 max-w-xl mx-auto">Valeurs factuelles déjà affirmées sur le site — pas de compteur fabriqué. Pour des compteurs numériques, utilisez le brick « Chiffres clés » (variante bandeau) avec des données réelles.</p>
        </div>
        @php
            // KPI factuels, repris du positionnement existant (footer + pages À propos / Contact).
            $kpis = [
                ['valeur' => '100 %', 'label' => 'Indépendant des fabricants'],
                ['valeur' => '0',     'label' => 'Commission, aucune revente de données'],
                ['valeur' => '48 h',  'label' => 'Délai de réponse (jours ouvrés)'],
                ['valeur' => 'Classe B', 'label' => 'Niveau visé / condition prime CEE'],
            ];
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-10">
            @foreach($kpis as $k)
                <div class="text-center">
                    <div class="font-display text-4xl md:text-5xl font-bold text-white">{{ $k['valeur'] }}</div>
                    <p class="mt-2 text-sm text-primary-200">{{ $k['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 4 — BARRES DE PROGRESSION (gauge-progress) --}}
<section class="py-12 lg:py-20">
    <div class="max-w-[1280px] mx-auto px-5 lg:px-10">
        <x-front.shared.section-header
            eyebrow="Barres de progression"
            title="Composant « jauge » (style SMT)"
            intro="Barre animée à l'apparition. La valeur est toujours un paramètre — à brancher sur une donnée réelle (avancement d'un audit, taux de conformité d'un parc, etc.). Exemples d'affichage ci-dessous."
            align="center"
            maxWidth="2xl"
        />

        <div class="max-w-2xl mx-auto grid gap-7">
            <x-front.shared.gauge-progress
                label="Audit validé — exemple"
                :value="72"
                color="accent"
                caption="Exemple d'affichage. Branchez la valeur sur l'avancement réel d'un dossier."
            />
            <x-front.shared.gauge-progress
                label="Conformité du parc — exemple"
                :value="40"
                color="marine"
                caption="Exemple d'affichage. À alimenter par une donnée vérifiable, jamais une estimation."
            />
            <x-front.shared.gauge-progress
                label="Dossier CEE constitué — exemple"
                :value="88"
                color="gold"
                caption="Exemple d'affichage."
            />
        </div>
    </div>
</section>

{{-- 5 — GUIDE DE PLACEMENT EN ADMIN --}}
<section class="py-12 lg:py-20 bg-dark-50/50">
    <div class="max-w-[1280px] mx-auto px-5 lg:px-10">
        <x-front.shared.section-header
            eyebrow="Guide"
            title="Où placer chaque visuel dans l'admin"
            align="center"
            maxWidth="2xl"
        />
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse bg-white rounded-2xl overflow-hidden" style="border: 0.5px solid var(--color-dark-200);">
                <thead>
                    <tr class="bg-primary-900 text-white">
                        <th class="px-5 py-3 font-semibold">Visuel</th>
                        <th class="px-5 py-3 font-semibold">Comment l'intégrer</th>
                        <th class="px-5 py-3 font-semibold">Page / brick conseillé</th>
                    </tr>
                </thead>
                <tbody class="text-dark-700">
                    <tr style="border-top: 0.5px solid var(--color-dark-200);">
                        <td class="px-5 py-3 font-medium">Schémas GTB (SVG)</td>
                        <td class="px-5 py-3 text-dark-500">Champ image d'un brick → coller le chemin <code class="text-[12px]">/images/schemas/…svg</code></td>
                        <td class="px-5 py-3 text-dark-500">GTB, Solutions, Réglementation (brick Cartes ou Texte enrichi)</td>
                    </tr>
                    <tr style="border-top: 0.5px solid var(--color-dark-200);">
                        <td class="px-5 py-3 font-medium">Icônes GTB</td>
                        <td class="px-5 py-3 text-dark-500">Brick <strong>Cartes</strong> → champ icône = <code class="text-[12px]">icon:capteur</code> (etc.)</td>
                        <td class="px-5 py-3 text-dark-500">Accueil, Offres, Solutions</td>
                    </tr>
                    <tr style="border-top: 0.5px solid var(--color-dark-200);">
                        <td class="px-5 py-3 font-medium">Bandeau de chiffres</td>
                        <td class="px-5 py-3 text-dark-500">Brick <strong>Chiffres clés</strong> → variante « bandeau » + valeurs <strong>réelles</strong></td>
                        <td class="px-5 py-3 text-dark-500">Accueil, À propos</td>
                    </tr>
                    <tr style="border-top: 0.5px solid var(--color-dark-200);">
                        <td class="px-5 py-3 font-medium">Barres de progression</td>
                        <td class="px-5 py-3 text-dark-500">Composant <code class="text-[12px]">&lt;x-front.shared.gauge-progress&gt;</code> (intégration dev)</td>
                        <td class="px-5 py-3 text-dark-500">Audit, pages dossier</td>
                    </tr>
                    <tr style="border-top: 0.5px solid var(--color-dark-200);">
                        <td class="px-5 py-3 font-medium">Photos hero / ambiance</td>
                        <td class="px-5 py-3 text-dark-500">Générer via les prompts puis remplacer les <code class="text-[12px]">/images/hero-*.webp</code></td>
                        <td class="px-5 py-3 text-dark-500">Voir <code class="text-[12px]">docs/refs-design/prompts-visuels.md</code></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
