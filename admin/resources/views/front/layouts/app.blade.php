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

  {{-- ===== NAV — Premium mega-menu ===== --}}
  @include('front.partials.header-nav')

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

  {{-- ===== FOOTER — Premium Modern ===== --}}
  <footer class="relative overflow-hidden" style="background: linear-gradient(180deg, #fafafa 0%, #fff 100%);">
    {{-- Top border accent --}}
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-dark-200 to-transparent"></div>
    
    <div class="max-w-[1280px] mx-auto px-6 md:px-10 py-20 lg:py-24">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16">

        {{-- Brand + Newsletter --}}
        <div class="md:col-span-5">
          <img src="/images/logo-neogtb.webp" alt="NeoGTB" class="h-14 w-auto" loading="lazy" decoding="async" />
          <p class="mt-6 text-[15px] text-dark-500 max-w-md leading-relaxed">
            Le tiers de confiance indépendant de la Gestion Technique du Bâtiment en France. Aucun lien commercial avec les fabricants.
          </p>

          {{-- Newsletter --}}
          <div class="mt-10">
            <p class="text-xs font-semibold uppercase tracking-[0.1em] text-dark-400 mb-4">Veille GTB mensuelle</p>
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
              <div class="flex gap-3" x-show="!nlSent">
                <input type="email" name="email" placeholder="votre@email.com" required class="flex-1 text-[14px] px-5 py-3.5 rounded-xl text-dark-900 placeholder-dark-400 outline-none transition-all duration-300 border border-dark-200 bg-white focus:border-accent-400 focus:ring-4 focus:ring-accent-500/10" />
                <button type="submit" :disabled="nlSending" class="text-[14px] font-semibold px-6 py-3.5 rounded-xl text-white transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-accent-500/25 bg-gradient-to-r from-accent-500 to-accent-600">
                  <span x-show="!nlSending">S'inscrire</span>
                  <span x-show="nlSending" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                  </span>
                </button>
              </div>
              <div x-show="nlSent" x-cloak class="flex items-center gap-3 p-4 rounded-xl bg-accent-50 border border-accent-200">
                <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-[14px] text-accent-700 font-medium">Email de confirmation envoyé !</span>
              </div>
              <p x-show="nlError" x-text="nlError" x-cloak class="text-[13px] text-red-500 mt-2"></p>
              <label x-show="!nlSent" class="mt-3 flex items-start gap-3 cursor-pointer">
                <input type="checkbox" required class="mt-1 w-4 h-4 rounded border-dark-300 text-accent-500 focus:ring-accent-500/40 focus:ring-offset-0" />
                <span class="text-[13px] text-dark-400 leading-relaxed">J'accepte de recevoir la veille GTB mensuelle. <a href="/politique-de-confidentialite" class="text-dark-600 hover:text-accent-600 underline underline-offset-2 transition-colors">Confidentialité</a></span>
              </label>
            </form>
            <p class="mt-3 text-xs text-dark-400 flex items-center gap-2">
              <svg class="w-4 h-4 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
              1 email/mois. Désabonnement en 1 clic.
            </p>
          </div>

          {{-- Normes badges --}}
          <div class="mt-8 flex flex-wrap gap-2">
            <span class="text-[11px] font-medium px-4 py-1.5 rounded-full text-dark-600 bg-dark-100/60 border border-dark-200/50">ISO 52120-1</span>
            <span class="text-[11px] font-medium px-4 py-1.5 rounded-full text-dark-600 bg-dark-100/60 border border-dark-200/50">Décret BACS</span>
            <span class="text-[11px] font-medium px-4 py-1.5 rounded-full text-dark-600 bg-dark-100/60 border border-dark-200/50">RE2020</span>
            <span class="text-[11px] font-medium px-4 py-1.5 rounded-full text-dark-600 bg-dark-100/60 border border-dark-200/50">CEE BAT-TH-116</span>
          </div>
        </div>

        {{-- Navigation --}}
        <div class="md:col-span-2 md:col-start-7">
          <p class="text-xs font-semibold uppercase tracking-[0.1em] text-dark-400 mb-5">Navigation</p>
          <ul class="space-y-3.5">
            <li><a href="/gtb" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">GTB</a></li>
            <li><a href="/gtc" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">GTC</a></li>
            <li><a href="/solutions" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">Solutions</a></li>
            <li><a href="/comparateur" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">Comparateur</a></li>
            <li><a href="/reglementation" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">Réglementation</a></li>
            <li><a href="/blog" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">Perspectives</a></li>
          </ul>
        </div>

        {{-- Outils --}}
        <div class="md:col-span-2">
          <p class="text-xs font-semibold uppercase tracking-[0.1em] text-dark-400 mb-5">Outils</p>
          <ul class="space-y-3.5">
            <li><a href="/audit" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">Pré-diagnostic GTB</a></li>
            <li><a href="/generateur-cee" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">Générateur CEE</a></li>
            <li><a href="/tables-modbus" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">Tables Modbus</a></li>
            <li><a href="/contact" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">Contact</a></li>
            <li><a href="/faq" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">FAQ</a></li>
          </ul>
        </div>

        {{-- Légal --}}
        <div class="md:col-span-2">
          <p class="text-xs font-semibold uppercase tracking-[0.1em] text-dark-400 mb-5">Légal</p>
          <ul class="space-y-3.5">
            <li><a href="/mentions-legales" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">Mentions légales</a></li>
            <li><a href="/politique-de-confidentialite" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">Confidentialité</a></li>
            <li><a href="/mes-droits-rgpd" class="text-[15px] text-dark-500 hover:text-accent-600 transition-colors duration-300">Vos droits RGPD</a></li>
          </ul>
        </div>
      </div>

      {{-- Bottom bar --}}
      <div class="mt-16 pt-8 flex flex-col sm:flex-row items-center justify-between gap-6 border-t border-dark-100">
        <p class="text-[14px] text-dark-400">&copy; {{ date('Y') }} NeoGTB. Tous droits réservés.</p>
        <div class="flex items-center gap-6">
          {{-- LinkedIn --}}
          <a href="https://www.linkedin.com/in/ulrich-calmo" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-10 h-10 rounded-xl bg-dark-100 text-dark-500 hover:bg-accent-50 hover:text-accent-600 transition-all duration-300" aria-label="LinkedIn">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <button onclick="window.dispatchEvent(new CustomEvent('open-cookie-settings'))" class="text-[14px] text-dark-400 hover:text-accent-600 transition-colors duration-300 cursor-pointer font-medium">Gérer les cookies</button>
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
