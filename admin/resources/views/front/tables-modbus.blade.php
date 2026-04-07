@extends('front.layouts.app')

@section('title', "Tables d'adressage Modbus — Catalogue technique GTB — NeoGTB")
@section('description', "Catalogue technique des registres Modbus pour 19 équipements GTB courants : compteurs, PAC, CTA, chaudières, sondes, vannes, éclairage. Données indicatives à vérifier auprès du fabricant.")

@push('head')
<style>[x-cloak]{display:none !important;}</style>
@endpush

@section('content')

  {{-- Hero --}}
  <section class="relative overflow-hidden bg-gradient-to-br from-indigo-950 to-indigo-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center relative z-10">
      <span class="inline-block text-[11px] font-semibold uppercase tracking-[0.12em] text-indigo-200 mb-4">Catalogue technique</span>
      <h1 class="text-4xl md:text-5xl font-medium text-white">
        Tables d'adressage Modbus — Catalogue technique
      </h1>
      <p class="mt-5 text-lg max-w-3xl mx-auto text-indigo-100/90">
        19 équipements référencés, 7 catégories — données indicatives à vérifier auprès du fabricant
      </p>
    </div>
  </section>

  {{-- Disclaimer --}}
  <section class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="rounded-xl p-5 border border-amber-200 bg-amber-50">
        <p class="text-sm text-amber-900">
          <strong>⚠️ Données indicatives</strong> — Vérifiez toujours la documentation fabricant à jour avant intégration. Les adresses, fonctions et plages de registres peuvent varier selon le firmware, le modèle exact et la version du protocole.
        </p>
      </div>
    </div>
  </section>

  {{-- Section explicative dépliable --}}
  <section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-xl p-6 border border-slate-200" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center justify-between w-full text-left">
          <div>
            <p class="text-base font-semibold text-slate-900">Comprendre les 4 types de registres Modbus</p>
            <p class="text-xs text-slate-500 mt-0.5">Coils, Discrete Inputs, Input Registers, Holding Registers</p>
          </div>
          <svg :class="open && 'rotate-180'" class="w-5 h-5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div x-show="open" x-collapse>
          <div class="mt-6 pt-6 border-t border-slate-200 grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="rounded-lg p-4 border border-slate-200 bg-slate-50">
              <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex w-8 h-8 items-center justify-center rounded-md bg-indigo-100 text-indigo-700 text-sm font-bold">C</span>
                <p class="font-semibold text-slate-900 text-sm">Coils</p>
              </div>
              <p class="text-xs text-slate-500 mb-1">Plage : 0xxxx (00001-09999)</p>
              <p class="text-xs text-slate-500 mb-2">Fonctions : 01 (lire), 05 / 15 (écrire)</p>
              <p class="text-xs text-slate-600">Sortie TOR (1 bit) — lecture / écriture. Ex : commande relais, marche/arrêt.</p>
            </div>
            <div class="rounded-lg p-4 border border-slate-200 bg-slate-50">
              <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex w-8 h-8 items-center justify-center rounded-md bg-emerald-100 text-emerald-700 text-sm font-bold">DI</span>
                <p class="font-semibold text-slate-900 text-sm">Discrete Inputs</p>
              </div>
              <p class="text-xs text-slate-500 mb-1">Plage : 1xxxx (10001-19999)</p>
              <p class="text-xs text-slate-500 mb-2">Fonction : 02 (lire)</p>
              <p class="text-xs text-slate-600">Entrée TOR (1 bit) — lecture seule. Ex : contact d'état, défaut, position.</p>
            </div>
            <div class="rounded-lg p-4 border border-slate-200 bg-slate-50">
              <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex w-8 h-8 items-center justify-center rounded-md bg-amber-100 text-amber-700 text-sm font-bold">IR</span>
                <p class="font-semibold text-slate-900 text-sm">Input Registers</p>
              </div>
              <p class="text-xs text-slate-500 mb-1">Plage : 3xxxx (30001-39999)</p>
              <p class="text-xs text-slate-500 mb-2">Fonction : 04 (lire)</p>
              <p class="text-xs text-slate-600">Entrée analogique 16 bits — lecture seule. Ex : mesure capteur, valeur instantanée.</p>
            </div>
            <div class="rounded-lg p-4 border border-slate-200 bg-slate-50">
              <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex w-8 h-8 items-center justify-center rounded-md bg-rose-100 text-rose-700 text-sm font-bold">HR</span>
                <p class="font-semibold text-slate-900 text-sm">Holding Registers</p>
              </div>
              <p class="text-xs text-slate-500 mb-1">Plage : 4xxxx (40001-49999)</p>
              <p class="text-xs text-slate-500 mb-2">Fonctions : 03 (lire), 06 / 16 (écrire)</p>
              <p class="text-xs text-slate-600">Registre 16 bits — lecture / écriture. Ex : consigne, paramètre, compteur d'énergie.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Catalogue interactif --}}
  <section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="modbusCatalogue()">

      {{-- Filtres --}}
      <div class="bg-white rounded-2xl p-6 mb-8 border border-slate-200 sticky top-20 z-30">
        <div class="flex flex-col gap-4">
          <div>
            <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Recherche</label>
            <input type="text" x-model="search" placeholder="Nom équipement, fournisseur, catégorie..." class="w-full px-4 py-2.5 rounded-lg text-sm border border-slate-200 outline-none focus:ring-2 focus:ring-indigo-500/40" />
          </div>
          <div>
            <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">Filtres rapides</label>
            <div class="flex flex-wrap gap-2">
              <button @click="resetFilters()" class="px-3 py-1.5 rounded-full text-xs font-medium border border-slate-200 hover:bg-slate-50">Tout afficher</button>
              <button @click="filterCategory='Compteurs'" class="px-3 py-1.5 rounded-full text-xs font-medium border border-slate-200 hover:bg-slate-50">Compteurs d'énergie</button>
              <button @click="filterCategory='PAC/Froid'" class="px-3 py-1.5 rounded-full text-xs font-medium border border-slate-200 hover:bg-slate-50">PAC / Groupes froid</button>
              <button @click="filterCategory='Vannes/Pompes'" class="px-3 py-1.5 rounded-full text-xs font-medium border border-slate-200 hover:bg-slate-50">Vannes / Pompes</button>
              <button @click="filterFournisseur='Schneider'" class="px-3 py-1.5 rounded-full text-xs font-medium border border-slate-200 hover:bg-slate-50">Schneider</button>
              <button @click="filterFournisseur='Siemens'" class="px-3 py-1.5 rounded-full text-xs font-medium border border-slate-200 hover:bg-slate-50">Siemens</button>
            </div>
          </div>
          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Catégorie</label>
              <select x-model="filterCategory" class="w-full px-3 py-2 rounded-lg text-sm border border-slate-200 bg-white outline-none">
                <option value="all">Toutes les catégories</option>
                <template x-for="cat in categories" :key="cat">
                  <option :value="cat" x-text="cat"></option>
                </template>
              </select>
            </div>
            <div>
              <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Fournisseur</label>
              <select x-model="filterFournisseur" class="w-full px-3 py-2 rounded-lg text-sm border border-slate-200 bg-white outline-none">
                <option value="all">Tous les fournisseurs</option>
                <template x-for="f in fournisseurs" :key="f">
                  <option :value="f" x-text="f"></option>
                </template>
              </select>
            </div>
          </div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-500">
          <span x-text="filteredEquipements().length"></span> équipement(s) affiché(s) sur <span x-text="equipements.length"></span>
        </div>
      </div>

      {{-- Grid équipements --}}
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        <template x-for="(eq, idx) in filteredEquipements()" :key="idx">
          <button @click="openModal(eq)" class="text-left bg-white rounded-xl p-5 border border-slate-200 hover:border-indigo-300 hover:shadow-md transition-all">
            <div class="flex items-start justify-between mb-3">
              <span class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700" x-text="eq.categorie"></span>
              <span class="text-[11px] text-slate-400" x-text="eq.protocole"></span>
            </div>
            <p class="font-semibold text-slate-900 text-base" x-text="eq.nom"></p>
            <p class="text-xs text-slate-500 mt-0.5" x-text="eq.fournisseur"></p>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
              <span class="text-[11px] text-slate-500"><span x-text="eq.registres.length"></span> registres</span>
              <span class="text-[11px] font-semibold text-indigo-600">Voir détails →</span>
            </div>
          </button>
        </template>
      </div>

      <div x-show="filteredEquipements().length === 0" class="text-center py-12 text-slate-500 text-sm">
        Aucun équipement ne correspond à vos filtres.
      </div>

      {{-- CTA --}}
      <div class="mt-12 rounded-2xl p-8 text-center bg-gradient-to-br from-indigo-950 to-indigo-900">
        <p class="text-white text-xl font-semibold">Équipement non listé ?</p>
        <p class="text-indigo-100/90 text-sm mt-2 max-w-xl mx-auto">
          Nous enrichissons régulièrement le catalogue. Indiquez-nous la marque et le modèle qui vous manquent et nous l'ajouterons.
        </p>
        <a href="/contact?sujet=Modbus" class="inline-flex items-center gap-2 mt-5 px-6 py-3 rounded-lg bg-white text-indigo-900 text-sm font-semibold hover:bg-indigo-50 transition">
          Demander un ajout
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>

      {{-- Modal détail --}}
      <div x-show="modalOpen" x-cloak @keydown.escape.window="closeModal()" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60" @click.self="closeModal()">
        <div x-show="modalOpen" x-transition class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col">
          <template x-if="selectedEq">
            <div class="flex flex-col h-full overflow-hidden">
              <div class="px-6 py-5 border-b border-slate-200 flex items-start justify-between">
                <div>
                  <span class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700" x-text="selectedEq.categorie"></span>
                  <p class="mt-2 text-xl font-semibold text-slate-900" x-text="selectedEq.nom"></p>
                  <p class="text-sm text-slate-500" x-text="selectedEq.fournisseur"></p>
                </div>
                <button @click="closeModal()" class="text-slate-400 hover:text-slate-700 p-1">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
              </div>
              <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 grid grid-cols-3 gap-4 text-xs">
                <div>
                  <p class="text-slate-400 uppercase tracking-wider font-semibold mb-1">Protocole</p>
                  <p class="text-slate-900 font-medium" x-text="selectedEq.protocole"></p>
                </div>
                <div>
                  <p class="text-slate-400 uppercase tracking-wider font-semibold mb-1">Baudrate</p>
                  <p class="text-slate-900 font-medium" x-text="selectedEq.baudrate"></p>
                </div>
                <div>
                  <p class="text-slate-400 uppercase tracking-wider font-semibold mb-1">Slave ID par défaut</p>
                  <p class="text-slate-900 font-medium" x-text="selectedEq.slave_id_default"></p>
                </div>
              </div>
              <div class="flex-1 overflow-auto p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Registres</p>
                <div class="overflow-x-auto">
                  <table class="w-full text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider">
                      <tr>
                        <th class="text-left px-3 py-2 font-semibold">Adresse</th>
                        <th class="text-left px-3 py-2 font-semibold">Fonction</th>
                        <th class="text-left px-3 py-2 font-semibold">Type</th>
                        <th class="text-left px-3 py-2 font-semibold">Description</th>
                        <th class="text-left px-3 py-2 font-semibold">Unité</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                      <template x-for="(r, i) in selectedEq.registres" :key="i">
                        <tr class="hover:bg-slate-50">
                          <td class="px-3 py-2 font-mono text-slate-900" x-text="r.adresse"></td>
                          <td class="px-3 py-2 font-mono text-slate-600" x-text="r.fonction"></td>
                          <td class="px-3 py-2 text-slate-600" x-text="r.type"></td>
                          <td class="px-3 py-2 text-slate-700" x-text="r.description"></td>
                          <td class="px-3 py-2 text-slate-500" x-text="r.unite"></td>
                        </tr>
                      </template>
                    </tbody>
                  </table>
                </div>
                <p class="mt-4 text-[11px] text-slate-400 italic">
                  Données indicatives — vérifiez la documentation officielle du constructeur avant tout paramétrage.
                </p>
              </div>
            </div>
          </template>
        </div>
      </div>

    </div>
  </section>

  {{-- Related pages --}}
  <section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-6">Pour aller plus loin</p>
      <div class="grid md:grid-cols-3 gap-5">
        <a href="/solutions" class="block bg-white rounded-xl p-6 border border-slate-200 hover:border-indigo-300 hover:shadow-md transition-all">
          <p class="font-semibold text-slate-900">Solutions & Technologies</p>
          <p class="text-sm text-slate-500 mt-1">Protocoles, capteurs et automates utilisés en GTB.</p>
        </a>
        <a href="/comparateur" class="block bg-white rounded-xl p-6 border border-slate-200 hover:border-indigo-300 hover:shadow-md transition-all">
          <p class="font-semibold text-slate-900">Comparateur GTB</p>
          <p class="text-sm text-slate-500 mt-1">10+ solutions GTB analysées objectivement.</p>
        </a>
        <a href="/audit" class="block bg-white rounded-xl p-6 border border-slate-200 hover:border-indigo-300 hover:shadow-md transition-all">
          <p class="font-semibold text-slate-900">Pré-diagnostic GTB</p>
          <p class="text-sm text-slate-500 mt-1">Auto-évaluation ISO 52120-1 en quelques minutes.</p>
        </a>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
<script>
  function modbusCatalogue() {
    return {
      search: '',
      filterCategory: 'all',
      filterFournisseur: 'all',
      modalOpen: false,
      selectedEq: null,
      categories: ['Compteurs','PAC/Froid','CTA','Chaudières','Sondes','Vannes/Pompes','Éclairage'],
      fournisseurs: ['ABB','Eastron','Carlo Gavazzi','Schneider','Socomec','Daikin','Ciat','Carrier','Atlantic','Siemens','Belimo','Danfoss','Wilo','Grundfos','Hager'],
      equipements: [
        { nom:'ABB B21', fournisseur:'ABB', categorie:'Compteurs', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:1, registres:[
          { adresse:'0x5B00', fonction:'FC03', type:'Float32', description:'Tension L1-N', unite:'V' },
          { adresse:'0x5B14', fonction:'FC03', type:'Float32', description:'Courant L1', unite:'A' },
          { adresse:'0x5B14', fonction:'FC03', type:'Float32', description:'Puissance active totale', unite:'kW' },
          { adresse:'0x5000', fonction:'FC03', type:'UInt64', description:'Énergie active importée', unite:'kWh' },
          { adresse:'0x5B2C', fonction:'FC03', type:'Float32', description:'Fréquence', unite:'Hz' },
        ]},
        { nom:'Eastron SDM630', fournisseur:'Eastron', categorie:'Compteurs', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:1, registres:[
          { adresse:'0x0000', fonction:'FC04', type:'Float32', description:'Tension L1', unite:'V' },
          { adresse:'0x0006', fonction:'FC04', type:'Float32', description:'Courant L1', unite:'A' },
          { adresse:'0x0034', fonction:'FC04', type:'Float32', description:'Puissance active totale', unite:'kW' },
          { adresse:'0x0048', fonction:'FC04', type:'Float32', description:'Énergie active totale', unite:'kWh' },
          { adresse:'0x0046', fonction:'FC04', type:'Float32', description:'Fréquence', unite:'Hz' },
          { adresse:'0x003E', fonction:'FC04', type:'Float32', description:'Facteur de puissance total', unite:'-' },
        ]},
        { nom:'Carlo Gavazzi EM340', fournisseur:'Carlo Gavazzi', categorie:'Compteurs', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:1, registres:[
          { adresse:'0x0000', fonction:'FC03', type:'Int32', description:'Tension L1-N', unite:'V (×0.1)' },
          { adresse:'0x000C', fonction:'FC03', type:'Int32', description:'Courant L1', unite:'A (×0.001)' },
          { adresse:'0x0028', fonction:'FC03', type:'Int32', description:'Puissance active totale', unite:'W (×0.1)' },
          { adresse:'0x0034', fonction:'FC03', type:'Int32', description:'Énergie active importée', unite:'kWh (×0.1)' },
        ]},
        { nom:'Schneider iEM3155', fournisseur:'Schneider', categorie:'Compteurs', protocole:'Modbus RTU', baudrate:'19200 8E1', slave_id_default:1, registres:[
          { adresse:'3000', fonction:'FC03', type:'Float32', description:'Tension L1-N', unite:'V' },
          { adresse:'3010', fonction:'FC03', type:'Float32', description:'Courant L1', unite:'A' },
          { adresse:'3060', fonction:'FC03', type:'Float32', description:'Puissance active totale', unite:'kW' },
          { adresse:'3204', fonction:'FC03', type:'Int64', description:'Énergie active importée', unite:'Wh' },
          { adresse:'3110', fonction:'FC03', type:'Float32', description:'Fréquence', unite:'Hz' },
        ]},
        { nom:'Socomec DIRIS A40', fournisseur:'Socomec', categorie:'Compteurs', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:5, registres:[
          { adresse:'0xC550', fonction:'FC03', type:'UInt32', description:'Tension simple L1', unite:'V (×100)' },
          { adresse:'0xC560', fonction:'FC03', type:'UInt32', description:'Courant L1', unite:'mA' },
          { adresse:'0xC568', fonction:'FC03', type:'Int32', description:'Puissance active totale', unite:'W (×0.01)' },
          { adresse:'0xC652', fonction:'FC03', type:'UInt64', description:'Énergie active partielle', unite:'Wh' },
          { adresse:'0xC55E', fonction:'FC03', type:'UInt32', description:'Fréquence', unite:'Hz (×100)' },
        ]},
        { nom:'Daikin EWAD-TZ', fournisseur:'Daikin', categorie:'PAC/Froid', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:1, registres:[
          { adresse:'40001', fonction:'FC03', type:'Int16', description:'Mode de fonctionnement', unite:'0/1/2' },
          { adresse:'40002', fonction:'FC03', type:'Int16', description:'Consigne eau glacée', unite:'°C (×10)' },
          { adresse:'40010', fonction:'FC04', type:'Int16', description:'Température eau retour', unite:'°C (×10)' },
          { adresse:'40011', fonction:'FC04', type:'Int16', description:'Température eau départ', unite:'°C (×10)' },
          { adresse:'40020', fonction:'FC04', type:'Int16', description:'État défaut général', unite:'0/1' },
          { adresse:'40030', fonction:'FC04', type:'Int16', description:'Charge compresseur 1', unite:'%' },
        ]},
        { nom:'Ciat Aquaciat Power', fournisseur:'Ciat', categorie:'PAC/Froid', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:1, registres:[
          { adresse:'40001', fonction:'FC03', type:'Int16', description:'Marche / Arrêt', unite:'0/1' },
          { adresse:'40002', fonction:'FC03', type:'Int16', description:'Consigne froid', unite:'°C (×10)' },
          { adresse:'40003', fonction:'FC03', type:'Int16', description:'Consigne chaud', unite:'°C (×10)' },
          { adresse:'40050', fonction:'FC04', type:'Int16', description:'Température eau départ', unite:'°C (×10)' },
          { adresse:'40060', fonction:'FC04', type:'Int16', description:'État alarme', unite:'0/1' },
        ]},
        { nom:'Carrier 30RB/RQ', fournisseur:'Carrier', categorie:'PAC/Froid', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:1, registres:[
          { adresse:'0x0000', fonction:'FC03', type:'Int16', description:'Commande Marche/Arrêt', unite:'0/1' },
          { adresse:'0x0001', fonction:'FC03', type:'Int16', description:'Consigne eau glacée', unite:'°C (×10)' },
          { adresse:'0x0010', fonction:'FC04', type:'Int16', description:'Température eau entrée', unite:'°C (×10)' },
          { adresse:'0x0011', fonction:'FC04', type:'Int16', description:'Température eau sortie', unite:'°C (×10)' },
          { adresse:'0x0020', fonction:'FC04', type:'Int16', description:'État machine', unite:'code' },
          { adresse:'0x0030', fonction:'FC04', type:'Int16', description:'Heures de fonctionnement', unite:'h' },
        ]},
        { nom:'Atlantic Alfea Excellia', fournisseur:'Atlantic', categorie:'PAC/Froid', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:10, registres:[
          { adresse:'40001', fonction:'FC03', type:'Int16', description:'Mode (Auto/Eco/Confort)', unite:'code' },
          { adresse:'40002', fonction:'FC03', type:'Int16', description:'Consigne ambiance', unite:'°C (×10)' },
          { adresse:'40010', fonction:'FC04', type:'Int16', description:'Température extérieure', unite:'°C (×10)' },
          { adresse:'40011', fonction:'FC04', type:'Int16', description:'Température départ chauffage', unite:'°C (×10)' },
          { adresse:'40020', fonction:'FC04', type:'Int16', description:'État compresseur', unite:'0/1' },
        ]},
        { nom:'Carrier 39HQ', fournisseur:'Carrier', categorie:'CTA', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:1, registres:[
          { adresse:'40001', fonction:'FC03', type:'Int16', description:'Marche/Arrêt CTA', unite:'0/1' },
          { adresse:'40002', fonction:'FC03', type:'Int16', description:'Consigne soufflage', unite:'°C (×10)' },
          { adresse:'40010', fonction:'FC04', type:'Int16', description:'Température reprise', unite:'°C (×10)' },
          { adresse:'40011', fonction:'FC04', type:'Int16', description:'Température soufflage', unite:'°C (×10)' },
          { adresse:'40020', fonction:'FC04', type:'Int16', description:'Vitesse ventilateur', unite:'%' },
          { adresse:'40030', fonction:'FC04', type:'Int16', description:'Position registre neuf', unite:'%' },
        ]},
        { nom:'Siemens Climatix C600', fournisseur:'Siemens', categorie:'CTA', protocole:'Modbus TCP', baudrate:'TCP/IP', slave_id_default:1, registres:[
          { adresse:'40001', fonction:'FC03', type:'Int16', description:'Mode CTA', unite:'code' },
          { adresse:'40002', fonction:'FC03', type:'Int16', description:'Consigne ambiance', unite:'°C (×10)' },
          { adresse:'40020', fonction:'FC04', type:'Int16', description:'Température soufflage', unite:'°C (×10)' },
          { adresse:'40021', fonction:'FC04', type:'Int16', description:'Température extraction', unite:'°C (×10)' },
          { adresse:'40030', fonction:'FC04', type:'Int16', description:'CO2 ambiance', unite:'ppm' },
          { adresse:'40040', fonction:'FC04', type:'Int16', description:'État alarme générale', unite:'0/1' },
        ]},
        { nom:'Atlantic Varmax', fournisseur:'Atlantic', categorie:'Chaudières', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:1, registres:[
          { adresse:'40001', fonction:'FC03', type:'Int16', description:'Marche/Arrêt brûleur', unite:'0/1' },
          { adresse:'40002', fonction:'FC03', type:'Int16', description:'Consigne départ', unite:'°C (×10)' },
          { adresse:'40010', fonction:'FC04', type:'Int16', description:'Température départ', unite:'°C (×10)' },
          { adresse:'40011', fonction:'FC04', type:'Int16', description:'Température retour', unite:'°C (×10)' },
          { adresse:'40020', fonction:'FC04', type:'Int16', description:'État brûleur', unite:'0/1' },
          { adresse:'40030', fonction:'FC04', type:'Int16', description:'Pression circuit', unite:'bar (×10)' },
        ]},
        { nom:'Siemens QPA2062', fournisseur:'Siemens', categorie:'Sondes', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:1, registres:[
          { adresse:'40001', fonction:'FC04', type:'Int16', description:'CO2 ambiance', unite:'ppm' },
          { adresse:'40002', fonction:'FC04', type:'Int16', description:'Température ambiance', unite:'°C (×10)' },
          { adresse:'40003', fonction:'FC04', type:'Int16', description:'Humidité relative', unite:'% (×10)' },
        ]},
        { nom:'Schneider SE8350', fournisseur:'Schneider', categorie:'Sondes', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:1, registres:[
          { adresse:'40001', fonction:'FC03', type:'Int16', description:'Consigne ambiance', unite:'°C (×10)' },
          { adresse:'40002', fonction:'FC04', type:'Int16', description:'Température mesurée', unite:'°C (×10)' },
          { adresse:'40003', fonction:'FC04', type:'Int16', description:'Humidité mesurée', unite:'% (×10)' },
          { adresse:'40010', fonction:'FC03', type:'Int16', description:'Mode (Occ/Inocc)', unite:'0/1' },
        ]},
        { nom:'Belimo EP015R', fournisseur:'Belimo', categorie:'Vannes/Pompes', protocole:'Modbus RTU', baudrate:'38400 8N1', slave_id_default:1, registres:[
          { adresse:'0x0001', fonction:'FC03', type:'UInt16', description:'Consigne position', unite:'% (×100)' },
          { adresse:'0x0006', fonction:'FC04', type:'UInt16', description:'Position relative actuelle', unite:'% (×100)' },
          { adresse:'0x0008', fonction:'FC04', type:'Int16', description:'Débit volumétrique', unite:'l/s (×10)' },
          { adresse:'0x0010', fonction:'FC04', type:'Int16', description:'Température eau', unite:'°C (×100)' },
          { adresse:'0x0014', fonction:'FC04', type:'UInt16', description:'Énergie cumulée', unite:'kWh' },
        ]},
        { nom:'Danfoss NovoCon', fournisseur:'Danfoss', categorie:'Vannes/Pompes', protocole:'Modbus RTU', baudrate:'38400 8N1', slave_id_default:1, registres:[
          { adresse:'0x0001', fonction:'FC03', type:'UInt16', description:'Consigne course vanne', unite:'% (×100)' },
          { adresse:'0x0010', fonction:'FC04', type:'UInt16', description:'Position vanne', unite:'% (×100)' },
          { adresse:'0x0020', fonction:'FC04', type:'Int16', description:'Débit', unite:'l/h' },
          { adresse:'0x0030', fonction:'FC04', type:'Int16', description:'Température départ', unite:'°C (×100)' },
          { adresse:'0x0031', fonction:'FC04', type:'Int16', description:'Température retour', unite:'°C (×100)' },
        ]},
        { nom:'Wilo Stratos MAXO', fournisseur:'Wilo', categorie:'Vannes/Pompes', protocole:'Modbus RTU', baudrate:'19200 8E1', slave_id_default:10, registres:[
          { adresse:'40001', fonction:'FC03', type:'UInt16', description:'Marche/Arrêt', unite:'0/1' },
          { adresse:'40002', fonction:'FC03', type:'UInt16', description:'Consigne hauteur', unite:'cm' },
          { adresse:'40010', fonction:'FC04', type:'UInt16', description:'Hauteur manométrique actuelle', unite:'cm' },
          { adresse:'40011', fonction:'FC04', type:'UInt16', description:'Débit', unite:'m³/h (×10)' },
          { adresse:'40012', fonction:'FC04', type:'UInt16', description:'Puissance électrique', unite:'W' },
          { adresse:'40020', fonction:'FC04', type:'UInt16', description:'État défaut', unite:'code' },
        ]},
        { nom:'Grundfos Magna3', fournisseur:'Grundfos', categorie:'Vannes/Pompes', protocole:'Modbus RTU', baudrate:'9600 8N1', slave_id_default:1, registres:[
          { adresse:'40001', fonction:'FC03', type:'UInt16', description:'Marche/Arrêt', unite:'0/1' },
          { adresse:'40002', fonction:'FC03', type:'UInt16', description:'Mode régulation', unite:'code' },
          { adresse:'40003', fonction:'FC03', type:'UInt16', description:'Consigne hauteur', unite:'dm' },
          { adresse:'40020', fonction:'FC04', type:'UInt16', description:'Débit instantané', unite:'m³/h (×100)' },
          { adresse:'40021', fonction:'FC04', type:'UInt16', description:'Puissance absorbée', unite:'W' },
          { adresse:'40030', fonction:'FC04', type:'UInt32', description:'Énergie consommée', unite:'kWh' },
        ]},
        { nom:'Hager TXA213A', fournisseur:'Hager', categorie:'Éclairage', protocole:'Modbus RTU (gateway KNX)', baudrate:'19200 8E1', slave_id_default:1, registres:[
          { adresse:'0x0001', fonction:'FC01', type:'Bit', description:'État sortie 1', unite:'0/1' },
          { adresse:'0x0001', fonction:'FC05', type:'Bit', description:'Commande sortie 1', unite:'0/1' },
          { adresse:'0x0010', fonction:'FC03', type:'UInt16', description:'Consigne gradation', unite:'%' },
          { adresse:'0x0020', fonction:'FC04', type:'UInt32', description:'Heures de fonctionnement', unite:'h' },
        ]},
      ],
      filteredEquipements() {
        const q = this.search.trim().toLowerCase();
        return this.equipements.filter(eq => {
          if (this.filterCategory !== 'all' && eq.categorie !== this.filterCategory) return false;
          if (this.filterFournisseur !== 'all' && eq.fournisseur !== this.filterFournisseur) return false;
          if (q) {
            const hay = (eq.nom + ' ' + eq.fournisseur + ' ' + eq.categorie).toLowerCase();
            if (!hay.includes(q)) return false;
          }
          return true;
        });
      },
      resetFilters() { this.search=''; this.filterCategory='all'; this.filterFournisseur='all'; },
      openModal(eq) { this.selectedEq=eq; this.modalOpen=true; document.body.style.overflow='hidden'; },
      closeModal() { this.modalOpen=false; this.selectedEq=null; document.body.style.overflow=''; }
    };
  }
</script>
@endpush
