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

  {{-- ===== Bandeau d'annonce (configurable depuis l'admin) ===== --}}
  @if($announcement = $site->announcementBar())
    <div style="background:{{ $announcement['color'] }}" class="text-white text-center py-2 text-sm">
      @if($announcement['link'])
        <a href="{{ $announcement['link'] }}" class="underline hover:opacity-80 transition-opacity">{{ $announcement['text'] }}</a>
      @else
        {{ $announcement['text'] }}
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
        <ol style="display: flex; align-items: center; gap: 6px; list-style: none; margin: 0; padding: 0; font-size: 12px; color: #94a3b8;">
          @yield('breadcrumbs')
        </ol>
      </nav>
    @endif

    @yield('content')
  </main>

  {{-- ===== FOOTER — Premium 4 colonnes ===== --}}
  <footer style="background: #fff; border-top: 0.5px solid #e2e8f0;">
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
                <input type="email" id="footer-nl-email" name="email" placeholder="{{ $site->label('footer.newsletter_placeholder', 'votre@email.com') }}" required aria-label="{{ $site->label('footer.newsletter_aria', 'Votre adresse email pour la veille GTB mensuelle') }}" class="flex-1 text-[14px] px-4 py-2.5 rounded-lg text-dark-900 placeholder-dark-400 outline-none focus:ring-2 focus:ring-accent-500/40 transition-shadow" style="border: 0.5px solid #e2e8f0; background: #f8fafc;" />
                <button type="submit" :disabled="nlSending" class="text-[13px] font-medium px-5 py-2.5 rounded-lg text-white transition-all duration-200 hover:shadow-lg hover:shadow-accent-500/20" style="background: linear-gradient(135deg, #2D8B4E, #267a43);">
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
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid #e2e8f0;">ISO 52120-1</span>
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid #e2e8f0;">Décret BACS</span>
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid #e2e8f0;">RE2020</span>
            <span class="text-[10px] font-medium px-3 py-1 rounded-full text-dark-500" style="border: 0.5px solid #e2e8f0;">CEE BAT-TH-116</span>
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
      <div class="mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4" style="border-top: 0.5px solid #e2e8f0;">
        <p class="text-[13px] text-dark-400">{{ $settings->copyright ?? '&copy; ' . date('Y') . ' NeoGTB. Tous droits réservés.' }}</p>
        <div class="flex items-center gap-5">
          {{-- LinkedIn --}}
          <a href="https://www.linkedin.com/in/ulrich-calmo" target="_blank" rel="noopener noreferrer" class="text-dark-400 hover:text-dark-900 transition-colors duration-200" aria-label="LinkedIn">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
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
