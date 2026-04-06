@extends('front.layouts.app')

@section('title', 'Reglementation GTB — Decret BACS, Tertiaire, RE2020')
@section('description', 'Reglementation GTB en France : decret BACS 2027/2030, decret tertiaire, RE2020, directive EPBD, norme EN ISO 52120-1 (ex-EN 15232). Calendrier et obligations.')

@section('content')

<!-- HERO IMAGE -->
<section class="relative min-h-[480px] flex items-center overflow-hidden">
    <img src="/images/hero-reglementation.webp" alt="Reglementation GTB — balance juridique, normes energetiques et batiment tertiaire" width="1200" height="630" loading="eager" fetchpriority="high" class="absolute inset-0 w-full h-full object-cover object-center" />
    <div class="absolute inset-0" style="background: linear-gradient(to right, rgba(0,0,0,0.78) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.1) 100%);"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10 w-full">
        <div class="max-w-[540px]">
            <p class="inline-flex items-center gap-2 text-[11px] font-medium text-white/85 bg-white/10 backdrop-blur-sm px-3.5 py-1.5 rounded-full border border-white/15 mb-6">Cadre juridique</p>
            <h1 class="font-heading text-4xl md:text-5xl font-medium text-white leading-tight tracking-tight mb-5">
                Reglementation <span class="text-green-400">GTB</span> en France
            </h1>
            <p class="text-[17px] text-white/70 leading-relaxed max-w-[480px]">
                Decret BACS, decret tertiaire, RE2020, directive EPBD, norme EN ISO 52120-1 : obligations, echeances et aides. Mis a jour mars 2026.
            </p>
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach(['Decret BACS', 'Decret tertiaire', 'RE2020', 'ISO 52120-1'] as $tag)
                <span class="text-xs font-medium px-3 py-1 rounded bg-white/10 text-white/80 border border-white/15">{{ $tag }}</span>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- ALERTE ACTUALITE -->
<section class="px-6 md:px-10">
    <div class="max-w-7xl mx-auto">
        <div class="bg-accent-50 border border-accent-200 rounded-xl p-5 -mt-8 relative z-10">
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 rounded-full bg-accent-500 mt-1.5 flex-shrink-0"></div>
                <div>
                    <p class="text-sm font-medium text-dark-900 mb-1">Mise a jour — Decret n 2025-1343 du 26 decembre 2025</p>
                    <p class="text-sm text-dark-600 leading-relaxed">L'obligation GTB/BACS pour les batiments tertiaires existants de <strong>70 a 290 kW</strong> est <strong>reportee au 1er janvier 2030</strong> (initialement 2027). L'echeance >290 kW reste en vigueur depuis le 1er janvier 2025.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CALENDRIER -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Vue d'ensemble</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Calendrier des obligations</h2>
            <p class="text-base text-dark-500 leading-relaxed">Toutes les echeances reglementaires liees a la GTB, actualisees apres le decret de decembre 2025.</p>
        </div>
        <div class="border border-dark-200 rounded-xl overflow-hidden">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-dark-50">
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Type</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Puissance CVC</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Echeance</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Statut mars 2026</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-dark-100">
                        <td class="p-3.5 font-medium text-dark-900">Existant</td>
                        <td class="p-3.5 text-dark-600">> 290 kW</td>
                        <td class="p-3.5 text-dark-600">1er janvier 2025</td>
                        <td class="p-3.5"><span class="text-xs font-medium text-accent-800 bg-accent-50 px-2.5 py-1 rounded-md">En vigueur</span></td>
                    </tr>
                    <tr class="border-b border-dark-100">
                        <td class="p-3.5 font-medium text-dark-900">Existant</td>
                        <td class="p-3.5 text-dark-600">70 a 290 kW</td>
                        <td class="p-3.5 text-dark-600">1er janvier 2030</td>
                        <td class="p-3.5"><span class="text-xs font-medium text-orange-800 bg-orange-50 px-2.5 py-1 rounded-md">Reporte (etait 2027)</span></td>
                    </tr>
                    <tr class="border-b border-dark-100">
                        <td class="p-3.5 font-medium text-dark-900">Neuf (permis > 21/07/2021)</td>
                        <td class="p-3.5 text-dark-600">> 290 kW</td>
                        <td class="p-3.5 text-dark-600">A la construction</td>
                        <td class="p-3.5"><span class="text-xs font-medium text-accent-800 bg-accent-50 px-2.5 py-1 rounded-md">Obligatoire</span></td>
                    </tr>
                    <tr>
                        <td class="p-3.5 font-medium text-dark-900">Neuf (permis > 08/04/2024)</td>
                        <td class="p-3.5 text-dark-600">> 70 kW</td>
                        <td class="p-3.5 text-dark-600">A la construction</td>
                        <td class="p-3.5"><span class="text-xs font-medium text-accent-800 bg-accent-50 px-2.5 py-1 rounded-md">Obligatoire</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- DECRET BACS -->
<section class="py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="grid lg:grid-cols-5 gap-12">
            <div class="lg:col-span-3">
                <span class="inline-block text-[13px] font-medium text-white bg-accent-600 px-3 py-1 rounded-md mb-4">Obligation principale</span>
                <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-4">Decret BACS</h2>
                <p class="text-sm text-dark-400 mb-5">Decret n 2020-887 du 20 juillet 2020 / Modifie par le decret n 2025-1343 du 26 decembre 2025</p>
                <p class="text-base text-dark-500 leading-relaxed mb-4">Le decret BACS transpose l'article 14 de la <strong class="text-dark-900 font-medium">directive europeenne EPBD 2018/844</strong> sur la performance energetique des batiments. Il impose l'installation de systemes d'automatisation et de controle dans les batiments tertiaires non residentiels.</p>
                <p class="text-base text-dark-500 leading-relaxed mb-4">Le systeme installe doit atteindre <strong class="text-dark-900 font-medium">a minima la classe B</strong> de la norme EN 15232 (NF EN ISO 52120-1). Il doit etre capable de :</p>
                <ul class="text-[15px] text-dark-500 leading-relaxed pl-5 list-disc mb-5 space-y-2">
                    <li>Suivre, enregistrer et analyser la consommation energetique par usage</li>
                    <li>Ajuster les regulations en fonction de l'occupation et des besoins</li>
                    <li>Detecter les defauts et les derives de performance</li>
                    <li>Communiquer avec les systemes techniques interconnectes</li>
                    <li>Permettre le pilotage manuel et automatique des installations CVC</li>
                </ul>
                <div class="bg-accent-50 border border-accent-200 rounded-xl p-6">
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Inspection obligatoire</p>
                    <p class="text-sm text-dark-600 leading-relaxed">Les systemes BACS doivent faire l'objet d'une <strong>inspection reguliere</strong> verifiant le bon fonctionnement du systeme d'automatisation et sa conformite a la classe de performance declaree.</p>
                </div>
            </div>
            <div class="lg:col-span-2 space-y-4">
                @foreach([
                    ['label' => 'Batiments concernes', 'text' => 'Tous les batiments tertiaires non residentiels : bureaux, commerces, enseignement, sante, hotellerie, logistique, sport.'],
                    ['label' => 'Seuil de puissance', 'text' => 'Puissance nominale utile cumulee des systemes CVC (chauffage + climatisation). Somme de tous les generateurs du batiment.'],
                ] as $card)
                <div class="bg-white rounded-xl p-6 border border-dark-200 shadow-sm">
                    <p class="text-[11px] font-medium uppercase tracking-widest text-dark-400 mb-2">{{ $card['label'] }}</p>
                    <p class="text-[15px] text-dark-600 leading-relaxed">{{ $card['text'] }}</p>
                </div>
                @endforeach
                <div class="bg-white rounded-xl p-6 border border-dark-200 shadow-sm">
                    <p class="text-[11px] font-medium uppercase tracking-widest text-dark-400 mb-2">Niveau requis</p>
                    <p class="text-[28px] font-medium text-accent-600 tracking-tight">Classe B</p>
                    <p class="text-[13px] text-dark-400 mt-1">minimum / norme ISO 52120-1</p>
                </div>
                <div class="bg-white rounded-xl p-6 border border-dark-200 shadow-sm">
                    <p class="text-[11px] font-medium uppercase tracking-widest text-dark-400 mb-2">Exemption</p>
                    <p class="text-[15px] text-dark-600 leading-relaxed">Possibilite de derogation si un audit energetique demontre un temps de retour sur investissement superieur a 6 ans.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DECRET TERTIAIRE -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="grid lg:grid-cols-2 gap-12">
            <div>
                <span class="inline-block text-[13px] font-medium text-white bg-dark-600 px-3 py-1 rounded-md mb-4">Objectifs de reduction</span>
                <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-4">Decret tertiaire — Eco Energie Tertiaire</h2>
                <p class="text-sm text-dark-400 mb-5">Decret n 2019-771 du 23 juillet 2019 / Issu de la loi ELAN</p>
                <p class="text-base text-dark-500 leading-relaxed mb-4">Le decret tertiaire impose aux batiments tertiaires de <strong class="text-dark-900 font-medium">plus de 1 000 m2</strong> une reduction progressive de leur consommation d'energie finale par rapport a une annee de reference (posterieure a 2010).</p>
                <p class="text-base text-dark-500 leading-relaxed mb-4">Les donnees doivent etre declarees annuellement sur la plateforme <strong class="text-dark-900 font-medium">OPERAT</strong> geree par l'ADEME. La GTB constitue le levier principal pour atteindre ces objectifs de reduction.</p>
                <div class="bg-accent-50 border border-accent-200 rounded-xl p-6 mt-6">
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Sanctions</p>
                    <p class="text-sm text-dark-600 leading-relaxed">En cas de non-respect : mise en demeure, publication du nom du contrevenant sur un site public ("name and shame"), et amende jusqu'a <strong>7 500 &euro; par batiment</strong> pour les personnes morales.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-5">
                @foreach([
                    ['-40 %', 'Objectif 2030', 'Declaration OPERAT avant le 30 sept. 2026'],
                    ['-50 %', 'Objectif 2040', null],
                    ['-60 %', 'Objectif 2050', null],
                ] as $i => $obj)
                <div class="bg-white rounded-xl p-7 text-center border border-dark-200 shadow-sm">
                    <p class="text-5xl font-medium {{ $i === 0 ? 'text-accent-600' : 'text-dark-700' }} tracking-tight leading-none">{{ $obj[0] }}</p>
                    <p class="text-sm text-dark-500 mt-2">{{ $obj[1] }}</p>
                    @if($obj[2])
                    <p class="text-xs text-dark-400 mt-1">{{ $obj[2] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- RE2020 + EPBD -->
<section class="py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Batiments neufs et Europe</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight">Autres reglementations cles</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach([
                ['badge' => 'Neuf / Depuis 2022', 'bg' => 'bg-dark-700', 'title' => 'RE2020', 'subtitle' => 'Reglementation Environnementale 2020', 'desc' => 'Applicable aux batiments neufs depuis le 1er janvier 2022. Renforce les exigences de performance par rapport a la RT2012 et introduit le calcul de l\'empreinte carbone sur le cycle de vie. Deux indicateurs rendent la GTB quasi indispensable en tertiaire :', 'extra' => '<div class="grid grid-cols-2 gap-4 mt-4"><div class="p-3.5 rounded-lg bg-dark-50 border border-dark-200"><p class="text-xl font-medium text-dark-900">Cep</p><p class="text-xs text-dark-400 mt-1">Consommation d\'energie primaire</p></div><div class="p-3.5 rounded-lg bg-dark-50 border border-dark-200"><p class="text-xl font-medium text-dark-900">DH</p><p class="text-xs text-dark-400 mt-1">Degres-heures d\'inconfort</p></div></div>'],
                ['badge' => 'Europe / Refonte 2024', 'bg' => 'bg-accent-700', 'title' => 'Directive EPBD', 'subtitle' => 'Energy Performance of Buildings Directive / 2018/844 → refonte 2024', 'desc' => 'La directive EPBD est le texte europeen fondateur qui impose la GTB. L\'article 14 est l\'origine du decret BACS francais. La <strong class="text-dark-900">refonte 2024</strong> renforce les exigences :', 'extra' => '<ul class="text-sm text-dark-500 leading-relaxed pl-5 list-disc mt-4 space-y-2"><li>Objectif batiments a emission zero d\'ici 2050</li><li>Passeport de renovation pour chaque batiment</li><li>Abaissement progressif des seuils BACS</li><li>Obligation de suivi energetique continu</li></ul>'],
                ['badge' => 'Loi / 2018', 'bg' => 'bg-dark-600', 'title' => 'Loi ELAN', 'subtitle' => 'Loi n 2018-1021 du 23 novembre 2018', 'desc' => 'Loi portant evolution du logement, de l\'amenagement et du numerique. L\'article 175 est a l\'origine du <strong class="text-dark-900">decret tertiaire</strong> : obligation de reduction de consommation pour les batiments tertiaires de plus de 1 000 m2.', 'extra' => null],
                ['badge' => 'Loi / 2021', 'bg' => 'bg-accent-800', 'title' => 'Loi Climat et Resilience', 'subtitle' => 'Loi n 2021-1104 du 22 aout 2021', 'desc' => 'Renforce les obligations energetiques : interdiction de location des passoires thermiques (DPE F et G), obligation d\'audit energetique avant vente, acceleration de la renovation du parc tertiaire. La GTB est un levier de conformite.', 'extra' => null],
            ] as $item)
            <div class="bg-white rounded-xl p-8 border border-dark-200 shadow-sm">
                <span class="inline-block text-[13px] font-medium text-white {{ $item['bg'] }} px-3 py-1 rounded-md mb-4">{{ $item['badge'] }}</span>
                <h3 class="text-[22px] font-medium text-dark-900 tracking-tight mb-3">{{ $item['title'] }}</h3>
                <p class="text-sm text-dark-400 mb-4">{{ $item['subtitle'] }}</p>
                <p class="text-[15px] text-dark-500 leading-relaxed">{!! $item['desc'] !!}</p>
                @if($item['extra'])
                {!! $item['extra'] !!}
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- NORME EN ISO 52120-1 -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Referentiel technique</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Norme EN ISO 52120-1 (ex-EN 15232)</h2>
            <p class="text-base text-dark-500 leading-relaxed">La norme de reference pour evaluer le niveau de performance des systemes GTB. Le decret BACS impose la classe B minimum.</p>
        </div>
        <div class="grid md:grid-cols-4 gap-5 mb-12">
            @foreach([
                ['badge' => 'Classe D', 'bg' => 'bg-dark-400', 'title' => 'Non performant', 'desc' => 'Aucun systeme d\'automatisation. Pilotage manuel.', 'sub' => 'Reference basse', 'highlight' => false],
                ['badge' => 'Classe C', 'bg' => 'bg-dark-500', 'title' => 'Standard', 'desc' => 'Regulation de base, programmation horaire, sans supervision.', 'sub' => 'Minimum neuf', 'highlight' => false],
                ['badge' => 'Classe B', 'bg' => 'bg-accent-600', 'title' => 'Avance', 'desc' => 'GTB centralisee, suivi energetique, detection de derives.', 'sub' => 'Exigence decret BACS', 'highlight' => true],
                ['badge' => 'Classe A', 'bg' => 'bg-dark-800', 'title' => 'Haute performance', 'desc' => 'Regulation piece par piece, optimisation multi-lots, IA.', 'sub' => 'Performance maximale', 'highlight' => false],
            ] as $cl)
            <div class="{{ $cl['highlight'] ? 'bg-white rounded-xl border border-accent-200 shadow-[0_0_0_3px] shadow-accent-50' : 'bg-white rounded-xl border border-dark-200 shadow-sm' }} p-6">
                <span class="inline-block text-[13px] font-medium text-white {{ $cl['bg'] }} px-2.5 py-1 rounded-md mb-3.5">{{ $cl['badge'] }}</span>
                <h3 class="text-[17px] font-medium text-dark-900 mb-2">{{ $cl['title'] }}</h3>
                <p class="text-[13px] text-dark-500 leading-relaxed mb-3">{{ $cl['desc'] }}</p>
                <p class="text-xs {{ $cl['highlight'] ? 'font-medium text-accent-600' : 'text-dark-400' }}">{{ $cl['sub'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Gains par classe -->
        <h3 class="text-lg font-medium text-dark-900 mb-4">Gains energetiques estimes par la norme</h3>
        <div class="border border-dark-200 rounded-xl overflow-hidden">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-dark-50">
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Passage</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">CVC (bureaux)</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Eclairage</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Global</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-dark-100">
                        <td class="p-3.5 font-medium text-dark-900">D &rarr; C</td>
                        <td class="p-3.5 text-dark-600">5 a 15 %</td>
                        <td class="p-3.5 text-dark-600">5 a 10 %</td>
                        <td class="p-3.5 text-dark-600">~10 %</td>
                    </tr>
                    <tr class="border-b border-dark-100">
                        <td class="p-3.5 font-medium text-accent-600">D &rarr; B</td>
                        <td class="p-3.5 text-dark-600">15 a 30 %</td>
                        <td class="p-3.5 text-dark-600">10 a 25 %</td>
                        <td class="p-3.5 font-medium text-accent-600">~25 %</td>
                    </tr>
                    <tr>
                        <td class="p-3.5 font-medium text-dark-900">D &rarr; A</td>
                        <td class="p-3.5 text-dark-600">25 a 45 %</td>
                        <td class="p-3.5 text-dark-600">20 a 40 %</td>
                        <td class="p-3.5 font-medium text-dark-900">~35 %</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- CEE -->
<section class="py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Aides financieres</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Certificats d'Economies d'Energie (CEE)</h2>
            <p class="text-base text-dark-500 leading-relaxed">Les CEE financent une partie significative de l'installation GTB. Deux fiches standardisees couvrent les travaux de GTB.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach([
                ['ref' => 'BAT-TH-116', 'subtitle' => 'Systeme de gestion technique du batiment pour le chauffage et le refroidissement', 'desc' => 'Couvre l\'installation d\'un systeme GTB de classe A ou B (ISO 52120-1) pour le pilotage du CVC. Le montant de la prime depend de la surface, de la zone climatique et de la classe atteinte.', 'cond' => 'Batiment tertiaire existant, installation par un professionnel, passage en classe A ou B verifie.'],
                ['ref' => 'BAT-TH-112', 'subtitle' => 'Systeme de variation electronique de vitesse sur moteur asynchrone', 'desc' => 'Couvre l\'installation de variateurs de vitesse sur les moteurs CVC (pompes, ventilateurs, compresseurs). Complementaire a la GTB qui envoie les consignes de vitesse.', 'cond' => 'Puissance moteur >= 0,55 kW, variateur certifie, installation sur moteur existant ou neuf.'],
            ] as $cee)
            <div class="bg-white rounded-xl p-8 border border-dark-200 shadow-sm">
                <span class="inline-block text-[13px] font-medium text-orange-800 bg-orange-50 px-3 py-1 rounded-md mb-4">Fiche standardisee</span>
                <h3 class="text-[22px] font-medium text-dark-900 tracking-tight mb-3">{{ $cee['ref'] }}</h3>
                <p class="text-sm text-dark-400 mb-4">{{ $cee['subtitle'] }}</p>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-4">{{ $cee['desc'] }}</p>
                <div class="p-3.5 rounded-lg bg-dark-50 border border-dark-200">
                    <p class="text-[13px] text-dark-500 leading-relaxed"><strong class="text-dark-900">Conditions :</strong> {{ $cee['cond'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="bg-accent-50 border border-accent-200 rounded-xl p-6 mt-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Estimation gratuite</p>
            <p class="text-sm text-dark-600 leading-relaxed">Utilisez notre <a href="/generateur-cee" class="text-accent-600 font-medium hover:text-accent-700">generateur CEE</a> pour estimer le montant de vos certificats d'economies d'energie en 3 minutes, sans intermediaire.</p>
        </div>
    </div>
</section>

<!-- SYNTHESE -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Synthese</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Comment la GTB repond a toutes ces obligations</h2>
            <p class="text-base text-dark-500 leading-relaxed">La GTB est le point de convergence de l'ensemble du cadre reglementaire du batiment tertiaire.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach([
                ['title' => 'Decret BACS', 'desc' => 'La GTB <strong class="text-accent-600">est</strong> l\'obligation. Classe A ou B requise.'],
                ['title' => 'Decret tertiaire', 'desc' => 'Levier principal pour atteindre les -40/-50/-60 %.'],
                ['title' => 'RE2020', 'desc' => 'Optimise le Cep et maitrise le DH sur le cycle de vie.'],
                ['title' => 'EPBD', 'desc' => 'Exigence europeenne transposee en droit national.'],
                ['title' => 'CEE', 'desc' => 'Financement via la fiche BAT-TH-116. Duree de vie 15 ans.'],
                ['title' => 'EN ISO 52120-1', 'desc' => 'Performances quantifiees : jusqu\'a 30 % d\'economies.'],
                ['title' => 'DPE / Audit', 'desc' => 'Ameliore la classe DPE et fournit les donnees pour l\'audit.'],
                ['title' => 'SRI', 'desc' => 'Au coeur de l\'indicateur d\'intelligence du batiment.'],
                ['title' => 'Taxonomie verte', 'desc' => 'Contribue a l\'alignement des investissements immobiliers.'],
            ] as $item)
            <div class="bg-white rounded-xl p-6 border border-dark-200 shadow-sm">
                <p class="text-[15px] font-medium text-dark-900 mb-1.5">{{ $item['title'] }}</p>
                <p class="text-[13px] text-dark-500 leading-relaxed">{!! $item['desc'] !!}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="relative overflow-hidden py-20 bg-dark-100 border-t border-dark-200">
    <img src="/images/hero-gtb-illustration.webp" alt="" aria-hidden="true" width="1200" height="630" loading="lazy" class="absolute right-0 top-0 h-full w-auto object-cover opacity-20" />
    <div class="absolute inset-0 bg-gradient-to-r from-dark-100 via-dark-100/80 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10 flex items-center min-h-[200px]">
        <div class="max-w-lg">
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Verifiez votre conformite</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">Identifiez votre classe ISO 52120-1, evaluez vos obligations BACS et estimez vos aides CEE.</p>
            <div class="flex flex-wrap gap-4">
                <a href="/audit" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
                    Lancer le diagnostic
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="/generateur-cee" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-600 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                    Estimer mes CEE
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
                ['href' => '/gtb', 'title' => "Qu'est-ce que la GTB ?", 'desc' => 'Comprendre la GTB avant de s\'attaquer a la reglementation.'],
                ['href' => '/audit', 'title' => 'Audit GTB gratuit', 'desc' => 'Evaluez votre niveau de conformite ISO 52120-1 en 5 minutes.'],
                ['href' => '/generateur-cee', 'title' => 'Simulateur CEE', 'desc' => 'Estimez vos primes Certificats d\'Economies d\'Energie.'],
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
