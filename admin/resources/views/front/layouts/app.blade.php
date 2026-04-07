<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="@yield('description', 'NeoGTB — Le tiers de confiance indépendant de la GTB en France')" />
  <meta name="author" content="Ulrich Calmo — NeoGTB" />
  <meta name="theme-color" content="#0F172A" />
  @hasSection('noindex')<meta name="robots" content="noindex, nofollow" />@endif
  <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
  <link rel="icon" href="/favicon.ico" sizes="32x32" />

  {{-- Schema.org Organization + LocalBusiness --}}
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@type": ["Organization", "LocalBusiness"],
    "name": "NeoGTB",
    "alternateName": "EYNOR",
    "url": "https://neogtb.fr",
    "logo": "https://neogtb.fr/images/logo-neogtb.webp",
    "image": "https://neogtb.fr/images/og-neogtb.png",
    "description": "Conseil indépendant en Gestion Technique du Bâtiment (GTB). Diagnostic gratuit, comparateur de solutions, accompagnement décret BACS.",
    "founder": { "@@type": "Person", "name": "Ulrich Calmo", "jobTitle": "Créateur de la marque NeoGTB" },
    "address": { "@@type": "PostalAddress", "addressLocality": "Eysines", "addressRegion": "Nouvelle-Aquitaine", "postalCode": "33320", "addressCountry": "FR" },
    "areaServed": { "@@type": "Country", "name": "France" },
    "knowsAbout": ["GTB", "GTC", "BACnet", "KNX", "Modbus", "LON", "DALI", "MQTT", "EN ISO 52120-1", "Décret BACS", "Smart Building", "GMAO", "Hypervision"],
    "sameAs": ["https://www.linkedin.com/in/ulrich-calmo"]
  }
  </script>

  @yield('json_ld')

  {{-- Plausible Analytics — hébergé UE, sans cookies, exempt de consentement CNIL --}}
  <script defer data-domain="neogtb.fr" src="https://plausible.io/js/script.js"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet" />

  <title>@yield('title', 'NeoGTB — Gestion Technique du Bâtiment') — NeoGTB</title>

  {{-- Open Graph --}}
  <meta property="og:type" content="@yield('og_type', 'website')" />
  <meta property="og:site_name" content="NeoGTB" />
  <meta property="og:title" content="@yield('title', 'NeoGTB — Gestion Technique du Bâtiment') — NeoGTB" />
  <meta property="og:description" content="@yield('description', 'NeoGTB — Le tiers de confiance indépendant de la GTB en France')" />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:image" content="@yield('og_image', 'https://neogtb.fr/images/og-neogtb.png')" />
  <meta property="og:locale" content="fr_FR" />

  {{-- Twitter Card --}}
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="@yield('title', 'NeoGTB — Gestion Technique du Bâtiment') — NeoGTB" />
  <meta name="twitter:description" content="@yield('description', 'NeoGTB — Le tiers de confiance indépendant de la GTB en France')" />
  <meta name="twitter:image" content="@yield('og_image', 'https://neogtb.fr/images/og-neogtb.png')" />

  {{-- CSRF token for AJAX --}}
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  {{-- Canonical --}}
  <link rel="canonical" href="{{ url()->current() }}" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {50:'#e8eef5',100:'#c5d5e6',200:'#9bb5d1',300:'#7095bc',400:'#4a78a8',500:'#1B3A5C',600:'#183353',700:'#142b47',800:'#10233b',900:'#0c1b2f',950:'#08111f'},
            accent: {50:'#eaf5ee',100:'#d0e8d6',200:'#a3d4b2',300:'#6fbc88',400:'#4caf64',500:'#2D8B4E',600:'#267a43',700:'#1f6637',800:'#19532d',900:'#134023',950:'#0c2916'},
            dark: {50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a',950:'#020617'},
          },
          fontFamily: {
            sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
            heading: ['Plus Jakarta Sans', 'Inter', 'system-ui', 'sans-serif'],
          },
        }
      }
    }
  </script>

  <style>
    :root {
      --color-accent-50:  #eaf5ee;
      --color-accent-100: #d0e8d6;
      --color-accent-200: #a3d4b2;
      --color-accent-500: #2D8B4E;
      --color-accent-600: #267a43;
      --color-dark-50:    #f8fafc;
      --color-dark-100:   #f1f5f9;
      --color-dark-200:   #e2e8f0;
      --color-dark-300:   #cbd5e1;
      --color-dark-400:   #94a3b8;
      --color-dark-500:   #64748b;
      --color-dark-600:   #475569;
      --color-dark-700:   #334155;
      --color-dark-800:   #1e293b;
      --color-dark-900:   #0f172a;
      --color-primary-50: #e8eef5;
      --color-primary-500:#1B3A5C;
      --color-primary-600:#183353;
      --color-energy-500: #D97706;
      --color-energy-600: #B45309;
    }

    /* === NeoGTB Design System === */
    @keyframes fade-in-up { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
    @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 0 0 rgba(27, 58, 92, 0.3); } 50% { box-shadow: 0 0 20px 6px rgba(27, 58, 92, 0.15); } }

    .animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; }
    .animate-float { animation: float 4s ease-in-out infinite; }
    .animate-pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }

    .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1); }
    .card-hover-glow { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card-hover-glow:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -12px rgba(27, 58, 92, 0.15); border-color: #9bb5d1; }

    .btn-primary {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      color: #fff;
      background: linear-gradient(135deg, #2D8B4E, #267a43);
      border-radius: 8px;
      text-decoration: none;
      transition: all 0.15s ease;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #267a43, #1f6637);
      box-shadow: 0 4px 12px rgba(45, 139, 78, 0.25);
    }

    .btn-glow { transition: all 0.3s ease; }
    .btn-glow:hover { transform: translateY(-2px); box-shadow: 0 8px 24px -4px rgba(45, 139, 78, 0.4); }
    .btn-glow:active { transform: translateY(0); }

    .text-gradient { background: linear-gradient(135deg, #1B3A5C, #2D8B4E); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

    .section-divider { position: relative; }
    .section-divider::before { content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 3px; background: linear-gradient(90deg, #1B3A5C, #2D8B4E); border-radius: 2px; }

    .bg-grid-pattern { background-image: radial-gradient(circle, #e2e8f0 1px, transparent 1px); background-size: 24px 24px; }

    .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.2); }

    [x-cloak] { display: none !important; }
  </style>

  @stack('head')
</head>
<body class="min-h-screen bg-white text-dark-900 antialiased" style="font-family: 'Inter', system-ui, sans-serif;">

  {{-- Skip link --}}
  <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-accent-600 focus:text-white focus:rounded-lg focus:text-sm focus:font-medium">Aller au contenu principal</a>

  {{-- ===== NAV — Premium glassmorphism ===== --}}
  <header
    class="fixed top-0 w-full z-50 transition-all duration-200 ease-out"
    id="main-header"
    x-data="{ mobileOpen: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 }, { passive: true })"
    :class="scrolled ? 'bg-white/80 backdrop-blur-xl shadow-sm' : 'bg-white/0'"
    :style="scrolled ? 'border-bottom: 1px solid rgba(0,0,0,0.06)' : ''"
  >
    <nav class="max-w-[1280px] mx-auto px-6 md:px-10 flex items-center justify-between h-24 md:h-[120px]">
      {{-- Logo --}}
      <a href="/" class="flex items-center">
        <img src="/images/logo-neogtb.webp" alt="NeoGTB" class="h-20 md:h-[100px] w-auto" />
      </a>

      {{-- Desktop Nav --}}
      <div class="hidden lg:flex items-center gap-1">

        {{-- Dropdown Comprendre --}}
        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @keydown.escape="open = false">
          <button @click="open = !open" :aria-expanded="open" class="text-[14px] font-medium text-dark-500 hover:text-dark-900 transition-colors duration-200 flex items-center gap-1.5 px-4 py-2 rounded-lg hover:bg-dark-50 focus:ring-2 focus:ring-accent-500 focus:outline-none">
            Comprendre
            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl py-2 z-50 shadow-lg" style="border: 1px solid rgba(0,0,0,0.06);">
            <a href="/gtb" class="block px-4 py-2.5 text-[13px] transition-colors duration-150 {{ request()->is('gtb') ? 'text-accent-600 font-medium bg-accent-50' : 'text-dark-600 hover:text-dark-900 hover:bg-dark-50' }}">
              <span class="block font-medium">Qu'est-ce que la GTB ?</span>
              <span class="block text-[11px] text-dark-400 mt-0.5">Guide complet</span>
            </a>
            <a href="/gtc" class="block px-4 py-2.5 text-[13px] transition-colors duration-150 {{ request()->is('gtc') ? 'text-accent-600 font-medium bg-accent-50' : 'text-dark-600 hover:text-dark-900 hover:bg-dark-50' }}">
              <span class="block font-medium">Qu'est-ce que la GTC ?</span>
              <span class="block text-[11px] text-dark-400 mt-0.5">Supervision technique</span>
            </a>
            <a href="/solutions" class="block px-4 py-2.5 text-[13px] transition-colors duration-150 {{ request()->is('solutions') ? 'text-accent-600 font-medium bg-accent-50' : 'text-dark-600 hover:text-dark-900 hover:bg-dark-50' }}">
              <span class="block font-medium">Solutions & Technologies</span>
              <span class="block text-[11px] text-dark-400 mt-0.5">BACnet, KNX, Modbus</span>
            </a>
            <a href="/reglementation" class="block px-4 py-2.5 text-[13px] transition-colors duration-150 {{ request()->is('reglementation') ? 'text-accent-600 font-medium bg-accent-50' : 'text-dark-600 hover:text-dark-900 hover:bg-dark-50' }}">
              <span class="block font-medium">Réglementation</span>
              <span class="block text-[11px] text-dark-400 mt-0.5">BACS, tertiaire, RE2020</span>
            </a>
            <a href="/positionnement" class="block px-4 py-2.5 text-[13px] transition-colors duration-150 {{ request()->is('positionnement') ? 'text-accent-600 font-medium bg-accent-50' : 'text-dark-600 hover:text-dark-900 hover:bg-dark-50' }}">
              <span class="block font-medium">Pourquoi NeoGTB ?</span>
              <span class="block text-[11px] text-dark-400 mt-0.5">Notre positionnement</span>
            </a>
          </div>
        </div>

        {{-- Dropdown Outils --}}
        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @keydown.escape="open = false">
          <button @click="open = !open" :aria-expanded="open" class="text-[14px] font-medium text-dark-500 hover:text-dark-900 transition-colors duration-200 flex items-center gap-1.5 px-4 py-2 rounded-lg hover:bg-dark-50 focus:ring-2 focus:ring-accent-500 focus:outline-none">
            Outils
            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl py-2 z-50 shadow-lg" style="border: 1px solid rgba(0,0,0,0.06);">
            <a href="/audit" class="block px-4 py-2.5 text-[13px] transition-colors duration-150 {{ request()->is('audit') ? 'text-accent-600 font-medium bg-accent-50' : 'text-dark-600 hover:text-dark-900 hover:bg-dark-50' }}">
              <span class="block font-medium">Pré-diagnostic GTB</span>
              <span class="block text-[11px] text-dark-400 mt-0.5">Auto-évaluation ISO 52120-1</span>
            </a>
            <a href="/comparateur" class="block px-4 py-2.5 text-[13px] transition-colors duration-150 {{ request()->is('comparateur') ? 'text-accent-600 font-medium bg-accent-50' : 'text-dark-600 hover:text-dark-900 hover:bg-dark-50' }}">
              <span class="block font-medium">Comparateur objectif</span>
              <span class="block text-[11px] text-dark-400 mt-0.5">10+ fabricants</span>
            </a>
            <a href="/generateur-cee" class="block px-4 py-2.5 text-[13px] transition-colors duration-150 {{ request()->is('generateur-cee') ? 'text-accent-600 font-medium bg-accent-50' : 'text-dark-600 hover:text-dark-900 hover:bg-dark-50' }}">
              <span class="block font-medium">Générateur CEE</span>
              <span class="block text-[11px] text-dark-400 mt-0.5">Estimation en 3 min</span>
            </a>
          </div>
        </div>

        <a href="/blog" class="text-[14px] font-medium transition-colors duration-200 px-4 py-2 rounded-lg {{ request()->is('blog*') ? 'text-accent-600 bg-accent-50' : 'text-dark-500 hover:text-dark-900 hover:bg-dark-50' }}">Perspectives</a>
        <a href="/about" class="text-[14px] font-medium transition-colors duration-200 px-4 py-2 rounded-lg {{ request()->is('about') ? 'text-accent-600 bg-accent-50' : 'text-dark-500 hover:text-dark-900 hover:bg-dark-50' }}">À propos</a>
        <a href="/faq" class="text-[14px] font-medium transition-colors duration-200 px-4 py-2 rounded-lg {{ request()->is('faq') ? 'text-accent-600 bg-accent-50' : 'text-dark-500 hover:text-dark-900 hover:bg-dark-50' }}">FAQ</a>
      </div>

      {{-- CTA + Mobile toggle --}}
      <div class="flex items-center gap-3">
        <a href="/audit" class="hidden lg:inline-flex btn-primary text-[13px] px-5 py-2.5">
          Pré-diagnostic gratuit
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>

        {{-- Hamburger --}}
        <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg hover:bg-dark-50 transition-colors" aria-label="Menu">
          <svg x-show="!mobileOpen" class="w-5 h-5 text-dark-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h12M4 18h16" /></svg>
          <svg x-show="mobileOpen" class="w-5 h-5 text-dark-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>
    </nav>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
      class="lg:hidden bg-white/95 backdrop-blur-xl px-6 pb-6 shadow-lg" style="border-top: 1px solid rgba(0,0,0,0.06);">
      <div class="flex flex-col gap-1 py-3">
        <span class="text-[10px] font-medium uppercase tracking-wider text-dark-400 px-3 pt-3 pb-1">Comprendre</span>
        <a href="/gtb" @click="mobileOpen = false" class="text-[14px] text-dark-600 hover:text-dark-900 px-3 py-2.5 rounded-lg transition-colors hover:bg-dark-50">Qu'est-ce que la GTB ?</a>
        <a href="/gtc" @click="mobileOpen = false" class="text-[14px] text-dark-600 hover:text-dark-900 px-3 py-2.5 rounded-lg transition-colors hover:bg-dark-50">Qu'est-ce que la GTC ?</a>
        <a href="/solutions" @click="mobileOpen = false" class="text-[14px] text-dark-600 hover:text-dark-900 px-3 py-2.5 rounded-lg transition-colors hover:bg-dark-50">Solutions & Technologies</a>
        <a href="/reglementation" @click="mobileOpen = false" class="text-[14px] text-dark-600 hover:text-dark-900 px-3 py-2.5 rounded-lg transition-colors hover:bg-dark-50">Réglementation</a>
        <a href="/positionnement" @click="mobileOpen = false" class="text-[14px] text-dark-600 hover:text-dark-900 px-3 py-2.5 rounded-lg transition-colors hover:bg-dark-50">Pourquoi NeoGTB ?</a>

        <span class="text-[10px] font-medium uppercase tracking-wider text-dark-400 px-3 pt-4 pb-1">Outils</span>
        <a href="/audit" @click="mobileOpen = false" class="text-[14px] text-dark-600 hover:text-dark-900 px-3 py-2.5 rounded-lg transition-colors hover:bg-dark-50">Pré-diagnostic GTB</a>
        <a href="/comparateur" @click="mobileOpen = false" class="text-[14px] text-dark-600 hover:text-dark-900 px-3 py-2.5 rounded-lg transition-colors hover:bg-dark-50">Comparateur objectif</a>
        <a href="/generateur-cee" @click="mobileOpen = false" class="text-[14px] text-dark-600 hover:text-dark-900 px-3 py-2.5 rounded-lg transition-colors hover:bg-dark-50">Générateur CEE</a>

        <div class="my-2 h-px bg-dark-100"></div>
        <a href="/blog" @click="mobileOpen = false" class="text-[14px] text-dark-600 hover:text-dark-900 px-3 py-2.5 rounded-lg transition-colors hover:bg-dark-50">Perspectives</a>
        <a href="/about" @click="mobileOpen = false" class="text-[14px] text-dark-600 hover:text-dark-900 px-3 py-2.5 rounded-lg transition-colors hover:bg-dark-50">À propos</a>
        <a href="/faq" @click="mobileOpen = false" class="text-[14px] text-dark-600 hover:text-dark-900 px-3 py-2.5 rounded-lg transition-colors hover:bg-dark-50">FAQ</a>
        <a href="/audit" @click="mobileOpen = false" class="btn-primary text-center justify-center mt-2 text-[14px] px-5 py-3">Pré-diagnostic gratuit</a>
      </div>
    </div>
  </header>

  {{-- ===== MAIN CONTENT ===== --}}
  <main id="main-content" class="pt-24 md:pt-[120px]">
    {{-- Breadcrumbs --}}
    @hasSection('breadcrumbs')
      <nav aria-label="Fil d'Ariane" class="max-w-[1200px] mx-auto px-6 md:px-10 py-3">
        <ol style="display: flex; align-items: center; gap: 6px; list-style: none; margin: 0; padding: 0; font-size: 12px; color: #94a3b8;">
          @yield('breadcrumbs')
        </ol>
      </nav>
    @endif

    @yield('content')
  </main>

  {{-- ===== FOOTER — Premium 4 colonnes ===== --}}
  <footer style="background: #fff; border-top: 0.5px solid #e2e8f0;">
    <div class="max-w-[1280px] mx-auto px-6 md:px-10 py-16">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-10">

        {{-- Brand + Newsletter --}}
        <div class="md:col-span-5">
          <img src="/images/logo-neogtb.webp" alt="NeoGTB" class="h-16 w-auto" loading="lazy" decoding="async" />
          <p class="mt-5 text-[14px] text-dark-500 max-w-md" style="line-height: 1.7;">
            Le tiers de confiance indépendant de la Gestion Technique du Bâtiment en France. Aucun lien commercial avec les fabricants.
          </p>

          {{-- Newsletter --}}
          <div class="mt-8">
            <p class="text-[11px] font-medium uppercase tracking-wider text-dark-400 mb-3">Veille GTB mensuelle</p>
            <form
              method="POST"
              action="/newsletter"
              x-data="{ nlSending: false, nlSent: false, nlError: '' }"
              @submit.prevent="
                nlSending = true;
                nlError = '';
                const email = new FormData($el).get('email');
                fetch('/newsletter', {
                  method: 'POST',
                  body: JSON.stringify({ email }),
                  headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '' }
                })
                  .then(r => r.json().then(d => ({ ok: r.ok, data: d })))
                  .then(({ ok, data }) => { nlSending = false; if (ok) { nlSent = true; } else { nlError = data.error || 'Erreur, réessayez.'; } })
                  .catch(() => { nlSending = false; nlError = 'Erreur réseau, réessayez.'; });
              "
            >
              @csrf
              <div class="flex gap-2" x-show="!nlSent">
                <input type="email" name="email" placeholder="votre@email.com" required class="flex-1 text-[14px] px-4 py-2.5 rounded-lg text-dark-900 placeholder-dark-400 outline-none focus:ring-2 focus:ring-accent-500/40 transition-shadow" style="border: 0.5px solid #e2e8f0; background: #f8fafc;" />
                <button type="submit" :disabled="nlSending" class="text-[13px] font-medium px-5 py-2.5 rounded-lg text-white transition-all duration-200 hover:shadow-lg hover:shadow-accent-500/20" style="background: linear-gradient(135deg, #2D8B4E, #267a43);">
                  <span x-show="!nlSending">S'inscrire</span>
                  <span x-show="nlSending">...</span>
                </button>
              </div>
              <div x-show="nlSent" x-cloak class="text-[13px] text-accent-500 font-medium">Un email de confirmation vous a été envoyé. Cliquez sur le lien pour valider votre inscription.</div>
              <p x-show="nlError" x-text="nlError" x-cloak class="text-[12px] text-red-500 mt-1"></p>
              <label x-show="!nlSent" class="mt-2 flex items-start gap-2 cursor-pointer">
                <input type="checkbox" required class="mt-0.5 w-3.5 h-3.5 rounded text-accent-500 focus:ring-accent-500/40" />
                <span class="text-[11px] text-dark-400" style="line-height: 1.5;">J'accepte de recevoir la veille GTB mensuelle. <a href="/politique-de-confidentialite" class="underline hover:text-dark-700">Confidentialité</a></span>
              </label>
            </form>
            <p class="mt-2 text-[11px] text-dark-400">1 email/mois. Désabonnement en 1 clic.</p>
          </div>

          {{-- Normes badges --}}
          <div class="mt-6 flex flex-wrap gap-2">
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid #e2e8f0;">ISO 52120-1</span>
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid #e2e8f0;">Décret BACS</span>
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid #e2e8f0;">RE2020</span>
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid #e2e8f0;">CEE BAT-TH-116</span>
          </div>
        </div>

        {{-- Navigation --}}
        <div class="md:col-span-2 md:col-start-7">
          <p class="text-[11px] font-medium uppercase tracking-wider text-dark-400 mb-4">Navigation</p>
          <ul class="space-y-3">
            <li><a href="/gtb" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">GTB</a></li>
            <li><a href="/gtc" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">GTC</a></li>
            <li><a href="/solutions" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">Solutions</a></li>
            <li><a href="/comparateur" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">Comparateur</a></li>
            <li><a href="/reglementation" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">Réglementation</a></li>
            <li><a href="/blog" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">Perspectives</a></li>
          </ul>
        </div>

        {{-- Outils --}}
        <div class="md:col-span-2">
          <p class="text-[11px] font-medium uppercase tracking-wider text-dark-400 mb-4">Outils</p>
          <ul class="space-y-3">
            <li><a href="/audit" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">Pré-diagnostic GTB</a></li>
            <li><a href="/generateur-cee" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">Générateur CEE</a></li>
            <li><a href="/contact" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">Contact</a></li>
            <li><a href="/faq" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">FAQ</a></li>
          </ul>
        </div>

        {{-- Légal --}}
        <div class="md:col-span-2">
          <p class="text-[11px] font-medium uppercase tracking-wider text-dark-400 mb-4">Légal</p>
          <ul class="space-y-3">
            <li><a href="/mentions-legales" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">Mentions légales</a></li>
            <li><a href="/politique-de-confidentialite" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">Confidentialité</a></li>
            <li><a href="/mes-droits-rgpd" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">Vos droits RGPD</a></li>
          </ul>
        </div>
      </div>

      {{-- Bottom bar --}}
      <div class="mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4" style="border-top: 0.5px solid #e2e8f0;">
        <p class="text-[13px] text-dark-400">&copy; {{ date('Y') }} NeoGTB. Tous droits réservés.</p>
        <div class="flex items-center gap-5">
          {{-- LinkedIn --}}
          <a href="https://www.linkedin.com/in/ulrich-calmo" target="_blank" rel="noopener noreferrer" class="text-dark-400 hover:text-dark-900 transition-colors duration-200" aria-label="LinkedIn">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <button onclick="window.dispatchEvent(new CustomEvent('open-cookie-settings'))" class="text-[13px] text-dark-400 hover:text-dark-900 transition-colors duration-200 cursor-pointer">Gérer les cookies</button>
        </div>
      </div>
    </div>
  </footer>

  {{-- ===== Bandeau d'information cookies (purement informatif — Plausible cookieless, exempt CNIL) ===== --}}
  <div x-data="cookieNotice()" x-cloak>
    <div x-show="showBanner" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
      class="fixed bottom-0 left-0 right-0 z-[60] p-4">
      <div class="max-w-xl mx-auto bg-white/90 backdrop-blur-xl rounded-2xl p-6 shadow-2xl" style="border: 1px solid rgba(0,0,0,0.06);">
        <p class="text-[14px] font-medium text-dark-900 mb-1">Respect de votre vie privée</p>
        <p class="text-[13px] text-dark-500 mb-4" style="line-height: 1.6;">
          Ce site n'utilise <span class="font-medium text-dark-700">aucun cookie de tracking</span>.
          La mesure d'audience est assurée par <a href="https://plausible.io/data-policy" target="_blank" rel="noopener" class="text-accent-600 hover:text-accent-700 underline">Plausible Analytics</a> (sans cookies, hébergé en UE, exempt de consentement CNIL).
          Pour en savoir plus, consultez notre <a href="/politique-de-confidentialite" class="text-accent-600 hover:text-accent-700 underline">politique de confidentialité</a>.
        </p>
        <div class="flex items-center justify-end">
          <button @click="dismiss()" class="btn-primary text-[13px] px-4 py-2">J'ai compris</button>
        </div>
      </div>
    </div>
  </div>

  {{-- ===== Alpine.js (versions fixes 3.14.9) ===== --}}
  <script src="https://unpkg.com/@alpinejs/intersect@3.14.9/dist/cdn.min.js" defer></script>
  <script src="https://unpkg.com/@alpinejs/collapse@3.14.9/dist/cdn.min.js" defer></script>
  <script src="https://unpkg.com/alpinejs@3.14.9/dist/cdn.min.js" defer></script>

  <script>
    // Nav hide on scroll down, show on scroll up
    (function() {
      let lastY = 0;
      const header = document.getElementById('main-header');
      if (!header) return;
      window.addEventListener('scroll', () => {
        const y = window.scrollY;
        if (y > 80 && y > lastY) {
          header.style.transform = 'translateY(-100%)';
        } else {
          header.style.transform = 'translateY(0)';
        }
        lastY = y;
      }, { passive: true });
    })();

    // Bandeau d'information cookies (purement informatif — aucun cookie de tracking, Plausible exempt CNIL)
    document.addEventListener('alpine:init', () => {
      Alpine.data('cookieNotice', () => ({
        showBanner: false,

        init() {
          const dismissed = this.getCookie('neogtb_notice_dismissed');
          if (!dismissed) {
            setTimeout(() => { this.showBanner = true; }, 800);
          }
          window.addEventListener('open-cookie-settings', () => { this.showBanner = true; });
        },

        dismiss() {
          this.setCookie('neogtb_notice_dismissed', '1', 395);
          this.showBanner = false;
        },

        setCookie(name, value, days) {
          const d = new Date();
          d.setTime(d.getTime() + (days * 86400000));
          document.cookie = name + '=' + encodeURIComponent(value) + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax;Secure';
        },

        getCookie(name) {
          const v = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
          return v ? decodeURIComponent(v.pop()) : null;
        },
      }));
    });
  </script>

  @stack('scripts')

  {{-- Brick editor preview bridge (only when loaded in iframe with ?preview=1) --}}
  @if(request()->query('preview') == '1')
  <script>
      (function() {
          if (window.parent === window) return;
          window.addEventListener('message', function(event) {
              if (event.data && event.data.type === 'brick-updated') {
                  // Soft reload : just refresh the iframe
                  window.location.reload();
              }
          });
          window.parent.postMessage({ type: 'preview-ready', pageId: {{ $page->id ?? 'null' }} }, '*');
      })();
  </script>
  @endif
</body>
</html>
