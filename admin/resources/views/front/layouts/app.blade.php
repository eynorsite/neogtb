@php
    $__consent = \App\Helpers\ConsentHelper::get();
    $__tracking = $site->trackingScripts($__consent);
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
  @php($page = $page ?? null)
  @php($seoTitle = $seoTitle ?? null)
  @php($seoDescription = $seoDescription ?? null)
  {{-- Priorité : variable explicite du controller > @section du blade > meta_title de la page dynamique > défaut global --}}
  @hasSection('title')
    @php($seoTitle = $seoTitle ?: trim($__env->yieldContent('title')))
  @endif
  @hasSection('description')
    @php($seoDescription = $seoDescription ?: trim($__env->yieldContent('description')))
  @endif
  @php($seoTitle = $seoTitle ?: ($page->meta_title ?? 'Conseil GTB indépendant & décret BACS 2027 | NeoGTB'))
  @php($seoDescription = $seoDescription ?: ($page->meta_description ?? 'Tiers de confiance GTB. Pré-diagnostic ISO 52120-1 gratuit, comparateur indépendant, accompagnement décret BACS pour bâtiments tertiaires.'))
  @php($seoOgImage = $seoOgImage ?? ($page->og_image ?? '/images/og-neogtb.png'))
  @php($seoOgImageAbs = \Illuminate\Support\Str::startsWith($seoOgImage, ['http://', 'https://']) ? $seoOgImage : url($seoOgImage))
  @php($seoUrl = $seoUrl ?? url()->current())
  @php($seoBreadcrumbName = $page->title ?? $seoTitle)
  @php($seoOgType = $seoOgType ?? 'website')

  {{-- Google Fonts dynamiques --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="{{ $site->googleFontsUrl() }}">

  {{-- CSS Variables dynamiques depuis l'admin --}}
  {!! $site->cssVariables() !!}

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
  <meta property="og:type" content="{{ $seoOgType }}" />
  <meta property="og:site_name" content="{{ $settings->company_name ?? 'NeoGTB' }}" />
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

  {{-- Schema.org Organization (dynamique depuis l'admin) --}}
  {!! $site->jsonLd() !!}

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

  {{-- Schema.org contextuel (breadcrumbs, FAQ, Article) --}}
  @stack('schema')

  {{-- Plausible Analytics — hébergé UE, sans cookies, exempt de consentement CNIL --}}
  <script defer data-domain="neogtb.fr" src="https://plausible.io/js/script.js"></script>

  {{-- Tailwind v4 + design tokens NeoGTB + Alpine.js (self-hosted) compilés via Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Tracking conditionnel (consentement cookie) --}}
  {!! $__tracking['head'] !!}

  @stack('head')

  {{-- Custom code admin (Avancé > Code personnalisé head) --}}
  {!! $settings->custom_head_code ?? '' !!}
</head>
<body class="min-h-screen bg-white text-dark-900 antialiased" style="font-family: 'Inter', system-ui, sans-serif;">
  {!! $__tracking['body'] ?? '' !!}

  {{-- Skip link --}}
  <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-accent-600 focus:text-white focus:rounded-lg focus:text-sm focus:font-medium">{{ $site->label('layout.skip_link', 'Aller au contenu principal') }}</a>

  {{-- ===== Bandeau d'annonce (configurable depuis l'admin, dismissable via localStorage) ===== --}}
  @if($announcement = $site->announcementBar())
    <div
      x-data="{
        dismissed: false,
        storageKey: 'neogtb_announcement_dismissed',
        init() {
          const stored = localStorage.getItem(this.storageKey);
          if (stored) {
            try {
              const data = JSON.parse(stored);
              if (data.text === @js($announcement['text'])) {
                this.dismissed = true;
              } else {
                localStorage.removeItem(this.storageKey);
              }
            } catch (e) { localStorage.removeItem(this.storageKey); }
          }
        },
        dismiss() {
          this.dismissed = true;
          localStorage.setItem(this.storageKey, JSON.stringify({ text: @js($announcement['text']), at: Date.now() }));
        }
      }"
      x-show="!dismissed"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 max-h-12"
      x-transition:leave-end="opacity-0 max-h-0"
      x-cloak
      style="background:{{ $announcement['bg_color'] }}; color:{{ $announcement['text_color'] }}"
      class="relative text-center py-2 text-sm overflow-hidden"
    >
      <div class="flex items-center justify-center gap-2 px-8">
        @if($announcement['url'])
          <a href="{{ $announcement['url'] }}" class="underline hover:opacity-80 transition-opacity">{{ $announcement['text'] }}</a>
        @else
          <span>{{ $announcement['text'] }}</span>
        @endif
      </div>
      @if($announcement['dismissable'] ?? false)
        <button
          @click="dismiss()"
          class="absolute right-3 top-1/2 -translate-y-1/2 p-1 rounded-full opacity-70 hover:opacity-100 hover:bg-white/10 transition-all duration-200"
          aria-label="Fermer le bandeau"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>
      @endif
    </div>
  @endif

  {{-- ===== NAV — Premium mega-menu ===== --}}
  @include('front.partials.header-nav')

  {{-- ===== MAIN CONTENT ===== --}}
  <main id="main-content" class="pt-14 lg:pt-[120px] pb-[88px] lg:pb-0">
    {{-- Breadcrumbs --}}
    @hasSection('breadcrumbs')
      <nav aria-label="{{ $site->label('layout.breadcrumb_label', "Fil d'Ariane") }}" class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-6 md:px-10 py-3">
        <ol style="display: flex; align-items: center; gap: 6px; list-style: none; margin: 0; padding: 0; font-size: 12px; color: var(--color-dark-400);">
          @yield('breadcrumbs')
        </ol>
      </nav>
    @endif

    @yield('content')
  </main>

  {{-- ===== FOOTER — Premium 4 colonnes ===== --}}
  <footer style="background: var(--color-body-bg, white); border-top: 0.5px solid var(--color-dark-200);">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-6 md:px-10 py-16">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-10">

        {{-- Brand + Newsletter --}}
        <div class="md:col-span-5">
          <img src="/images/logo-neogtb.webp" alt="NeoGTB" class="h-16 w-auto" loading="lazy" decoding="async" />
          <p class="mt-5 text-[14px] text-dark-500 max-w-md" style="line-height: 1.7;">
            {{ $site->label('footer.brand_description', 'Le tiers de confiance indépendant de la Gestion Technique du Bâtiment en France. Aucun lien commercial avec les fabricants.') }}
          </p>

          {{-- Newsletter --}}
          <div class="mt-8">
            <p class="text-[11px] font-medium uppercase tracking-wider text-dark-400 mb-3">{{ $site->label('footer.newsletter_subtitle', 'Veille GTB mensuelle') }}</p>
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
                <label class="sr-only" for="footer-nl-email">{{ $site->label('footer.newsletter_sr_label', 'Email pour la veille GTB') }}</label>
                <input type="email" id="footer-nl-email" name="email" placeholder="{{ $site->label('footer.newsletter_placeholder', 'votre@email.com') }}" required aria-label="{{ $site->label('footer.newsletter_aria', 'Votre adresse email pour la veille GTB mensuelle') }}" class="flex-1 text-[14px] px-4 py-2.5 rounded-lg text-dark-900 placeholder-dark-400 outline-none focus:ring-2 focus:ring-accent-500/40 transition-shadow" style="border: 0.5px solid var(--color-dark-200); background: var(--color-dark-50);" />
                <button type="submit" :disabled="nlSending" class="text-[13px] font-medium px-5 py-2.5 rounded-lg text-white transition-all duration-200 hover:shadow-lg hover:shadow-accent-500/20" style="background: linear-gradient(135deg, var(--color-accent-500), var(--color-accent-600));">
                  <span x-show="!nlSending">{{ $site->label('footer.newsletter_button', "S'inscrire") }}</span>
                  <span x-show="nlSending">...</span>
                </button>
              </div>
              <div x-show="nlSent" x-cloak class="text-[13px] text-accent-500 font-medium">{{ $site->label('footer.newsletter_success', 'Un email de confirmation vous a été envoyé. Cliquez sur le lien pour valider votre inscription.') }}</div>
              <p x-show="nlError" x-text="nlError" x-cloak class="text-[12px] text-red-500 mt-1"></p>
              <label x-show="!nlSent" class="mt-2 flex items-start gap-2 cursor-pointer">
                <input type="checkbox" required class="mt-0.5 w-3.5 h-3.5 rounded text-accent-500 focus:ring-accent-500/40" />
                <span class="text-[11px] text-dark-400" style="line-height: 1.5;">{!! $site->label('footer.newsletter_consent', 'J\'accepte de recevoir la veille GTB mensuelle. <a href="/politique-de-confidentialite" class="underline hover:text-dark-700">Confidentialité</a>') !!}</span>
              </label>
            </form>
            <p class="mt-2 text-[11px] text-dark-400">{{ $site->label('footer.newsletter_frequency', '1 email/mois. Désabonnement en 1 clic.') }}</p>
          </div>

          {{-- Normes badges --}}
          <div class="mt-6 flex flex-wrap gap-2">
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid var(--color-dark-200);">ISO 52120-1</span>
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid var(--color-dark-200);">Décret BACS</span>
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid var(--color-dark-200);">RE2020</span>
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid var(--color-dark-200);">CEE BAT-TH-116</span>
          </div>
        </div>

        {{-- Navigation --}}
        <div class="md:col-span-2 md:col-start-7">
          <p class="text-[11px] font-medium uppercase tracking-wider text-dark-400 mb-4">{{ $site->label('footer.col1_title', 'Navigation') }}</p>
          <ul class="space-y-3">
            <li><a href="/gtb" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_gtb', 'GTB') }}</a></li>
            <li><a href="/gtc" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_gtc', 'GTC') }}</a></li>
            <li><a href="/solutions" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_solutions', 'Solutions') }}</a></li>
            <li><a href="/comparateur" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_comparateur', 'Comparateur') }}</a></li>
            <li><a href="/reglementation" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_reglementation', 'Réglementation') }}</a></li>
            <li><a href="/blog" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_blog', 'Perspectives') }}</a></li>
          </ul>
        </div>

        {{-- Outils --}}
        <div class="md:col-span-2">
          <p class="text-[11px] font-medium uppercase tracking-wider text-dark-400 mb-4">{{ $site->label('footer.col2_title', 'Outils') }}</p>
          <ul class="space-y-3">
            <li><a href="/audit" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_audit', 'Pré-diagnostic GTB') }}</a></li>
            <li><a href="/generateur-cee" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_generateur_cee', 'Générateur CEE') }}</a></li>
            <li><a href="/tables-modbus" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_tables_modbus', 'Tables Modbus') }}</a></li>
            <li><a href="/contact" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_contact', 'Contact') }}</a></li>
            <li><a href="/faq" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_faq', 'FAQ') }}</a></li>
          </ul>
        </div>

        {{-- Légal --}}
        <div class="md:col-span-2">
          <p class="text-[11px] font-medium uppercase tracking-wider text-dark-400 mb-4">{{ $site->label('footer.col3_title', 'Légal') }}</p>
          <ul class="space-y-3">
            <li><a href="/mentions-legales" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_mentions', 'Mentions légales') }}</a></li>
            <li><a href="/politique-de-confidentialite" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_confidentialite', 'Confidentialité') }}</a></li>
            <li><a href="/cookies" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_cookies', 'Cookies') }}</a></li>
            <li><a href="/mes-droits-rgpd" class="text-[14px] text-dark-500 hover:text-dark-900 transition-colors duration-200">{{ $site->label('footer.nav_rgpd', 'Vos droits RGPD') }}</a></li>
          </ul>
        </div>
      </div>

      {{-- Bottom bar --}}
      <div class="mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4" style="border-top: 0.5px solid var(--color-dark-200);">
        <p class="text-[13px] text-dark-400">{{ $settings->copyright ?? '&copy; ' . date('Y') . ' NeoGTB. Tous droits réservés.' }}</p>
        <div class="flex items-center gap-5">
          {{-- Réseaux sociaux dynamiques --}}
          @foreach($site->socialLinks() as $network => $url)
            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="text-dark-400 hover:text-dark-900 transition-colors duration-200" aria-label="{{ ucfirst(str_replace('_', ' ', $network)) }}">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                @switch($network)
                  @case('linkedin')
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    @break
                  @case('facebook')
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    @break
                  @case('youtube')
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    @break
                  @case('instagram')
                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 1 0 0-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 1 1-2.882 0 1.441 1.441 0 0 1 2.882 0z"/>
                    @break
                  @case('twitter_x')
                    <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>
                    @break
                  @case('tiktok')
                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                    @break
                @endswitch
              </svg>
            </a>
          @endforeach
          <button type="button" x-on:click="$dispatch('open-cookie-settings')" class="text-[13px] text-dark-400 hover:text-dark-900 transition-colors duration-200 cursor-pointer">{{ $site->label('footer.manage_cookies', 'Gérer les cookies') }}</button>
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
  @include('front.partials.sticky-cta')

  {{-- Custom code admin (Avancé > Code personnalisé body) --}}
  {!! $settings->custom_body_code ?? '' !!}
</body>
</html>
