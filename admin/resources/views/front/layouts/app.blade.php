<!DOCTYPE html>
<html lang="fr">
<head>
  @php($page = $page ?? null)
  @php($seoTitle = $page->meta_title ?? 'Conseil GTB indépendant & décret BACS 2027 | NeoGTB')
  @php($seoDescription = $page->meta_description ?? 'Tiers de confiance GTB. Pré-diagnostic ISO 52120-1 gratuit, comparateur indépendant, accompagnement décret BACS pour bâtiments tertiaires.')
  @php($seoOgImage = $page->og_image ?? '/images/og-neogtb.png')
  @php($seoOgImageAbs = \Illuminate\Support\Str::startsWith($seoOgImage, ['http://', 'https://']) ? $seoOgImage : url($seoOgImage))
  @php($seoUrl = url()->current())
  @php($seoBreadcrumbName = $page->title ?? $seoTitle)

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Ulrich Calmo — NeoGTB" />
  <meta name="theme-color" content="#0F172A" />
  @hasSection('noindex')<meta name="robots" content="noindex, nofollow" />@endif
  <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
  <link rel="icon" href="/favicon.ico" sizes="32x32" />

  <title>{{ $seoTitle }}</title>
  <meta name="description" content="{{ $seoDescription }}" />

  {{-- Canonical --}}
  <link rel="canonical" href="{{ $seoUrl }}" />

  {{-- Open Graph --}}
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="NeoGTB" />
  <meta property="og:title" content="{{ $seoTitle }}" />
  <meta property="og:description" content="{{ $seoDescription }}" />
  <meta property="og:url" content="{{ $seoUrl }}" />
  <meta property="og:image" content="{{ $seoOgImageAbs }}" />
  <meta property="og:locale" content="fr_FR" />

  {{-- Twitter Card --}}
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="{{ $seoTitle }}" />
  <meta name="twitter:description" content="{{ $seoDescription }}" />
  <meta name="twitter:image" content="{{ $seoOgImageAbs }}" />

  {{-- CSRF token for AJAX --}}
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  {{-- Schema.org Organization --}}
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@type": "Organization",
    "@@id": "https://neogtb.fr/#organization",
    "name": "NeoGTB",
    "url": "https://neogtb.fr",
    "logo": "https://neogtb.fr/images/logo-neogtb.webp",
    "sameAs": []
  }
  </script>

  {{-- Schema.org LocalBusiness --}}
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@type": "LocalBusiness",
    "@@id": "https://neogtb.fr/#localbusiness",
    "name": "NeoGTB",
    "url": "https://neogtb.fr",
    "image": "https://neogtb.fr/images/og-neogtb.png",
    "telephone": null,
    "priceRange": "€€",
    "address": {
      "@@type": "PostalAddress",
      "streetAddress": "",
      "addressLocality": "Eysines",
      "addressRegion": "Bordeaux",
      "postalCode": "33320",
      "addressCountry": "FR"
    },
    "areaServed": { "@@type": "Country", "name": "France" }
  }
  </script>

  {{-- Schema.org BreadcrumbList --}}
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@@type": "ListItem",
        "position": 1,
        "name": "Accueil",
        "item": "{{ url('/') }}"
      },
      {
        "@@type": "ListItem",
        "position": 2,
        "name": @json($seoBreadcrumbName),
        "item": "{{ $seoUrl }}"
      }
    ]
  }
  </script>

  @yield('json_ld')

  {{-- Plausible Analytics — hébergé UE, sans cookies, exempt de consentement CNIL --}}
  <script defer data-domain="neogtb.fr" src="https://plausible.io/js/script.js"></script>

  {{-- Tailwind v4 + design tokens NeoGTB + Alpine.js (self-hosted) compilés via Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  @stack('head')
</head>
<body class="min-h-screen bg-white text-dark-900 antialiased" style="font-family: 'Inter', system-ui, sans-serif;">

  {{-- Skip link --}}
  <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-accent-600 focus:text-white focus:rounded-lg focus:text-sm focus:font-medium">Aller au contenu principal</a>

  {{-- ===== NAV mega-menu ===== --}}
  @php
$exploreItems = [
  'comprendre' => [
    'label' => 'Comprendre',
    'items' => [
      ['href'=>'/gtb','title'=>"Qu'est-ce que la GTB ?",'desc'=>'Fondamentaux, normes EN 15232, niveaux','icon'=>'academic-cap','match'=>'gtb'],
      ['href'=>'/gtc','title'=>"Qu'est-ce que la GTC ?",'desc'=>'Supervision technique, différences avec GTB','icon'=>'computer-desktop','match'=>'gtc'],
      ['href'=>'/solutions','title'=>'Solutions & technologies','desc'=>'Protocoles BACnet, KNX, Modbus, LON','icon'=>'cpu-chip','match'=>'solutions'],
    ],
  ],
  'conformer' => [
    'label' => 'Se conformer',
    'items' => [
      ['href'=>'/reglementation','title'=>'Réglementation','desc'=>'Décret BACS, tertiaire, RE2020, calendrier 2026-2035','icon'=>'scale','match'=>'reglementation'],
      ['href'=>'/positionnement','title'=>'Pourquoi NeoGTB ?','desc'=>"Tiers de confiance indépendant, sans conflit d'intérêt",'icon'=>'shield-check','match'=>'positionnement'],
      ['href'=>'/faq','title'=>'FAQ','desc'=>'Questions fréquentes sur la conformité GTB','icon'=>'question-mark-circle','match'=>'faq'],
    ],
  ],
  'agir' => [
    'label' => 'Agir',
    'items' => [
      ['href'=>'/audit','title'=>'Pré-diagnostic GTB','desc'=>'Auto-évaluation ISO 52120-1, 7 min, gratuit','icon'=>'clipboard-document-check','match'=>'audit'],
      ['href'=>'/comparateur','title'=>'Comparateur objectif','desc'=>'10+ fabricants comparés sans biais commercial','icon'=>'arrows-right-left','match'=>'comparateur'],
      ['href'=>'/generateur-cee','title'=>'Générateur CEE','desc'=>'Estimation de votre prime CEE en 3 minutes','icon'=>'banknotes','match'=>'generateur-cee'],
      ['href'=>'/tables-modbus','title'=>'Tables Modbus','desc'=>'19 équipements GTB, référence technique','icon'=>'table-cells','match'=>'tables-modbus'],
    ],
  ],
];
  @endphp

  @php
$icons = [
      'academic-cap' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>',
      'computer-desktop' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"/>',
      'cpu-chip' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z"/>',
      'scale' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z"/>',
      'shield-check' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>',
      'question-mark-circle' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"/>',
      'clipboard-document-check' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75"/>',
      'arrows-right-left' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>',
      'banknotes' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V12Zm-12 0h.008v.008H6V12Z"/>',
      'table-cells' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0 1 18 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0 0c0 .621-.504 1.125-1.125 1.125M6 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0h1.125m-1.125 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 0 1 6 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621-.504 1.125-1.125 1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125m0 0h-1.5m1.5 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M19.125 12h-1.5m1.5 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h1.5m14.25 0h1.5"/>',
      'magnifying-glass' => '<path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>',
      'bars-3' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>',
      'x-mark' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>',
      'chevron-down' => '<path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>',
      'arrow-right' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>',
    ])

  <header
    class="fixed top-0 w-full z-50 transition-all duration-200 ease-out"
    id="main-header"
    x-data="neogtbNav()"
    x-init="init()"
    @keydown.escape.window="closeAll()"
    @click.outside="closeExplorer()"
    @scroll.window.passive="onScroll()"
    @resize.window="onResize()"
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
        {{-- Trigger Explorer --}}
        <button
          type="button"
          id="explorer-trigger"
          x-ref="trigger"
          @click="toggleExplorer()"
          @keydown.arrow-down.prevent="openExplorerAndFocus()"
          @mouseenter="hoverOpen()"
          @mouseleave="hoverClose()"
          :class="explorerOpen ? 'text-dark-900 bg-dark-50' : 'text-dark-500 hover:text-dark-900 hover:bg-dark-50'"
          :aria-expanded="explorerOpen.toString()"
          aria-haspopup="true"
          aria-controls="explorer-panel"
          class="text-[14px] font-medium transition-colors duration-200 flex items-center gap-1.5 px-4 py-2 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500 min-h-[44px]"
        >
          Explorer
          <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="explorerOpen && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons['chevron-down'] !!}</svg>
        </button>

        <a href="/blog" class="text-[14px] font-medium transition-colors duration-200 px-4 py-2 rounded-lg min-h-[44px] flex items-center {{ request()->is('blog*') ? 'text-accent-600 bg-accent-50' : 'text-dark-500 hover:text-dark-900 hover:bg-dark-50' }}" @if(request()->is('blog*')) aria-current="page" @endif>Perspectives</a>
        <a href="/about" class="text-[14px] font-medium transition-colors duration-200 px-4 py-2 rounded-lg min-h-[44px] flex items-center {{ request()->is('about') ? 'text-accent-600 bg-accent-50' : 'text-dark-500 hover:text-dark-900 hover:bg-dark-50' }}" @if(request()->is('about')) aria-current="page" @endif>À propos</a>
        <a href="/faq" class="text-[14px] font-medium transition-colors duration-200 px-4 py-2 rounded-lg min-h-[44px] flex items-center {{ request()->is('faq') ? 'text-accent-600 bg-accent-50' : 'text-dark-500 hover:text-dark-900 hover:bg-dark-50' }}" @if(request()->is('faq')) aria-current="page" @endif>FAQ</a>
        <a href="/contact" class="text-[14px] font-medium transition-colors duration-200 px-4 py-2 rounded-lg min-h-[44px] flex items-center {{ request()->is('contact') ? 'text-accent-600 bg-accent-50' : 'text-dark-500 hover:text-dark-900 hover:bg-dark-50' }}" @if(request()->is('contact')) aria-current="page" @endif>Contact</a>
      </div>

      {{-- CTA + search + Mobile toggle --}}
      <div class="flex items-center gap-2">
        <button type="button" aria-label="Rechercher" class="hidden lg:inline-flex items-center justify-center w-10 h-10 rounded-lg text-dark-500 hover:text-dark-900 hover:bg-dark-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons['magnifying-glass'] !!}</svg>
        </button>
        <a href="/audit" class="hidden lg:inline-flex btn-primary text-[13px] px-5 py-2.5">
          Pré-diagnostic gratuit
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        {{-- Hamburger --}}
        <button @click="openMobile()" class="lg:hidden p-2 rounded-lg hover:bg-dark-50 transition-colors min-w-[44px] min-h-[44px] flex items-center justify-center" aria-label="Ouvrir le menu" aria-controls="mobile-drawer" :aria-expanded="mobileOpen.toString()">
          <svg class="w-6 h-6 text-dark-700" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">{!! $icons['bars-3'] !!}</svg>
        </button>
      </div>
    </nav>

    {{-- ===== MEGA-MENU DESKTOP ===== --}}
    <div
      id="explorer-panel"
      role="region"
      aria-label="Menu Explorer"
      x-show="explorerOpen"
      x-cloak
      @mouseenter="hoverOpen()"
      @mouseleave="hoverClose()"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 -translate-y-2 scale-[0.98]"
      x-transition:enter-end="opacity-100 translate-y-0 scale-100"
      x-transition:leave="transition ease-in duration-[120ms]"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="hidden lg:block absolute left-0 right-0 top-full bg-white/95 backdrop-blur-2xl rounded-b-3xl shadow-[0_20px_60px_-20px_rgba(0,0,0,0.15)]"
      style="border-top: 1px solid rgba(0,0,0,0.06);"
    >
      <div class="max-w-[1280px] mx-auto px-6 md:px-10 py-10 grid grid-cols-4 gap-8">
        @foreach(['comprendre','conformer','agir'] as $colKey)
          @php $col = $exploreItems[$colKey]; @endphp
          <div>
            <h3 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-dark-400 mb-4 px-3">{{ $col['label'] }}</h3>
            <ul class="flex flex-col gap-1">
              @foreach($col['items'] as $it)
                @php $active = request()->is($it['match']); @endphp
                <li>
                  <a href="{{ $it['href'] }}"
                    @if($active) aria-current="page" @endif
                    class="group flex gap-3 px-3 py-3 rounded-xl transition-colors duration-200 ease-out focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-accent-500 min-h-[44px] {{ $active ? 'bg-accent-50 border-l-2 border-accent-600' : 'hover:bg-accent-50/60' }}">
                    <span class="shrink-0 mt-0.5 transition-transform duration-200 group-hover:translate-x-[2px]">
                      <svg class="w-5 h-5 {{ $active ? 'text-accent-600' : 'text-dark-400 group-hover:text-accent-600' }} transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">{!! $icons[$it['icon']] !!}</svg>
                    </span>
                    <span class="flex-1 min-w-0">
                      <span class="block text-[13px] {{ $active ? 'text-accent-700 font-semibold' : 'text-dark-900 font-medium group-hover:text-accent-700' }} transition-colors">{{ $it['title'] }}</span>
                      <span class="block text-[12px] text-dark-500 mt-0.5 leading-snug">{{ $it['desc'] }}</span>
                    </span>
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        @endforeach

        {{-- Col 4 — Spotlight --}}
        <div class="flex flex-col">
          <h3 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-dark-400 mb-4 px-3">Spotlight</h3>
          <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-accent-50 to-accent-100 border border-accent-100/60 flex-1 flex flex-col">
            <div class="aspect-[16/10] overflow-hidden bg-gradient-to-br from-accent-50 to-accent-100 flex items-center justify-center">
              <img src="/images/hero-audit.png" alt="" class="w-full h-full object-cover" loading="lazy" onerror="this.style.display='none'" />
            </div>
            <div class="p-5 flex flex-col gap-3">
              <h3 class="text-[15px] font-heading font-semibold text-dark-900 leading-snug">Diagnostic GTB en 7 minutes</h3>
              <p class="text-[12px] text-dark-600 leading-relaxed">Obtenez votre score ISO 52120-1 gratuitement et sans engagement.</p>
              <a href="/audit" class="btn-primary text-[12px] px-4 py-2 inline-flex items-center gap-1.5 self-start">
                Lancer le diagnostic
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons['arrow-right'] !!}</svg>
              </a>
            </div>
          </div>
        </div>
      </div>
      {{-- Footer panneau --}}
      <div class="max-w-[1280px] mx-auto px-6 md:px-10 py-4 flex items-center justify-between text-[12px] text-dark-500" style="border-top: 1px solid rgba(0,0,0,0.06);">
        <div class="flex items-center gap-2">
          <span>Besoin d'aide pour choisir ?</span>
          <a href="/contact" class="text-accent-700 hover:text-accent-800 font-medium inline-flex items-center gap-1">
            Contactez un expert
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons['arrow-right'] !!}</svg>
          </a>
        </div>
        <div class="flex items-center gap-2 text-dark-400">
          <kbd class="px-2 py-1 bg-dark-50 rounded-md text-[11px] font-mono text-dark-600 border border-dark-100">⌘K</kbd>
          <span>Rechercher</span>
        </div>
      </div>
    </div>

  {{-- ===== MOBILE DRAWER ===== --}}
  <div
    x-show="mobileOpen"
    x-cloak
    class="lg:hidden fixed inset-0 z-[60]"
    role="dialog"
    aria-modal="true"
    aria-label="Menu de navigation"
    id="mobile-drawer"
    x-init="$watch('mobileOpen', v => document.body.style.overflow = v ? 'hidden' : '')"
  >
    {{-- Overlay --}}
    <div
      x-show="mobileOpen"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      @click="closeMobile()"
      class="absolute inset-0 bg-dark-900/40 backdrop-blur-sm"
    ></div>

    {{-- Drawer panel --}}
    <aside
      x-show="mobileOpen"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="translate-x-full"
      x-transition:enter-end="translate-x-0"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="translate-x-0"
      x-transition:leave-end="translate-x-full"
      class="absolute top-0 right-0 h-full w-[88%] max-w-[400px] bg-white shadow-2xl flex flex-col"
      @click.stop
    >
      {{-- Header sticky --}}
      <div class="sticky top-0 bg-white z-10 flex items-center justify-between px-5 py-4 border-b border-dark-100">
        <a href="/" class="flex items-center">
          <img src="/images/logo-neogtb.webp" alt="NeoGTB" class="h-10 w-auto" />
        </a>
        <button type="button" x-ref="mobileClose" @click="closeMobile()" class="p-2 rounded-lg hover:bg-dark-50 transition-colors min-w-[44px] min-h-[44px] flex items-center justify-center focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500" aria-label="Fermer le menu">
          <svg class="w-6 h-6 text-dark-700" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">{!! $icons['x-mark'] !!}</svg>
        </button>
      </div>

      {{-- Body scrollable --}}
      <div class="flex-1 overflow-y-auto px-5 py-4">
        {{-- Search (visuel) --}}
        <div class="relative mb-5">
          <span class="absolute left-3 top-1/2 -translate-y-1/2 text-dark-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons['magnifying-glass'] !!}</svg>
          </span>
          <input type="search" placeholder="Rechercher…" aria-label="Rechercher" class="w-full pl-10 pr-3 py-3 text-[14px] bg-dark-50 border border-dark-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-500 focus:bg-white" />
        </div>

        {{-- Accordion sections --}}
        @foreach($exploreItems as $colKey => $col)
          @php $openByDefault = $colKey === 'comprendre'; @endphp
          <div x-data="{ open: {{ $openByDefault ? 'true' : 'false' }} }" class="mb-2 border-b border-dark-100 pb-2">
            <button type="button" @click="open = !open" :aria-expanded="open.toString()" class="w-full flex items-center justify-between py-3 text-left min-h-[44px]">
              <span class="flex items-center gap-2">
                <span class="text-[11px] font-semibold uppercase tracking-[0.12em] text-dark-500">{{ $col['label'] }}</span>
                <span class="text-[11px] text-dark-400">({{ count($col['items']) }})</span>
              </span>
              <svg class="w-4 h-4 text-dark-400 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons['chevron-down'] !!}</svg>
            </button>
            <div x-show="open" x-collapse>
              <ul class="flex flex-col gap-1 pb-2">
                @foreach($col['items'] as $it)
                  @php $active = request()->is($it['match']); @endphp
                  <li>
                    <a href="{{ $it['href'] }}" @click="closeMobile()"
                      @if($active) aria-current="page" @endif
                      class="flex gap-3 px-3 py-3 rounded-xl min-h-[44px] {{ $active ? 'bg-accent-50' : 'hover:bg-dark-50' }}">
                      <svg class="w-5 h-5 shrink-0 mt-0.5 {{ $active ? 'text-accent-600' : 'text-dark-400' }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">{!! $icons[$it['icon']] !!}</svg>
                      <span class="flex-1 min-w-0">
                        <span class="block text-[14px] {{ $active ? 'text-accent-700 font-semibold' : 'text-dark-900 font-medium' }}">{{ $it['title'] }}</span>
                        <span class="block text-[12px] text-dark-500 mt-0.5 truncate">{{ $it['desc'] }}</span>
                      </span>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        @endforeach

        {{-- Liens directs --}}
        <div class="mt-2 flex flex-col">
          @foreach([['/blog','Perspectives','blog*'],['/about','À propos','about'],['/faq','FAQ','faq'],['/contact','Contact','contact']] as $direct)
            @php $active = request()->is($direct[2]); @endphp
            <a href="{{ $direct[0] }}" @click="closeMobile()"
              @if($active) aria-current="page" @endif
              class="py-3 px-3 text-[15px] min-h-[44px] flex items-center rounded-xl {{ $active ? 'bg-accent-50 text-accent-700 font-semibold' : 'text-dark-900 font-medium hover:bg-dark-50' }}">
              {{ $direct[1] }}
            </a>
          @endforeach
        </div>
      </div>

      {{-- CTA sticky bottom --}}
      <div class="bg-white border-t border-dark-100 px-5 pt-4" style="padding-bottom: max(16px, env(safe-area-inset-bottom));">
        <a href="/audit" @click="closeMobile()" class="btn-primary w-full justify-center text-[14px] py-3">
          Pré-diagnostic gratuit
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>
    </aside>
  </div>
  </header>

  <script>
    function neogtbNav() {
      return {
        scrolled: false,
        explorerOpen: false,
        mobileOpen: false,
        _hoverTimer: null,
        _reduced: false,
        init() {
          this._reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        },
        onScroll() {
          this.scrolled = window.scrollY > 20;
          if (window.scrollY > 50 && this.explorerOpen) this.closeExplorer();
        },
        onResize() {
          if (window.innerWidth >= 1024 && this.mobileOpen) {
            this.mobileOpen = false;
            document.body.style.overflow = '';
          }
          if (window.innerWidth < 1024 && this.explorerOpen) this.closeExplorer();
        },
        toggleExplorer() { this.explorerOpen = !this.explorerOpen; },
        closeExplorer() { this.explorerOpen = false; },
        openExplorerAndFocus() {
          this.explorerOpen = true;
          this.$nextTick(() => {
            const first = document.querySelector('#explorer-panel a');
            if (first) first.focus();
          });
        },
        hoverOpen() {
          if (this._reduced) return;
          clearTimeout(this._hoverTimer);
          this._hoverTimer = setTimeout(() => { this.explorerOpen = true; }, 120);
        },
        hoverClose() {
          if (this._reduced) return;
          clearTimeout(this._hoverTimer);
          this._hoverTimer = setTimeout(() => { this.explorerOpen = false; }, 200);
        },
        openMobile() {
          this.mobileOpen = true;
          this.$nextTick(() => {
            const btn = document.querySelector('#mobile-drawer [aria-label="Fermer le menu"]');
            if (btn) btn.focus();
          });
        },
        closeMobile() {
          this.mobileOpen = false;
          document.body.style.overflow = '';
          this.$nextTick(() => { if (this.$refs.trigger) this.$refs.trigger.focus(); });
        },
        closeAll() {
          if (this.explorerOpen) { this.closeExplorer(); if (this.$refs.trigger) this.$refs.trigger.focus(); }
          if (this.mobileOpen) this.closeMobile();
        },
      }
    }
  </script>

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
            <li><a href="/tables-modbus" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">Tables Modbus</a></li>
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
