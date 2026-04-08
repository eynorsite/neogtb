@extends('front.layouts.app')

@section('title', 'Comparateur GTB — Schneider, Siemens, Honeywell — NeoGTB')
@section('description', 'Comparez 10+ solutions GTB : Schneider, Siemens Desigo, Honeywell Niagara, Sauter, Wago, Wattsense. Comparatif indépendant.')

@push('head')
<style>
  :root {
    --color-accent-50: #F0FDFA; --color-accent-100: #CCFBF1; --color-accent-200: #99F6E4;
    --color-accent-300: #5EEAD4; --color-accent-400: #2DD4BF; --color-accent-500: #14B8A6;
    --color-accent-600: #0D9488; --color-accent-700: #0F766E; --color-accent-800: #115E59;
    --color-dark-50: #FAFAF9; --color-dark-100: #F5F5F4; --color-dark-200: #E7E5E4;
    --color-dark-300: #D6D3D1; --color-dark-400: #A8A29E; --color-dark-500: #78716C;
    --color-dark-600: #57534E; --color-dark-700: #44403C; --color-dark-800: #292524;
    --color-dark-900: #1C1917;
  }
  [x-cloak] { display: none !important; }
  .hero-lum { position: relative; overflow: hidden; padding: 80px 0 64px; background: #edf5f7; }
  .hero-lum-img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center; }
  .hero-lum.hero-emerald { background: #edf5f7; }
  .hero-lum-mesh { position: absolute; inset: 0; pointer-events: none; background: linear-gradient(to bottom, rgba(237,245,247,0.4) 0%, rgba(237,245,247,0.95) 100%); }
  .hero-lum-grid { position: absolute; inset: 0; pointer-events: none; background-image: linear-gradient(rgba(16,185,129,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(16,185,129,0.04) 1px, transparent 1px), radial-gradient(circle 2px at center, rgba(16,185,129,0.12) 0%, transparent 2px); background-size: 48px 48px, 48px 48px, 48px 48px; mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 20%, transparent 70%); -webkit-mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 20%, transparent 70%); }
  .hero-orb { position: absolute; pointer-events: none; opacity: 0.5; }
  .hero-orb-1 { width: 200px; height: 200px; top: 8%; right: 15%; border: 1px solid rgba(16,185,129,0.08); border-radius: 50%; animation: hero-float 12s ease-in-out infinite; }
  .hero-orb-1::after { content: ''; position: absolute; top: 50%; left: 50%; width: 8px; height: 8px; border-radius: 50%; background: rgba(16,185,129,0.2); transform: translate(-50%, -50%); }
  .hero-orb-2 { width: 140px; height: 140px; bottom: 10%; left: 8%; border: 1px solid rgba(13,148,136,0.06); border-radius: 50%; animation: hero-float 10s ease-in-out infinite reverse; }
  .hero-orb-2::after { content: ''; position: absolute; top: 50%; left: 50%; width: 6px; height: 6px; border-radius: 50%; background: rgba(245,158,11,0.2); transform: translate(-50%, -50%); }
  .hero-orb-3 { width: 100px; height: 100px; top: 40%; left: 35%; border: 1px solid rgba(13,148,136,0.05); border-radius: 50%; animation: hero-float 14s ease-in-out infinite 2s; }
  .hero-orb-3::after { content: ''; position: absolute; top: 50%; left: 50%; width: 5px; height: 5px; border-radius: 50%; background: rgba(13,148,136,0.15); transform: translate(-50%, -50%); }
  @keyframes hero-float { 0%, 100% { transform: translate(0, 0) scale(1); } 33% { transform: translate(12px, -8px) scale(1.02); } 66% { transform: translate(-6px, 6px) scale(0.98); } }
  .eyebrow { font-size: 12px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: var(--color-accent-600); }
  .accent { background: linear-gradient(135deg, var(--color-accent-700) 0%, var(--color-accent-500) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
  .hero-bg-illustration { position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 50%; max-width: 600px; height: auto; object-fit: contain; pointer-events: none; opacity: 0.5; }
  .btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 500; background: var(--color-dark-900); color: white; text-decoration: none; transition: all 0.2s; }
  .btn-primary:hover { background: var(--color-dark-800); transform: translateY(-1px); }
  .btn-secondary { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 500; color: var(--color-dark-700); border: 1px solid var(--color-dark-200); text-decoration: none; transition: all 0.15s; }
  .btn-secondary:hover { border-color: var(--color-dark-400); background: var(--color-dark-50); }
</style>
@endpush

@section('content')

  {{-- Breadcrumbs --}}
  <nav class="max-w-7xl mx-auto px-6 md:px-10 py-3 text-sm text-dark-400">
    <a href="/" class="hover:text-primary-600 transition-colors">Accueil</a>
    <span class="mx-2">/</span>
    <span class="text-dark-300">Outils</span>
    <span class="mx-2">/</span>
    <span class="text-dark-600 font-medium">Comparateur GTB</span>
  </nav>

  <!-- Hero -->
  <section class="hero-lum hero-emerald">
    <img src="/images/hero-comparateur.png" alt="Comparaison de bâtiments intelligents — GTB" class="hero-lum-img" width="1200" height="630" loading="eager" fetchpriority="high" />
    <div class="hero-lum-mesh"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 text-center relative z-10">
      <span class="eyebrow">Outil indépendant</span>
      <h1 class="mt-5 text-4xl md:text-5xl font-heading font-medium" style="color: var(--color-dark-900);">Comparateur objectif <span class="accent">GTB</span></h1>
      <p class="mt-4 text-lg max-w-2xl mx-auto" style="font-weight: 400; color: var(--color-dark-500);">
        Analysez et comparez les solutions des principaux acteurs du marché de la Gestion Technique du Bâtiment. Notes, protocoles, budgets et retours terrain pour un choix éclairé.
      </p>
    </div>
  </section>

  <!-- Disclaimer -->
  <section class="py-4">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
      <div class="rounded-xl p-5" style="background: #FFF7ED; border: 1px solid #FED7AA;">
        <p style="font-size: 14px; font-weight: 500; color: #9A3412; margin-bottom: 6px;">Avertissement &mdash; Comparateur indépendant</p>
        <p style="font-size: 13px; color: #78350F; line-height: 1.7;">
          Ce comparateur est un outil éducatif à visée informative. Les données techniques proviennent de la documentation officielle des constructeurs. Les notes sont des <strong>estimations éditoriales</strong> de la rédaction NeoGTB. Les budgets indicatifs sont des ordres de grandeur. NeoGTB ne perçoit aucune rémunération des marques listées. Dernière mise à jour : mars 2026.
        </p>
      </div>
    </div>
  </section>

  <!-- Methodologie -->
  <section class="py-8">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
      <div class="bg-white rounded-xl p-6" style="border: 0.5px solid rgba(0,0,0,0.08);" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center justify-between w-full text-left">
          <div>
            <p style="font-size: 16px; font-weight: 500; color: #111;">Méthodologie de notation</p>
            <p style="font-size: 13px; color: #6b7280; margin-top: 2px;">6 critères, pondération égale, sources documentaires constructeurs</p>
          </div>
          <svg :class="open && 'rotate-180'" class="w-5 h-5 text-dark-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div x-show="open" x-collapse>
          <div class="mt-6 pt-6" style="border-top: 0.5px solid rgba(0,0,0,0.08);">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
              <div><p style="font-size: 13px; font-weight: 500; color: #111; margin-bottom: 4px;">Facilité d'installation</p><p style="font-size: 12px; color: #6b7280; line-height: 1.6;">Temps de déploiement, nécessité de câblage, complexité de mise en service.</p></div>
              <div><p style="font-size: 13px; font-weight: 500; color: #111; margin-bottom: 4px;">Rapport qualité/prix</p><p style="font-size: 12px; color: #6b7280; line-height: 1.6;">Coût total de possession rapporté aux fonctionnalités offertes.</p></div>
              <div><p style="font-size: 13px; font-weight: 500; color: #111; margin-bottom: 4px;">Fonctionnalités</p><p style="font-size: 12px; color: #6b7280; line-height: 1.6;">Étendue des fonctions natives : régulation, supervision, alarmes, historisation, reporting, IA.</p></div>
              <div><p style="font-size: 13px; font-weight: 500; color: #111; margin-bottom: 4px;">Support en France</p><p style="font-size: 12px; color: #6b7280; line-height: 1.6;">Présence commerciale et technique sur le territoire, réseau d'intégrateurs.</p></div>
              <div><p style="font-size: 13px; font-weight: 500; color: #111; margin-bottom: 4px;">Innovation</p><p style="font-size: 12px; color: #6b7280; line-height: 1.6;">Adoption des technologies récentes : cloud natif, IA/ML, IoT, cybersécurité.</p></div>
              <div><p style="font-size: 13px; font-weight: 500; color: #111; margin-bottom: 4px;">Interopérabilité</p><p style="font-size: 12px; color: #6b7280; line-height: 1.6;">Nombre et diversité des protocoles supportés nativement, certifications BTL/KNX.</p></div>
            </div>
            <div class="rounded-lg p-4" style="background: #F9FAFB; border: 0.5px solid rgba(0,0,0,0.08);">
              <p style="font-size: 12px; color: #6b7280; line-height: 1.7;"><strong style="color: #374151;">Sources :</strong> Documentation technique officielle des constructeurs, norme NF EN ISO 52120-1:2022, rapports BMS Market 2026. Les notes /10 sont des estimations éditoriales de la rédaction NeoGTB.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Comparateur -->
  <section class="py-12">
    <div class="max-w-7xl mx-auto px-6 md:px-10" x-data="comparateur()" x-init="init()">

      <!-- Filtres -->
      <div class="bg-white rounded-2xl p-6 mb-8 sticky top-20 z-40" style="border: 0.5px solid rgba(0,0,0,0.08);">
        <div class="flex flex-wrap items-center gap-4">
          <div>
            <label class="block text-xs font-medium text-dark-500 uppercase tracking-wider mb-1">Catégorie</label>
            <select x-model="filterCategory" class="px-3 py-2 rounded-lg text-sm bg-white outline-none" style="border: 0.5px solid rgba(0,0,0,0.08); border-radius: 8px;">
              <option value="all">Toutes</option>
              <option value="leader">Leaders mondiaux</option>
              <option value="europeen">Européens</option>
              <option value="supervision">Supervision / Logiciel</option>
              <option value="iot">IoT / Sans fil</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-medium text-dark-500 uppercase tracking-wider mb-1">Protocole</label>
            <select x-model="filterProtocol" class="px-3 py-2 rounded-lg text-sm bg-white outline-none" style="border: 0.5px solid rgba(0,0,0,0.08); border-radius: 8px;">
              <option value="all">Tous</option>
              <option value="BACnet">BACnet</option><option value="KNX">KNX</option><option value="Modbus">Modbus</option>
              <option value="LON">LON</option><option value="LoRaWAN">LoRaWAN</option><option value="DALI">DALI</option>
              <option value="M-Bus">M-Bus</option><option value="MQTT">MQTT</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-medium text-dark-500 uppercase tracking-wider mb-1">Type de bâtiment</label>
            <select x-model="filterBuilding" class="px-3 py-2 rounded-lg text-sm bg-white outline-none" style="border: 0.5px solid rgba(0,0,0,0.08); border-radius: 8px;">
              <option value="all">Tous</option>
              <option value="petit">Petit (&lt; 2 000 m&sup2;)</option>
              <option value="moyen">Moyen (2 000 - 10 000 m&sup2;)</option>
              <option value="grand">Grand (&gt; 10 000 m&sup2;)</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-medium text-dark-500 uppercase tracking-wider mb-1">Budget</label>
            <select x-model="filterBudget" class="px-3 py-2 rounded-lg text-sm bg-white outline-none" style="border: 0.5px solid rgba(0,0,0,0.08); border-radius: 8px;">
              <option value="all">Tous</option><option value="bas">Accessible</option><option value="moyen">Moyen</option><option value="eleve">Élevé</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-medium text-dark-500 uppercase tracking-wider mb-1">Trier par</label>
            <select x-model="sortBy" class="px-3 py-2 rounded-lg text-sm bg-white outline-none" style="border: 0.5px solid rgba(0,0,0,0.08); border-radius: 8px;">
              <option value="nom">Nom</option><option value="note">Note globale</option><option value="prix">Prix (croissant)</option><option value="facilite">Facilité d'installation</option>
            </select>
          </div>
          <div class="ml-auto">
            <label class="block text-xs font-medium text-dark-500 uppercase tracking-wider mb-1">&nbsp;</label>
            <button @click="resetFilters()" class="px-4 py-2 text-sm text-dark-500 rounded-lg hover:text-dark-700" style="border: 0.5px solid rgba(0,0,0,0.08);">Réinitialiser</button>
          </div>
        </div>
        <div class="mt-3 text-sm text-dark-400" style="font-weight: 400;"><span x-text="filteredBrands().length"></span> marque(s) affichée(s)</div>
      </div>

      <!-- Cards des marques -->
      <div class="grid md:grid-cols-2 gap-6">
        <template x-for="brand in filteredBrands()" :key="brand.nom">
          <div class="card-hover bg-white rounded-xl overflow-hidden" style="border: 0.5px solid rgba(0,0,0,0.08);">
            <div class="p-6" style="border-bottom: 0.5px solid rgba(0,0,0,0.08);">
              <div class="flex items-start justify-between">
                <div>
                  <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-medium text-sm" :style="'background-color:' + brand.couleur"><span x-text="brand.sigle"></span></div>
                    <div>
                      <h3 class="text-xl font-heading font-medium text-dark-900" x-text="brand.nom"></h3>
                      <p class="text-sm text-dark-400" style="font-weight: 400;" x-text="brand.pays + ' \u2014 ' + brand.categorie_label"></p>
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <div class="text-2xl font-heading font-medium" :class="brand.note >= 8 ? 'text-accent-600' : brand.note >= 6 ? 'text-primary-600' : 'text-orange-500'" x-text="brand.note + '/10'"></div>
                  <p class="text-xs text-dark-400" style="font-weight: 400;">Note globale</p>
                </div>
              </div>
              <p class="mt-3 text-sm text-dark-600" style="font-weight: 400;" x-text="brand.description"></p>
            </div>
            <div class="px-6 py-3 bg-dark-50" style="border-bottom: 0.5px solid rgba(0,0,0,0.08);">
              <span class="text-xs font-medium text-dark-400 uppercase tracking-wider">Produit phare :</span>
              <span class="text-sm font-medium text-dark-800 ml-1" x-text="brand.produit_phare"></span>
            </div>
            <div class="p-6 space-y-3">
              <template x-for="critere in ['facilite_installation', 'rapport_qualite_prix', 'fonctionnalites', 'support_france', 'innovation', 'interoperabilite']" :key="critere">
                <div>
                  <div class="flex justify-between text-sm mb-1">
                    <span class="text-dark-600" style="font-weight: 400;" x-text="critereLabels[critere]"></span>
                    <span class="font-medium text-dark-800" x-text="brand.scores[critere] + '/10'"></span>
                  </div>
                  <div class="w-full bg-dark-100 rounded-full h-1.5">
                    <div class="h-1.5 rounded-full" :class="brand.scores[critere] >= 8 ? 'bg-accent-500' : brand.scores[critere] >= 6 ? 'bg-primary-500' : brand.scores[critere] >= 4 ? 'bg-orange-400' : 'bg-red-400'" :style="'width:' + (brand.scores[critere] * 10) + '%'"></div>
                  </div>
                </div>
              </template>
            </div>
            <div class="px-6 pb-4">
              <div class="flex flex-wrap gap-1.5">
                <template x-for="proto in brand.protocoles" :key="proto">
                  <span class="px-2 py-0.5 bg-primary-50 text-primary-700 text-xs font-medium rounded-full" x-text="proto"></span>
                </template>
              </div>
            </div>
            <div class="px-6 pb-4 grid grid-cols-2 gap-4">
              <div>
                <h4 class="text-xs font-medium text-accent-600 uppercase tracking-wider mb-2">Forces</h4>
                <ul class="space-y-1">
                  <template x-for="force in brand.forces" :key="force">
                    <li class="flex items-start gap-1.5 text-xs text-dark-600" style="font-weight: 400;">
                      <svg class="w-3.5 h-3.5 text-accent-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                      <span x-text="force"></span>
                    </li>
                  </template>
                </ul>
              </div>
              <div>
                <h4 class="text-xs font-medium text-red-500 uppercase tracking-wider mb-2">Limites</h4>
                <ul class="space-y-1">
                  <template x-for="faiblesse in brand.faiblesses" :key="faiblesse">
                    <li class="flex items-start gap-1.5 text-xs text-dark-600" style="font-weight: 400;">
                      <svg class="w-3.5 h-3.5 text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                      <span x-text="faiblesse"></span>
                    </li>
                  </template>
                </ul>
              </div>
            </div>
            <div class="px-6 pb-4">
              <h4 class="text-xs font-medium text-dark-400 uppercase tracking-wider mb-2">Idéal pour</h4>
              <div class="flex flex-wrap gap-1.5">
                <template x-for="usage in brand.ideal_pour" :key="usage">
                  <span class="px-2 py-1 bg-dark-100 text-dark-600 text-xs rounded-full" style="font-weight: 400;" x-text="usage"></span>
                </template>
              </div>
            </div>
            <div class="px-6 pb-6 flex items-center justify-between">
              <div>
                <span class="text-xs text-dark-400" style="font-weight: 400;">Budget indicatif :</span>
                <span class="ml-1 text-sm font-medium" :class="brand.budget === 'bas' ? 'text-accent-600' : brand.budget === 'moyen' ? 'text-primary-600' : 'text-orange-600'" x-text="brand.budget_label"></span>
              </div>
              <a :href="brand.site" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-primary-600 hover:text-primary-700">Site officiel &rarr;</a>
            </div>
          </div>
        </template>
      </div>

      <div x-show="filteredBrands().length === 0" class="text-center py-16">
        <p class="text-dark-400 text-lg" style="font-weight: 400;">Aucune marque ne correspond à vos filtres.</p>
        <button @click="resetFilters()" class="mt-4 px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Réinitialiser les filtres</button>
      </div>
    </div>
  </section>

  <!-- Tableau comparatif rapide -->
  <section class="py-16 bg-dark-50">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
      <h2 class="text-[28px] font-heading font-medium text-dark-900 mb-8 text-center">Tableau comparatif rapide</h2>
      <div class="overflow-x-auto">
        <table class="w-full bg-white rounded-xl overflow-hidden text-sm" style="border: 0.5px solid rgba(0,0,0,0.08);">
          <thead>
            <tr class="bg-dark-800 text-white">
              <th class="px-4 py-3 text-left font-medium">Marque</th>
              <th class="px-4 py-3 text-center font-medium">Protocoles</th>
              <th class="px-4 py-3 text-center font-medium">Certifications</th>
              <th class="px-4 py-3 text-center font-medium">Cloud</th>
              <th class="px-4 py-3 text-center font-medium">Sans fil</th>
              <th class="px-4 py-3 text-center font-medium">Multi-sites</th>
              <th class="px-4 py-3 text-center font-medium">Budget</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-dark-100">
            <tr><td class="px-4 py-3 font-medium">Schneider Electric</td><td class="px-4 py-3 text-center" style="font-weight:400;">BACnet/IP, Modbus, KNX, LON</td><td class="px-4 py-3 text-center" style="font-weight:400;">BTL B-BC, B-OWS</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-orange-600 font-medium">&euro;&euro;&euro;</td></tr>
            <tr class="bg-dark-50"><td class="px-4 py-3 font-medium">Siemens</td><td class="px-4 py-3 text-center" style="font-weight:400;">BACnet/IP, BACnet SC, Modbus, KNX, OPC</td><td class="px-4 py-3 text-center" style="font-weight:400;">IEC 62443</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-dark-300">&mdash;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-orange-600 font-medium">&euro;&euro;&euro;</td></tr>
            <tr><td class="px-4 py-3 font-medium">TheWatchdog</td><td class="px-4 py-3 text-center" style="font-weight:400;">BACnet, Modbus, KNX, LoRaWAN, DALI, 4G</td><td class="px-4 py-3 text-center" style="font-weight:400;">&mdash;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-accent-600 font-medium">&euro;&euro;</td></tr>
            <tr class="bg-dark-50"><td class="px-4 py-3 font-medium">Honeywell</td><td class="px-4 py-3 text-center" style="font-weight:400;">BACnet, Modbus, LON, fox(s)</td><td class="px-4 py-3 text-center" style="font-weight:400;">&mdash;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-dark-300">&mdash;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-orange-600 font-medium">&euro;&euro;&euro;</td></tr>
            <tr><td class="px-4 py-3 font-medium">Sauter</td><td class="px-4 py-3 text-center" style="font-weight:400;">BACnet/IP, BACnet MS/TP, Modbus, KNX, DALI, M-Bus</td><td class="px-4 py-3 text-center" style="font-weight:400;">BTL B-BC, B-LD &middot; IEC 62443</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-dark-300">&mdash;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-primary-600 font-medium">&euro;&euro;</td></tr>
            <tr class="bg-dark-50"><td class="px-4 py-3 font-medium">Wago</td><td class="px-4 py-3 text-center" style="font-weight:400;">BACnet/IP, Modbus TCP/RTU, KNX, DALI</td><td class="px-4 py-3 text-center" style="font-weight:400;">&mdash;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-dark-300">&mdash;</td><td class="px-4 py-3 text-center text-dark-300">&mdash;</td><td class="px-4 py-3 text-center text-accent-600 font-medium">&euro;</td></tr>
            <tr><td class="px-4 py-3 font-medium">Wattsense</td><td class="px-4 py-3 text-center" style="font-weight:400;">BACnet, Modbus, LoRaWAN, KNX, M-Bus, MQTT</td><td class="px-4 py-3 text-center" style="font-weight:400;">&mdash;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-accent-600 font-medium">&euro;</td></tr>
            <tr class="bg-dark-50"><td class="px-4 py-3 font-medium">ABB</td><td class="px-4 py-3 text-center" style="font-weight:400;">KNX, BACnet/IP, Modbus, IP</td><td class="px-4 py-3 text-center" style="font-weight:400;">&mdash;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-dark-300">&mdash;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-primary-600 font-medium">&euro;&euro;</td></tr>
            <tr><td class="px-4 py-3 font-medium">Beckhoff</td><td class="px-4 py-3 text-center" style="font-weight:400;">BACnet, Modbus, KNX, EtherCAT, IP</td><td class="px-4 py-3 text-center" style="font-weight:400;">&mdash;</td><td class="px-4 py-3 text-center text-dark-300">&mdash;</td><td class="px-4 py-3 text-center text-dark-300">&mdash;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-primary-600 font-medium">&euro;&euro;</td></tr>
            <tr class="bg-dark-50"><td class="px-4 py-3 font-medium">Loytec</td><td class="px-4 py-3 text-center" style="font-weight:400;">BACnet, LON, KNX, Modbus, DALI, IP</td><td class="px-4 py-3 text-center" style="font-weight:400;">&mdash;</td><td class="px-4 py-3 text-center text-dark-300">&mdash;</td><td class="px-4 py-3 text-center text-dark-300">&mdash;</td><td class="px-4 py-3 text-center text-accent-600">&#10003;</td><td class="px-4 py-3 text-center text-primary-600 font-medium">&euro;&euro;</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Guide de choix -->
  <section class="py-16">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
      <h2 class="text-[28px] font-heading font-medium text-dark-900 mb-8 text-center">Comment choisir ?</h2>
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="card-hover p-6 bg-white rounded-xl" style="border: 0.5px solid rgba(0,0,0,0.08);">
          <div class="text-3xl mb-3">&#127970;</div>
          <h3 class="font-medium text-dark-900">Petit bâtiment</h3>
          <p class="mt-2 text-sm text-dark-500" style="font-weight: 400;">&lt; 2 000 m&sup2; &mdash; Budget limité</p>
          <div class="mt-3 space-y-1">
            <p class="text-sm font-medium text-primary-600">&rarr; TheWatchdog</p>
            <p class="text-sm font-medium text-primary-600">&rarr; Wago</p>
            <p class="text-sm font-medium text-primary-600">&rarr; Wattsense</p>
          </div>
        </div>
        <div class="card-hover p-6 bg-white rounded-xl" style="border: 0.5px solid rgba(0,0,0,0.08);">
          <div class="text-3xl mb-3">&#127980;</div>
          <h3 class="font-medium text-dark-900">Bâtiment moyen</h3>
          <p class="mt-2 text-sm text-dark-500" style="font-weight: 400;">2 000 - 10 000 m&sup2;</p>
          <div class="mt-3 space-y-1">
            <p class="text-sm font-medium text-primary-600">&rarr; TheWatchdog</p>
            <p class="text-sm font-medium text-primary-600">&rarr; Sauter</p>
          </div>
        </div>
        <div class="card-hover p-6 bg-white rounded-xl" style="border: 0.5px solid rgba(0,0,0,0.08);">
          <div class="text-3xl mb-3">&#127961;&#65039;</div>
          <h3 class="font-medium text-dark-900">Grand bâtiment</h3>
          <p class="mt-2 text-sm text-dark-500" style="font-weight: 400;">&gt; 10 000 m&sup2;</p>
          <div class="mt-3 space-y-1">
            <p class="text-sm font-medium text-primary-600">&rarr; Schneider Electric</p>
            <p class="text-sm font-medium text-primary-600">&rarr; Siemens</p>
            <p class="text-sm font-medium text-primary-600">&rarr; Honeywell</p>
          </div>
        </div>
        <div class="card-hover p-6 bg-white rounded-xl" style="border: 0.5px solid rgba(0,0,0,0.08);">
          <div class="text-3xl mb-3">&#128260;</div>
          <h3 class="font-medium text-dark-900">Retrofit / Existant</h3>
          <p class="mt-2 text-sm text-dark-500" style="font-weight: 400;">Mise à niveau sans travaux</p>
          <div class="mt-3 space-y-1">
            <p class="text-sm font-medium text-primary-600">&rarr; TheWatchdog</p>
            <p class="text-sm font-medium text-primary-600">&rarr; Wattsense</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="relative overflow-hidden" style="padding: 80px 0; background: #F0F2F5; min-height: 360px; border-top: 1px solid var(--color-dark-200);">
    <img src="/images/hero-gtb-illustration.webp" alt="" aria-hidden="true" width="1200" height="630" loading="lazy" class="hero-bg-illustration" />
    <div style="position: absolute; inset: 0; background: linear-gradient(to right, #F0F2F5 30%, rgba(240,242,245,0.3) 70%); pointer-events: none;"></div>
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-6 md:px-10 relative z-10" style="display: flex; align-items: center; min-height: 200px;">
      <div style="max-width: 520px;">
        <h2 style="font-size: 28px; font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 12px;">Besoin d'aide pour choisir ?</h2>
        <p style="font-size: 16px; color: var(--color-dark-500); line-height: 1.7; margin-bottom: 28px;">Notre audit gratuit analyse votre bâtiment et vous recommande les solutions les plus adaptées.</p>
        <div class="flex flex-wrap gap-4">
          <a href="/audit" class="btn-primary">Lancer l'audit gratuit <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
          <a href="/contact" class="btn-secondary">Demander un conseil</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Pages associées -->
  <section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-6 md:px-10">
      <h2 class="text-lg font-heading font-medium text-dark-800 mb-6">Pages associées</h2>
      <div class="grid md:grid-cols-3 gap-4">
        <a href="/audit" class="block p-5 rounded-xl border border-dark-200 hover:border-primary-300 transition-colors group">
          <p class="font-medium text-dark-900 group-hover:text-primary-600 transition-colors">Audit GTB gratuit</p>
          <p class="text-sm text-dark-400 mt-1">Diagnostiquez d'abord votre bâtiment avant de comparer.</p>
        </a>
        <a href="/solutions" class="block p-5 rounded-xl border border-dark-200 hover:border-primary-300 transition-colors group">
          <p class="font-medium text-dark-900 group-hover:text-primary-600 transition-colors">Solutions & Technologies</p>
          <p class="text-sm text-dark-400 mt-1">Protocoles, capteurs et architecture GTB en détail.</p>
        </a>
        <a href="/gtb" class="block p-5 rounded-xl border border-dark-200 hover:border-primary-300 transition-colors group">
          <p class="font-medium text-dark-900 group-hover:text-primary-600 transition-colors">Qu'est-ce que la GTB ?</p>
          <p class="text-sm text-dark-400 mt-1">Les bases pour comprendre la Gestion Technique du Bâtiment.</p>
        </a>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('comparateur', () => ({
      filterCategory: 'all', filterProtocol: 'all', filterBuilding: 'all', filterBudget: 'all', sortBy: 'note',

      init() {
        let surface = null;
        const params = new URLSearchParams(window.location.search);
        if (params.get('surface')) { surface = Number(params.get('surface')); }
        else { try { const d = JSON.parse(localStorage.getItem('neogtb_diag') || '{}'); if (d.surface) surface = d.surface; } catch(e) {} }
        if (surface) { if (surface < 2000) this.filterBuilding = 'petit'; else if (surface <= 10000) this.filterBuilding = 'moyen'; else this.filterBuilding = 'grand'; }
        if (surface && surface < 2000) this.filterBudget = 'bas';
        else if (surface && surface > 10000) this.filterBudget = 'eleve';
      },

      critereLabels: { facilite_installation: "Facilit\u00e9 d'installation", rapport_qualite_prix: "Rapport qualit\u00e9/prix", fonctionnalites: "Fonctionnalit\u00e9s", support_france: "Support en France", innovation: "Innovation", interoperabilite: "Interop\u00e9rabilit\u00e9" },

      brands: [
        { nom: "Schneider Electric", sigle: "SE", pays: "France", couleur: "#3DCD58", categorie: "leader", categorie_label: "Leader mondial", note: 8, description: "Leader mondial de la gestion de l'\u00e9nergie. EcoStruxure Building Operation est la plateforme de r\u00e9f\u00e9rence pour les grands b\u00e2timents tertiaires.", produit_phare: "EcoStruxure Building Operation (EBO) / SpaceLogic", protocoles: ["BACnet/IP", "Modbus", "KNX", "LON", "IP"], budget: "eleve", budget_label: "\u20ac\u20ac\u20ac \u2014 Premium", site: "https://www.se.com/fr/fr/", batiments: ["moyen", "grand"], scores: { facilite_installation: 5, rapport_qualite_prix: 6, fonctionnalites: 10, support_france: 10, innovation: 9, interoperabilite: 9 }, forces: ["\u00c9cosyst\u00e8me complet", "IA int\u00e9gr\u00e9e", "Leader en France", "Multi-protocoles"], faiblesses: ["Co\u00fbt \u00e9lev\u00e9", "Complexit\u00e9 de mise en \u0153uvre", "D\u00e9pendance \u00e9cosyst\u00e8me"], ideal_pour: ["Grands tertiaires", "Multi-sites", "Industrie"] },
        { nom: "Siemens", sigle: "SI", pays: "Allemagne", couleur: "#009999", categorie: "leader", categorie_label: "Leader mondial", note: 8, description: "R\u00e9f\u00e9rence mondiale avec Desigo CC V9. Supporte BACnet (+ Secure Connect), OPC, Modbus, KNX. Certifi\u00e9 IEC 62443.", produit_phare: "Desigo CC V9 + PXC", protocoles: ["BACnet/IP", "BACnet SC", "Modbus", "KNX", "OPC", "SNMP"], budget: "eleve", budget_label: "\u20ac\u20ac\u20ac \u2014 Premium", site: "https://www.siemens.com/fr/", batiments: ["moyen", "grand"], scores: { facilite_installation: 5, rapport_qualite_prix: 6, fonctionnalites: 10, support_france: 8, innovation: 9, interoperabilite: 9 }, forces: ["Robustesse industrielle", "Int\u00e9gration s\u00e9curit\u00e9 incendie", "Desigo CC tr\u00e8s puissant"], faiblesses: ["Co\u00fbt d'entr\u00e9e \u00e9lev\u00e9", "Interface moins moderne", "Installation longue"], ideal_pour: ["H\u00f4pitaux", "A\u00e9roports", "Grands tertiaires"] },
        { nom: "TheWatchdog", sigle: "TWD", pays: "France", couleur: "#FF6B35", categorie: "supervision", categorie_label: "Supervision / IoT / IA", note: 9, description: "Solution fran\u00e7aise de pilotage GTB/GTC par IoT sans fil (LoRaWAN & 4G). D\u00e9ploiement sans c\u00e2blage, compatible GTB existantes.", produit_phare: "Watchdog BOS", protocoles: ["BACnet", "Modbus", "KNX", "LoRaWAN", "DALI", "4G"], budget: "moyen", budget_label: "\u20ac\u20ac \u2014 Accessible", site: "https://www.thewatchdog.io/", batiments: ["petit", "moyen", "grand"], scores: { facilite_installation: 10, rapport_qualite_prix: 9, fonctionnalites: 8, support_france: 9, innovation: 10, interoperabilite: 9 }, forces: ["Installation en quelques heures", "IA pr\u00e9dictive", "Compatible GTB existantes", "Jusqu'\u00e0 36% d'\u00e9conomies"], faiblesses: ["Marque plus r\u00e9cente", "Pas de mat\u00e9riel de r\u00e9gulation propre"], ideal_pour: ["Retrofit / existant", "Multi-sites", "Petits & moyens b\u00e2timents"] },
        { nom: "Honeywell", sigle: "HW", pays: "USA", couleur: "#E4002B", categorie: "leader", categorie_label: "Leader mondial", note: 8, description: "Acteur historique. Niagara Framework (Tridium) est le standard d'int\u00e9gration multi-constructeurs via JACE 8000.", produit_phare: "Niagara Framework / JACE 8000", protocoles: ["BACnet", "Modbus", "LON", "fox(s)", "IP"], budget: "eleve", budget_label: "\u20ac\u20ac\u20ac \u2014 Premium", site: "https://www.honeywell.com/", batiments: ["moyen", "grand"], scores: { facilite_installation: 5, rapport_qualite_prix: 6, fonctionnalites: 9, support_france: 7, innovation: 8, interoperabilite: 10 }, forces: ["Niagara = standard d'int\u00e9gration", "Interop\u00e9rabilit\u00e9 maximale", "\u00c9norme parc install\u00e9"], faiblesses: ["Co\u00fbt licence Niagara \u00e9lev\u00e9", "Moins pr\u00e9sent en France", "Complexit\u00e9 technique"], ideal_pour: ["Int\u00e9gration multi-constructeurs", "Grands b\u00e2timents"] },
        { nom: "Sauter", sigle: "SA", pays: "Suisse", couleur: "#005CA9", categorie: "europeen", categorie_label: "Europ\u00e9en sp\u00e9cialis\u00e9", note: 7, description: "Fabricant suisse, r\u00e9gulation CVC haut de gamme. Gamme modulo 6 certifi\u00e9e BTL.", produit_phare: "modulo 6 (BTL) + SAUTER Vision Center", protocoles: ["BACnet/IP", "BACnet MS/TP", "Modbus", "KNX", "DALI", "M-Bus"], budget: "moyen", budget_label: "\u20ac\u20ac \u2014 Interm\u00e9diaire", site: "https://www.sauter-controls.com/fr/", batiments: ["moyen", "grand"], scores: { facilite_installation: 6, rapport_qualite_prix: 8, fonctionnalites: 7, support_france: 8, innovation: 6, interoperabilite: 7 }, forces: ["R\u00e9gulation CVC haut de gamme", "Fiabilit\u00e9 suisse", "Bon rapport qualit\u00e9/prix"], faiblesses: ["Moins de fonctionnalit\u00e9s que Schneider/Siemens", "Pas de solution IoT sans fil"], ideal_pour: ["B\u00e2timents tertiaires moyens", "R\u00e9gulation CVC"] },
        { nom: "ABB", sigle: "ABB", pays: "Suisse", couleur: "#FF000F", categorie: "europeen", categorie_label: "Europ\u00e9en sp\u00e9cialis\u00e9", note: 7, description: "G\u00e9ant de l'\u00e9lectrotechnique. Leader KNX mondial avec ABB i-bus KNX.", produit_phare: "ABB i-bus KNX + AC500", protocoles: ["KNX", "BACnet/IP", "Modbus", "IP"], budget: "moyen", budget_label: "\u20ac\u20ac \u2014 Interm\u00e9diaire", site: "https://new.abb.com/fr", batiments: ["petit", "moyen", "grand"], scores: { facilite_installation: 6, rapport_qualite_prix: 7, fonctionnalites: 7, support_france: 7, innovation: 7, interoperabilite: 8 }, forces: ["Leader KNX mondial", "ABB-free@home", "Automatisation industrielle"], faiblesses: ["GTB pas le c\u0153ur de m\u00e9tier", "Supervision moins mature"], ideal_pour: ["KNX r\u00e9sidentiel/petit tertiaire", "Automatisation industrielle"] },
        { nom: "Wago", sigle: "WA", pays: "Allemagne", couleur: "#FF6600", categorie: "europeen", categorie_label: "Europ\u00e9en sp\u00e9cialis\u00e9", note: 7, description: "Fabricant allemand de contr\u00f4leurs compacts. PFC200 Gen.2 : processeur Cortex A8, 512 Mo RAM.", produit_phare: "PFC200 Gen.2 + e!COCKPIT", protocoles: ["BACnet/IP", "Modbus TCP", "Modbus RTU", "KNX", "DALI"], budget: "bas", budget_label: "\u20ac \u2014 \u00c9conomique", site: "https://www.wago.com/fr/", batiments: ["petit", "moyen"], scores: { facilite_installation: 7, rapport_qualite_prix: 9, fonctionnalites: 6, support_france: 7, innovation: 7, interoperabilite: 8 }, forces: ["Excellent rapport qualit\u00e9/prix", "Contr\u00f4leurs polyvalents", "Programmation libre CODESYS"], faiblesses: ["Pas de supervision propre", "Pas de solution cloud mature"], ideal_pour: ["Int\u00e9grateurs GTB", "Petits/moyens b\u00e2timents", "Budget serr\u00e9"] },
        { nom: "Wattsense", sigle: "WS", pays: "France", couleur: "#6366F1", categorie: "iot", categorie_label: "IoT / Connectivit\u00e9", note: 8, description: "Entreprise fran\u00e7aise sp\u00e9cialis\u00e9e dans la connectivit\u00e9 IoT b\u00e2timent. Deux produits : Bridge et Tower.", produit_phare: "Wattsense Bridge + Tower", protocoles: ["BACnet", "Modbus", "LoRaWAN", "KNX", "M-Bus", "MQTT"], budget: "bas", budget_label: "\u20ac \u2014 \u00c9conomique", site: "https://www.wattsense.com/fr/", batiments: ["petit", "moyen"], scores: { facilite_installation: 9, rapport_qualite_prix: 9, fonctionnalites: 5, support_france: 8, innovation: 8, interoperabilite: 8 }, forces: ["Installation plug & play", "Prix tr\u00e8s comp\u00e9titif", "Compatible \u00e9quipements existants", "API ouverte"], faiblesses: ["Pas de r\u00e9gulation int\u00e9gr\u00e9e", "Fonctionnalit\u00e9s supervision limit\u00e9es"], ideal_pour: ["Connecter des b\u00e2timents existants", "Sous-comptage IoT", "Petits budgets"] },
        { nom: "Beckhoff", sigle: "BK", pays: "Allemagne", couleur: "#E30613", categorie: "europeen", categorie_label: "Europ\u00e9en sp\u00e9cialis\u00e9", note: 7, description: "Pionnier de l'automatisation PC-based. TwinCAT 3 offre une puissance de calcul in\u00e9gal\u00e9e.", produit_phare: "CX + TwinCAT 3", protocoles: ["BACnet", "Modbus", "KNX", "EtherCAT", "IP"], budget: "moyen", budget_label: "\u20ac\u20ac \u2014 Interm\u00e9diaire", site: "https://www.beckhoff.com/fr-fr/", batiments: ["moyen", "grand"], scores: { facilite_installation: 4, rapport_qualite_prix: 7, fonctionnalites: 8, support_france: 6, innovation: 9, interoperabilite: 9 }, forces: ["Performances \u00e9lev\u00e9es", "TwinCAT 3 puissant", "Multi-protocoles natif"], faiblesses: ["Courbe d'apprentissage \u00e9lev\u00e9e", "Pas de supervision d\u00e9di\u00e9e", "Orient\u00e9 industrie"], ideal_pour: ["Projets haute performance", "Industrie + b\u00e2timent"] },
        { nom: "Loytec", sigle: "LY", pays: "Autriche", couleur: "#00843D", categorie: "europeen", categorie_label: "Europ\u00e9en sp\u00e9cialis\u00e9", note: 7, description: "Sp\u00e9cialiste autrichien des passerelles multi-protocoles. Solution de choix pour int\u00e9grer des syst\u00e8mes h\u00e9t\u00e9rog\u00e8nes.", produit_phare: "L-INX Automation Servers + L-VIS", protocoles: ["BACnet", "LON", "KNX", "Modbus", "DALI", "IP"], budget: "moyen", budget_label: "\u20ac\u20ac \u2014 Interm\u00e9diaire", site: "https://www.loytec.com/", batiments: ["moyen", "grand"], scores: { facilite_installation: 5, rapport_qualite_prix: 7, fonctionnalites: 7, support_france: 5, innovation: 7, interoperabilite: 10 }, forces: ["Interop\u00e9rabilit\u00e9 maximale", "Passerelles multi-protocoles", "\u00c9crans tactiles int\u00e9gr\u00e9s"], faiblesses: ["Peu connu en France", "Support local limit\u00e9", "Pas de solution cloud avanc\u00e9e"], ideal_pour: ["Int\u00e9gration multi-protocoles", "B\u00e2timents h\u00e9t\u00e9rog\u00e8nes"] },
      ],

      filteredBrands() {
        let result = this.brands.filter(b => {
          if (this.filterCategory !== 'all' && b.categorie !== this.filterCategory) return false;
          if (this.filterProtocol !== 'all' && !b.protocoles.some(p => p.toLowerCase().includes(this.filterProtocol.toLowerCase()))) return false;
          if (this.filterBuilding !== 'all' && !b.batiments.includes(this.filterBuilding)) return false;
          if (this.filterBudget !== 'all' && b.budget !== this.filterBudget) return false;
          return true;
        });
        if (this.sortBy === 'nom') result.sort((a, b) => a.nom.localeCompare(b.nom));
        else if (this.sortBy === 'note') result.sort((a, b) => b.note - a.note);
        else if (this.sortBy === 'prix') { const o = {bas:1,moyen:2,eleve:3}; result.sort((a, b) => o[a.budget] - o[b.budget]); }
        else if (this.sortBy === 'facilite') result.sort((a, b) => b.scores.facilite_installation - a.scores.facilite_installation);
        return result;
      },

      resetFilters() { this.filterCategory = 'all'; this.filterProtocol = 'all'; this.filterBuilding = 'all'; this.filterBudget = 'all'; this.sortBy = 'note'; }
    }));
  });
</script>
@endpush
