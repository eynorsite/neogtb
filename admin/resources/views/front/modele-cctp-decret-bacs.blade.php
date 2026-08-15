@extends('front.layouts.app')

{{-- Fil d'Ariane --}}
@section('breadcrumbs')
    <li><a href="/" class="hover:text-accent-600 transition-colors">Accueil</a></li>
    <li aria-hidden="true" class="text-dark-300">/</li>
    <li><a href="/decret-bacs" class="hover:text-accent-600 transition-colors">Décret BACS</a></li>
    <li aria-hidden="true" class="text-dark-300">/</li>
    <li aria-current="page" class="text-dark-600">Modèle de CCTP</li>
@endsection

{{-- JSON-LD FAQPage — canal schema.org contextuel (app.blade.php:99). Exempté CSP. --}}
@push('schema')
<script type="application/ld+json" @cspNonce>
@verbatim
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {"@type":"Question","name":"Qu'est-ce qu'un CCTP décret BACS ?","acceptedAnswer":{"@type":"Answer","text":"Le CCTP (Cahier des Clauses Techniques Particulières) est la pièce d'un marché qui décrit les exigences techniques attendues. Un CCTP lié au décret BACS précise les fonctions, l'architecture et les performances que doit atteindre la GTB pour répondre aux obligations du décret (fonctions de l'article R. 175-3 du Code de la construction), généralement via une GTB de classe B au sens de la norme NF EN ISO 52120-1."}},
        {"@type":"Question","name":"Le décret BACS impose-t-il la classe B ?","acceptedAnswer":{"@type":"Answer","text":"Pas littéralement. Le décret BACS impose des fonctions d'automatisation et de contrôle (article R. 175-3 du CCH), pas une classe en tant que telle. La classe B de la NF EN ISO 52120-1 est le niveau qui permet en pratique de remplir ces fonctions ; c'est aussi le niveau financé par la fiche CEE BAT-TH-116. Ce modèle vise donc la classe B."}},
        {"@type":"Question","name":"Ce modèle de CCTP est-il directement conforme au décret BACS ?","acceptedAnswer":{"@type":"Answer","text":"C'est une trame neutre, sans lien fabricant. Elle doit être adaptée à chaque bâtiment (périmètre, puissances, existant, lots) et ses références réglementaires reconfirmées sur Légifrance/AFNOR à la date de diffusion. Elle ne se substitue pas à un avis technique ou juridique."}}
    ]
}
@endverbatim
</script>
@endpush

@section('content')

{{-- =========================================================================
     HERO — LIGHT MODE (aligné decret-bacs.blade.php)
     ========================================================================= --}}
<section class="relative overflow-hidden bg-white border-b border-dark-100">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 select-none">
        <span class="glow-halo glow-halo--accent w-[420px] h-[420px] -top-24 -right-24"></span>
        <span class="glow-halo glow-halo--primary w-[360px] h-[360px] top-1/2 -left-32"></span>
        <span class="orb orb--filled orb--slow glow-halo--accent w-24 h-24 top-16 left-[12%]"></span>
        <span class="orb orb--outline orb--reverse orb--delay w-16 h-16 bottom-20 right-[18%]"></span>
        <span class="orb orb--filled orb--delay glow-halo--warm w-12 h-12 top-1/3 right-[8%]"></span>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-5 lg:px-10 py-16 lg:py-28">
        <div class="max-w-3xl">
            <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-accent-700 bg-accent-50 border border-accent-200 px-3 py-1 rounded-full mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-accent-500"></span>
                Ressource gratuite
            </p>
            <h1 class="text-[32px] lg:text-[52px] font-semibold text-dark-900 tracking-tight leading-[1.1] mb-6">
                Modèle type de CCTP décret BACS
            </h1>
            <p class="text-lg lg:text-xl text-dark-500 leading-relaxed mb-8">
                Une trame de cahier des charges technique pour votre consultation GTB : neutre fabricant,
                multi-protocoles, calée sur la <strong class="text-dark-700 font-medium">classe B</strong> de
                la norme NF EN ISO 52120-1 — le niveau qui répond aux fonctions exigées par le décret BACS.
                À lire, copier et adapter à votre bâtiment.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="#telecharger" class="btn-primary">
                    Télécharger le modèle (Word)
                    <x-front.shared.icon name="document" class="w-4 h-4" />
                </a>
                <button type="button" x-data @click="window.print()" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-700 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                    Imprimer / enregistrer en PDF
                </button>
            </div>
            <p class="text-[13px] text-dark-500 mt-4">Document Word (.docx) modifiable : CCTP complet + grille de dépouillement. Lecture libre ci-dessous, version éditable gratuite par email.</p>
            @include('front.partials.reassurance-badges', ['class' => 'mt-8 justify-start'])
        </div>
    </div>
</section>

{{-- =========================================================================
     MODE D'EMPLOI + AVERTISSEMENT
     ========================================================================= --}}
<section class="py-12 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-12">
            <div class="lg:col-span-3">
                <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Comment l'utiliser</p>
                <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-4">Une trame à adapter, pas un copier-coller</h2>
                <p class="text-base text-dark-500 leading-relaxed mb-4">
                    Le CCTP (Cahier des Clauses Techniques Particulières) est la pièce d'un marché qui décrit
                    précisément ce que doit faire la GTB. Ce modèle reprend la structure et les exigences que l'on
                    retrouve dans les vraies consultations liées au décret BACS.
                </p>
                <p class="text-base text-dark-500 leading-relaxed mb-6">
                    Les passages signalés <mark class="bg-orange-50 text-orange-900 px-1.5 py-0.5 rounded font-medium border border-orange-200">[À compléter]</mark>
                    doivent être renseignés selon votre bâtiment. Les références réglementaires sont à reconfirmer
                    sur Légifrance / AFNOR à la date de diffusion (la réglementation évolue).
                </p>
                <ul class="text-[15px] text-dark-500 leading-relaxed space-y-2.5">
                    <li class="flex gap-3"><x-front.shared.icon name="conformite" class="w-5 h-5 text-accent-600 flex-shrink-0 mt-0.5" /><span><strong class="text-dark-900 font-medium">Neutre fabricant</strong> : exigences fonctionnelles et clauses anti-verrouillage, jamais une marque imposée.</span></li>
                    <li class="flex gap-3"><x-front.shared.icon name="reseau" class="w-5 h-5 text-accent-600 flex-shrink-0 mt-0.5" /><span><strong class="text-dark-900 font-medium">Multi-protocoles ouverts</strong> : BACnet, KNX, Modbus, DALI, M-Bus, LON.</span></li>
                    <li class="flex gap-3"><x-front.shared.icon name="energie" class="w-5 h-5 text-accent-600 flex-shrink-0 mt-0.5" /><span><strong class="text-dark-900 font-medium">Classe B visée</strong> : le niveau qui répond aux fonctions du décret BACS, financé par les CEE.</span></li>
                </ul>
            </div>

            <aside class="lg:col-span-2">
                <div class="bg-orange-50 border border-orange-200 rounded-2xl p-5 lg:p-7">
                    <p class="text-xs font-semibold uppercase tracking-widest text-orange-800 mb-2">À savoir</p>
                    <p class="text-[15px] text-dark-700 leading-relaxed mb-3">
                        Ce modèle est fourni à titre indicatif. Il ne constitue ni un avis juridique, ni une
                        garantie de conformité : chaque projet doit être vérifié au regard de son contexte
                        technique et réglementaire réel.
                    </p>
                    <p class="text-[15px] text-dark-700 leading-relaxed">
                        Besoin d'une version calée sur votre bâtiment ? Notre
                        <a href="/amo-gtb-gtc" class="text-accent-700 font-medium hover:text-accent-800 underline underline-offset-2">AMO GTB/GTC</a>
                        rédige le CCTP avec vous, sans lien fabricant ni commission.
                    </p>
                </div>
            </aside>
        </div>
    </div>
</section>

{{-- =========================================================================
     SOMMAIRE DU CCTP (ancres)
     ========================================================================= --}}
<section class="py-12 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Sommaire</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Les 13 articles du CCTP</h2>
            <p class="text-base text-dark-500 leading-relaxed">La structure type d'un cahier des charges GTB ouvert, lié au décret BACS.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-4">
            @foreach([
                ['n' => '01', 'id' => 'art-1', 'titre' => 'Objet et périmètre'],
                ['n' => '02', 'id' => 'art-2', 'titre' => 'Cadre réglementaire et normatif'],
                ['n' => '03', 'id' => 'art-3', 'titre' => "Description de l'existant"],
                ['n' => '04', 'id' => 'art-4', 'titre' => 'Exigences fonctionnelles (classe B)'],
                ['n' => '05', 'id' => 'art-5', 'titre' => 'Architecture du système GTB'],
                ['n' => '06', 'id' => 'art-6', 'titre' => 'Protocoles et preuves de conformité'],
                ['n' => '07', 'id' => 'art-7', 'titre' => 'Réversibilité et anti-verrouillage'],
                ['n' => '08', 'id' => 'art-8', 'titre' => "Comptage et mesurage de l'énergie"],
                ['n' => '09', 'id' => 'art-9', 'titre' => 'Cybersécurité (recommandations ANSSI)'],
                ['n' => '10', 'id' => 'art-10', 'titre' => 'Protection des données (RGPD)'],
                ['n' => '11', 'id' => 'art-11', 'titre' => 'Mise en service et réception'],
                ['n' => '12', 'id' => 'art-12', 'titre' => 'Maintenance, garanties et formation'],
                ['n' => '13', 'id' => 'art-13', 'titre' => 'Livrables et jugement des offres'],
            ] as $item)
            <a href="#{{ $item['id'] }}" class="flex items-center gap-3 bg-white rounded-xl px-4 py-3.5 border border-dark-100 hover:border-accent-200 hover:shadow-sm transition-all">
                <span class="text-[13px] font-medium text-accent-600 tabular-nums">{{ $item['n'] }}</span>
                <span class="text-[14px] text-dark-700 leading-snug">{{ $item['titre'] }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================================
     LE MODÈLE DE CCTP — articles
     ========================================================================= --}}
<section class="py-12 lg:py-24">
    <div class="max-w-3xl mx-auto px-5 lg:px-0">

        {{-- ART. 1 --}}
        <article id="art-1" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 1</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Objet et périmètre</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-3">
                Le présent CCTP définit les exigences relatives à la fourniture, l'installation, le paramétrage,
                la mise en service, la documentation et la garantie d'un système de gestion technique du bâtiment
                (GTB/GTC) <strong class="text-dark-900 font-medium">ouvert et interopérable</strong> pour
                <mark class="bg-orange-50 text-orange-900 px-1.5 py-0.5 rounded font-medium border border-orange-200">[à compléter : opération, bâtiment, maître d'ouvrage]</mark>.
            </p>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-3">Le marché couvre les lots : CVC, éclairage (bus DALI), comptage / sous-comptage de l'énergie, et supervision GTB. Le système respecte les principes de neutralité technologique et d'absence de verrouillage propriétaire (article 7).</p>
            <p class="text-[15px] text-dark-600 leading-relaxed">
                Le système vise <strong class="text-dark-900 font-medium">a minima la classe B</strong> de la
                norme NF EN ISO 52120-1, justifiée fonction par fonction (voir article 4). Le titulaire a une
                obligation de résultat sur l'atteinte de cette classe, qu'il démontre à la réception.
            </p>
        </article>

        {{-- ART. 2 --}}
        <article id="art-2" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 2</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Cadre réglementaire et normatif</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-4">Le système est conforme aux textes et normes en vigueur à la date de remise des offres (éditions à vérifier) :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc mb-4">
                <li>Décret n° 2020-887 du 20 juillet 2020 (« décret BACS »), modifié par le décret n° 2023-259 du 7 avril 2023 (seuil abaissé à 70 kW) ;</li>
                <li>Décret n° 2025-1343 du 26 décembre 2025 (report de la tranche 70–290 kW au 1ᵉʳ janvier 2030) ;</li>
                <li>Articles R. 175-1 et suivants du Code de la construction et de l'habitation, notamment l'article R. 175-3 (fonctions exigées) ; arrêté du 7 avril 2023 (inspection périodique) ;</li>
                <li>Norme NF EN ISO 52120-1:2022 (remplace l'EN 15232-1) — classes d'efficacité A / B / C / D ;</li>
                <li>Protocoles : NF EN ISO 16484-5 (BACnet), ISO/IEC 14543-3 et EN 50090 (KNX), IEC 62386 (DALI), EN 13757 (M-Bus), ISO/IEC 14908 (LON) ;</li>
                <li>Pour un marché public : Code de la commande publique (spécifications en performances, mention « ou équivalent », art. R. 2111-7 à R. 2111-11).</li>
            </ul>
            <div class="bg-accent-50 border border-accent-200 rounded-xl p-4">
                <p class="text-[14px] text-dark-700 leading-relaxed"><strong class="text-accent-800">Sur la classe B — précision importante.</strong> Le décret BACS impose des <strong>fonctions</strong> (art. R. 175-3 du CCH), pas une classe en tant que telle. La classe B de la NF EN ISO 52120-1 est le niveau qui permet en pratique de remplir ces fonctions, et c'est le niveau financé par la fiche CEE BAT-TH-116. La classe globale correspond à la <strong>classe la plus faible</strong> atteinte parmi les fonctions installées : viser « classe B » impose donc que toutes les fonctions applicables atteignent au moins B.</p>
            </div>
        </article>

        {{-- ART. 3 --}}
        <article id="art-3" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 3</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Description de l'existant</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-3">
                <mark class="bg-orange-50 text-orange-900 px-1.5 py-0.5 rounded font-medium border border-orange-200">[à compléter]</mark>
                Décrire le bâtiment et son patrimoine technique : surface, usage, niveaux, plages d'occupation.
            </p>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-3">Préciser la puissance nominale utile cumulée des systèmes CVC (chauffage + climatisation), qui détermine l'assujettissement au décret BACS, ainsi que les lots concernés :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc mb-3">
                <li>Production et distribution de chaleur (chaudières, PAC, sous-stations) ;</li>
                <li>Production et distribution de froid (groupes froid, PAC réversibles) ;</li>
                <li>Ventilation et traitement d'air (CTA, VMC, récupération, free-cooling) ;</li>
                <li>Eau chaude sanitaire (ECS) ;</li>
                <li>Éclairage des zones concernées (bus DALI) ;</li>
                <li>Comptage et sous-comptage de l'énergie.</li>
            </ul>
            <p class="text-[15px] text-dark-600 leading-relaxed">Décrire la régulation existante, les automates et protocoles en place, et préciser s'il s'agit d'une création, d'une extension ou d'une reprise d'installation.</p>
        </article>

        {{-- ART. 4 --}}
        <article id="art-4" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 4</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Exigences fonctionnelles (classe B)</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-5">La GTB devra assurer les fonctions de l'article R. 175-3 du CCH, déclinées en fonctions de classe B au sens de la norme NF EN ISO 52120-1 :</p>

            <div class="space-y-4 mb-6">
                <div class="bg-white rounded-xl p-5 border border-dark-100">
                    <h3 class="text-[15px] font-medium text-dark-900 mb-2">A. Suivre, enregistrer, analyser et ajuster en continu</h3>
                    <p class="text-[14px] text-dark-500 leading-relaxed">Mesure et historisation continue des consommations par usage et par zone, à un pas de temps au moins horaire ; conservation des données mensuelles pendant 5 ans ; ajustement automatique des consignes selon l'occupation et les conditions extérieures.</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-dark-100">
                    <h3 class="text-[15px] font-medium text-dark-900 mb-2">B. Détecter les dérives et informer de l'efficacité énergétique</h3>
                    <p class="text-[14px] text-dark-500 leading-relaxed">Comparaison à des valeurs de référence (benchmarking), détection automatique des défauts et pertes d'efficacité (FDD), alarmes hiérarchisées et horodatées, information de l'exploitant sur les améliorations possibles.</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-dark-100">
                    <h3 class="text-[15px] font-medium text-dark-900 mb-2">C. GTB interopérable, arrêt manuel et accès aux données</h3>
                    <p class="text-[14px] text-dark-500 leading-relaxed">Interopérabilité via protocoles ouverts (article 6), possibilité d'arrêt manuel et de gestion autonome des systèmes, et mise à disposition des données au propriétaire — qui en est propriétaire (article 7).</p>
                </div>
            </div>

            <p class="text-[15px] text-dark-600 leading-relaxed mb-3">Fonctions d'automatisation attendues (classe B), par lot :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li><strong class="text-dark-900 font-medium">CVC</strong> : régulation des productions chaud/froid, loi d'eau, pompes à débit variable, optimisation départ/arrêt, pilotage des CTA (débits, registres, récupération, free-cooling, CO₂), régulation terminale par zone avec réduit en inoccupation ;</li>
                <li><strong class="text-dark-900 font-medium">Éclairage (DALI)</strong> : adressage individuel des luminaires, gradation, détection de présence et de luminosité (gradation selon l'apport de lumière du jour), scènes, remontée des défauts ;</li>
                <li><strong class="text-dark-900 font-medium">Comptage</strong> : comptage général et sous-comptage par usage et par zone, historisation et agrégation pour le suivi réglementaire ;</li>
                <li><strong class="text-dark-900 font-medium">Supervision</strong> : synoptiques, courbes de tendance, tableaux de bord énergétiques, gestion des droits, export aux formats ouverts.</li>
            </ul>
        </article>

        {{-- ART. 5 --}}
        <article id="art-5" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 5</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Architecture du système GTB</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-4">Le système est organisé en trois niveaux, de sorte qu'un changement de superviseur n'impose pas le remplacement des équipements de terrain, et inversement :</p>
            <ol class="text-[15px] text-dark-600 leading-relaxed space-y-3 pl-5 list-decimal mb-4">
                <li><strong class="text-dark-900 font-medium">Niveau terrain</strong> : capteurs, actionneurs, luminaires, compteurs, contrôleurs terminaux (KNX, DALI, M-Bus, Modbus RTU).</li>
                <li><strong class="text-dark-900 font-medium">Niveau automation</strong> : automates / régulateurs (DDC) des procédés primaires (BACnet, LON existant). La régulation reste autonome en cas de perte de la supervision.</li>
                <li><strong class="text-dark-900 font-medium">Niveau gestion</strong> : superviseur, serveur, IHM, historisation, alarmes, tableaux de bord (BACnet/IP ou BACnet/SC, OPC UA, Modbus TCP).</li>
            </ol>
            <p class="text-[15px] text-dark-600 leading-relaxed">Le backbone d'intégration est un protocole ouvert de niveau supervision (BACnet/IP par défaut) ; les bus de terrain spécialisés remontent via des passerelles documentées (article 6).</p>
        </article>

        {{-- ART. 6 --}}
        <article id="art-6" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 6</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Protocoles et preuves de conformité</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-4">Le système repose exclusivement sur des protocoles ouverts et normalisés ; tout protocole propriétaire fermé est proscrit pour la couche d'interopérabilité. Le candidat précise, pour chaque équipement, le ou les protocoles supportés et fournit les <strong class="text-dark-900 font-medium">preuves de conformité</strong> suivantes :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2.5 pl-5 list-disc mb-4">
                <li><strong class="text-dark-900 font-medium">BACnet</strong> (ISO 16484-5, IP et MS/TP) : équipements <em>BTL Listed</em>, profils par rôle (annexe L), liste de BIBBs par domaine, et fourniture du <em>PICS</em> de chaque équipement ;</li>
                <li><strong class="text-dark-900 font-medium">KNX</strong> (ISO/IEC 14543-3, EN 50090) : produits « certifiés KNX », Datapoint Types normalisés, projet ETS remis au maître d'ouvrage ;</li>
                <li><strong class="text-dark-900 font-medium">Modbus</strong> : Modbus ne définit aucun modèle d'objet normalisé — la <strong>table de cartographie complète des registres</strong> (adresse, type, échelle, unité, accès) est un livrable obligatoire ;</li>
                <li><strong class="text-dark-900 font-medium">DALI</strong> (IEC 62386) : composants certifiés DALI-2 / D4i, présents dans la base de la DALI Alliance ;</li>
                <li><strong class="text-dark-900 font-medium">M-Bus</strong> (EN 13757) : certification OMS privilégiée, télégrammes / registres documentés (DIF/VIF ou OBIS) ;</li>
                <li><strong class="text-dark-900 font-medium">LON</strong> (ISO/IEC 14908) : compatibilité avec l'existant via passerelle, non prioritaire en prescription neuve.</li>
            </ul>
            <p class="text-[15px] text-dark-600 leading-relaxed">Toute passerelle est documentée (mapping complet des points traduits, format réutilisable par un tiers).</p>
        </article>

        {{-- ART. 7 --}}
        <article id="art-7" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 7</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Réversibilité et anti-verrouillage</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-4">Clauses contractuelles destinées à éviter toute dépendance au titulaire (<em>vendor lock-in</em>). Elles sont opposables dès lors qu'elles figurent au marché :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2.5 pl-5 list-disc">
                <li><strong class="text-dark-900 font-medium">Propriété des données et configurations</strong> : le maître d'ouvrage est propriétaire de l'intégralité des données, paramétrages et programmations réalisés au titre du marché ;</li>
                <li><strong class="text-dark-900 font-medium">Dossier de réversibilité</strong> remis à la réception : codes sources éditables et recompilables, fichiers de configuration, table exhaustive des points, plan d'adressage, schémas et synoptiques ;</li>
                <li><strong class="text-dark-900 font-medium">Licences</strong> pérennes, transférables au maître d'ouvrage, sans coût récurrent caché ni limite de points abusive ;</li>
                <li><strong class="text-dark-900 font-medium">Mots de passe et comptes administrateur</strong> de plus haut niveau remis, permettant la modification complète du système ;</li>
                <li><strong class="text-dark-900 font-medium">Maintenabilité par un tiers</strong> : aucune restriction technique, contractuelle ou de propriété intellectuelle à la reprise par un tiers qualifié ;</li>
                <li><strong class="text-dark-900 font-medium">Accès ouvert aux données</strong> : API documentée et export aux formats ouverts (CSV, JSON), sans dépendance à un service propriétaire.</li>
            </ul>
        </article>

        {{-- ART. 8 --}}
        <article id="art-8" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 8</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Comptage et mesurage de l'énergie</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-4">Le système assure le comptage et le sous-comptage des consommations pour permettre le suivi par usage :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li>Comptage par énergie (électricité, gaz, réseau de chaleur/froid, eau) ;</li>
                <li>Sous-comptage par usage significatif (chauffage, froid, ventilation, ECS, éclairage) et par zone / locataire si applicable ;</li>
                <li>Remontée des index, puissances et grandeurs, horodatage et historisation des courbes de charge ;</li>
                <li>Le cas échéant (décret tertiaire), structuration permettant l'export vers la plateforme OPERAT.</li>
            </ul>
        </article>

        {{-- ART. 9 --}}
        <article id="art-9" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 9</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Cybersécurité (recommandations ANSSI)</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-4">L'installation s'appuie sur les bonnes pratiques de sécurité applicables aux systèmes industriels et à la GTB :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li>Segmentation du réseau GTB (OT) et cloisonnement vis-à-vis du réseau bureautique (IT) ;</li>
                <li>Comptes nominatifs, gestion des droits par profils (consultation, modification, acquittement, administration) ;</li>
                <li>Authentification forte et chiffrement des accès distants — privilégier BACnet/SC sur le backbone IP ;</li>
                <li>Politique de mises à jour de sécurité, sauvegarde des configurations, journalisation des accès et actions.</li>
            </ul>
        </article>

        {{-- ART. 10 --}}
        <article id="art-10" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 10</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Protection des données (RGPD)</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed">
                Si le système traite des données à caractère personnel (par exemple via la détection de présence ou
                des comptages individualisés), le titulaire respecte le RGPD : minimisation, finalité limitée à la
                gestion technique et énergétique, durée de conservation maîtrisée et information des personnes
                concernées. Aucune donnée n'est exploitée à des fins étrangères à l'exploitation du bâtiment.
            </p>
        </article>

        {{-- ART. 11 --}}
        <article id="art-11" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 11</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Mise en service et réception</h2>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li>Programme de mise en service détaillant les essais fonctionnels par lot et par zone ;</li>
                <li>Commissioning fonctionnel : vérification réelle des séquences de régulation et d'optimisation ;</li>
                <li><strong class="text-dark-900 font-medium">Justification de la classe NF EN ISO 52120-1</strong> atteinte, fonction par fonction ;</li>
                <li><strong class="text-dark-900 font-medium">Vérification de l'ouverture comme condition de réception</strong> : remise des sources, licences, mots de passe admin, tables de points et mappings, disponibilité de l'API ;</li>
                <li>Levée des réserves avant prononcé de la réception.</li>
            </ul>
        </article>

        {{-- ART. 12 --}}
        <article id="art-12" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 12</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Maintenance, garanties et formation</h2>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li>Garantie de parfait achèvement et garantie des matériels ;</li>
                <li>Contrat de maintenance préventive et curative (à préciser : durée, GTI/GTR) — la télémaintenance ne prive jamais le maître d'ouvrage de la maîtrise de son système ;</li>
                <li>Formation des exploitants à la supervision et à la reconfiguration de premier niveau, supports remis ;</li>
                <li>Conditions de maintenance ouvertes à un tiers (article 7).</li>
            </ul>
        </article>

        {{-- ART. 13 --}}
        <article id="art-13" class="scroll-mt-28">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 13</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Livrables et jugement des offres</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-3">Livrables attendus : note d'architecture, tableau de conformité renseigné, listes de points et plans d'adressage, certificats (PICS BACnet, KNX, DALI-2, OMS), tables Modbus / M-Bus documentées, justification de la classe 52120-1, dossier des ouvrages exécutés (DOE) et dossier de réversibilité.</p>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-3"><mark class="bg-orange-50 text-orange-900 px-1.5 py-0.5 rounded font-medium border border-orange-200">[à compléter]</mark> Critères de jugement suggérés (chacun adossé à une preuve vérifiable) :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li>Conformité fonctionnelle (tableau point par point) ;</li>
                <li>Ouverture / interopérabilité (certifications vérifiées, réversibilité) ;</li>
                <li>Classe d'efficacité NF EN ISO 52120-1 justifiée fonction par fonction ;</li>
                <li>Maintenabilité / anti-verrouillage ;</li>
                <li>Coût global de possession (TCO) sur la durée de référence ;</li>
                <li>Délais, garanties, SAV et formation.</li>
            </ul>
            <p class="text-[13px] text-dark-500 leading-relaxed mt-4">Le modèle Word téléchargeable inclut une <strong class="text-dark-700 font-medium">grille de dépouillement</strong> détaillée (barèmes et méthode de notation) ainsi que les annexes (tableau de conformité, liste de points, cadre TCO).</p>
        </article>

    </div>
</section>

{{-- =========================================================================
     TÉLÉCHARGER — formulaire gaté (lead magnet) → PageController@downloadCctpModele
     ========================================================================= --}}
<section id="telecharger" class="scroll-mt-24 py-12 lg:py-24 bg-dark-50 border-t border-dark-200">
    <div class="max-w-2xl mx-auto px-5 lg:px-0">
        <div class="bg-white rounded-2xl border border-dark-100 lg:shadow-sm p-6 lg:p-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-3">Téléchargement gratuit</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Recevez le modèle au format Word</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-6">Indiquez votre email pour télécharger la version <strong class="text-dark-700 font-medium">.docx modifiable</strong> : le CCTP complet (13 articles) et sa grille de dépouillement, prêts à adapter à votre bâtiment.</p>

            @if ($errors->any())
            <div class="mb-5 p-4 rounded-lg bg-orange-50 border border-orange-200" role="alert">
                <ul class="text-[14px] text-orange-900 space-y-1 pl-5 list-disc">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('front.cctp.download') }}" class="space-y-4">
                @csrf
                {{-- Honeypot anti-bot : champ leurre invisible, rejeté côté serveur
                     par SubmitCctpLeadRequest (règle `prohibited`). --}}
                <input type="text" name="_gotcha" style="display:none!important;position:absolute;left:-9999px" tabindex="-1" autocomplete="off" aria-hidden="true" />
                <div>
                    <label for="cctp-email" class="block text-[13px] font-medium text-dark-700 mb-1.5">Email professionnel <span class="text-accent-600">*</span></label>
                    <input type="email" id="cctp-email" name="email" required value="{{ old('email') }}" autocomplete="email" placeholder="prenom@organisation.fr"
                        class="w-full px-4 py-3 text-[15px] bg-white border border-dark-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500" />
                </div>
                <div>
                    <label for="cctp-company" class="block text-[13px] font-medium text-dark-700 mb-1.5">Organisation <span class="text-dark-400 font-normal">(facultatif)</span></label>
                    <input type="text" id="cctp-company" name="company" value="{{ old('company') }}" autocomplete="organization" maxlength="100" placeholder="Nom de votre structure"
                        class="w-full px-4 py-3 text-[15px] bg-white border border-dark-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500" />
                </div>
                <label class="flex items-start gap-3 text-[13px] text-dark-600 leading-relaxed">
                    <input type="checkbox" name="consentement_rgpd" value="1" required class="mt-0.5 w-4 h-4 rounded border-dark-300 text-accent-600 focus:ring-accent-500" />
                    <span>J'accepte que mon email soit utilisé par NeoGTB pour me recontacter au sujet de ma demande. Aucune revente de données. <a href="/politique-de-confidentialite" class="text-accent-600 font-medium hover:text-accent-700 underline underline-offset-2">Politique de confidentialité</a>.</span>
                </label>
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    Télécharger le modèle (Word)
                    <x-front.shared.icon name="document" class="w-4 h-4" />
                </button>
            </form>

            <p class="text-[12px] text-dark-400 mt-5">Document Word (.docx), ~55 Ko. Vous pouvez aussi lire le modèle complet ci-dessus ou l'imprimer en PDF.</p>
        </div>
    </div>
</section>

{{-- =========================================================================
     FAQ — miroir visible du JSON-LD FAQPage (exigence Google : contenu visible)
     ========================================================================= --}}
<section class="py-12 lg:py-24 bg-white border-t border-dark-100">
    <div class="max-w-3xl mx-auto px-5 lg:px-0">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Questions fréquentes</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight">CCTP décret BACS : vos questions</h2>
        </div>

        <div class="space-y-4">
            @foreach([
                [
                    'q' => "Qu'est-ce qu'un CCTP décret BACS ?",
                    'a' => "Le CCTP (Cahier des Clauses Techniques Particulières) est la pièce d'un marché qui décrit les exigences techniques attendues. Un CCTP lié au décret BACS précise les fonctions, l'architecture et les performances que doit atteindre la GTB pour répondre aux obligations du décret (fonctions de l'article R. 175-3 du Code de la construction), généralement via une GTB de classe B au sens de la norme NF EN ISO 52120-1.",
                ],
                [
                    'q' => "Le décret BACS impose-t-il la classe B ?",
                    'a' => "Pas littéralement. Le décret BACS impose des fonctions d'automatisation et de contrôle (article R. 175-3 du CCH), pas une classe en tant que telle. La classe B de la NF EN ISO 52120-1 est le niveau qui permet en pratique de remplir ces fonctions ; c'est aussi le niveau financé par la fiche CEE BAT-TH-116. Ce modèle vise donc la classe B.",
                ],
                [
                    'q' => "Ce modèle de CCTP est-il directement conforme au décret BACS ?",
                    'a' => "C'est une trame neutre, sans lien fabricant. Elle doit être adaptée à chaque bâtiment (périmètre, puissances, existant, lots) et ses références réglementaires reconfirmées sur Légifrance / AFNOR à la date de diffusion. Elle ne se substitue pas à un avis technique ou juridique.",
                ],
            ] as $faq)
            <details class="group bg-white rounded-2xl border border-dark-100 lg:shadow-sm overflow-hidden">
                <summary class="flex items-center justify-between gap-4 p-5 lg:p-7 cursor-pointer list-none">
                    <h3 class="text-[15px] lg:text-base font-medium text-dark-900">{{ $faq['q'] }}</h3>
                    <svg class="w-5 h-5 text-dark-400 flex-shrink-0 transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </summary>
                <div class="px-5 lg:px-7 pb-5 lg:pb-7 -mt-1">
                    <p class="text-[15px] text-dark-500 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </details>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================================
     SOURCES (transparence — vrais CCTP de référence)
     ========================================================================= --}}
<section class="py-12 lg:py-20 bg-white border-t border-dark-100">
    <div class="max-w-3xl mx-auto px-5 lg:px-0">
        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Sources</p>
        <h2 class="text-[20px] lg:text-[24px] font-medium text-dark-900 tracking-tight mb-4">D'où vient cette trame</h2>
        <p class="text-[15px] text-dark-500 leading-relaxed mb-4">
            Ce modèle consolide la lecture de vrais CCTP de consultations publiques liées au décret BACS, le texte
            du décret et la norme NF EN ISO 52120-1, sous une forme neutre et réutilisable. Les références
            réglementaires sont reprises de notre page <a href="/decret-bacs" class="text-accent-600 font-medium hover:text-accent-700">Décret BACS</a>
            et restent à reconfirmer sur les sources primaires (Légifrance, AFNOR) à la date de diffusion.
        </p>
        <p class="text-[13px] text-dark-500 leading-relaxed">
            Exemples de CCTP réels traitant du décret BACS : marché de la Fédération Française de Judo (2025),
            marchés de la Métropole Aix-Marseille-Provence et de la Ville de Marseille (2025). Ces documents
            servent de référence de structure ; ils ne sont pas reproduits ici.
        </p>
    </div>
</section>

{{-- =========================================================================
     CTA FINAL
     ========================================================================= --}}
<section class="relative overflow-hidden py-14 lg:py-24 bg-white border-t border-dark-100">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 select-none">
        <span class="glow-halo glow-halo--accent w-[360px] h-[360px] -bottom-24 -right-16"></span>
        <span class="orb orb--outline orb--slow w-20 h-20 top-10 left-[10%]"></span>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-2xl">
            <h2 class="text-[24px] lg:text-[32px] font-semibold text-dark-900 tracking-tight leading-tight mb-3">Besoin d'un CCTP calé sur votre bâtiment ?</h2>
            <p class="text-base lg:text-lg text-dark-500 leading-relaxed mb-8">Notre AMO GTB/GTC rédige et adapte votre cahier des charges, pilote la consultation et vous accompagne jusqu'à la réception. Conseil indépendant, sans lien fabricant ni commission.</p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="/amo-gtb-gtc" class="btn-primary">
                    Découvrir l'AMO GTB/GTC
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="/contact" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-700 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                    Parler à un expert
                </a>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================================
     PAGES LIÉES
     ========================================================================= --}}
<section class="py-12 lg:py-24 bg-white border-t border-dark-100">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
            @foreach([
                ['href' => '/decret-bacs', 'title' => 'Tout sur le décret BACS', 'desc' => 'Qui est concerné, échéances, classes et mise en conformité.'],
                ['href' => '/amo-gtb-gtc', 'title' => 'AMO GTB/GTC', 'desc' => 'Du cahier des charges à la réception, en passant par l\'appel d\'offres.'],
                ['href' => '/audit', 'title' => 'Pré-diagnostic GTB gratuit', 'desc' => 'Situez votre classe NF EN ISO 52120-1 en quelques minutes.'],
            ] as $link)
            <a href="{{ $link['href'] }}" class="block bg-dark-50 rounded-2xl p-5 lg:p-7 border border-dark-100 card-hover-glow">
                <h3 class="text-[15px] font-medium text-dark-900 mb-1">{{ $link['title'] }}</h3>
                <p class="text-sm text-dark-500">{{ $link['desc'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
