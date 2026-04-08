@extends('front.layouts.app')

@section('title', 'Simulateur CEE GTB — Estimez vos primes — NeoGTB')
@section('description', "Estimez vos Certificats d'Économies d'Énergie (CEE) pour un projet GTB en 3 minutes. Outil gratuit, sans lien commercial.")

@push('head')
<style>
  :root {
    --color-accent-50: #F0FDFA; --color-accent-100: #CCFBF1; --color-accent-200: #99F6E4;
    --color-accent-300: #5EEAD4; --color-accent-400: #2DD4BF; --color-accent-500: #14B8A6;
    --color-accent-600: #0D9488; --color-accent-700: #0F766E; --color-accent-800: #115E59;
    --color-accent-900: #134E4A;
    --color-dark-50: #FAFAF9; --color-dark-100: #F5F5F4; --color-dark-200: #E7E5E4;
    --color-dark-300: #D6D3D1; --color-dark-400: #A8A29E; --color-dark-500: #78716C;
    --color-dark-600: #57534E; --color-dark-700: #44403C; --color-dark-800: #292524;
    --color-dark-900: #1C1917; --color-dark-950: #0C0A09;
  }
  [x-cloak] { display: none !important; }

  /* ── Hero ── */
  .cee-hero {
    position: relative; overflow: hidden;
    padding: 80px 0 56px;
    background: #edf5f7;
  }
  .cee-hero-img {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover; object-position: center;
  }
  .cee-hero-mesh {
    position: absolute; inset: 0; pointer-events: none;
    background: linear-gradient(to bottom, rgba(237,245,247,0.4) 0%, rgba(237,245,247,0.95) 100%);
  }
  .cee-hero-grid {
    position: absolute; inset: 0; pointer-events: none;
    background-image:
      linear-gradient(rgba(0,0,0,0.02) 1px, transparent 1px),
      linear-gradient(90deg, rgba(0,0,0,0.02) 1px, transparent 1px);
    background-size: 60px 60px;
    mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, black 30%, transparent 70%);
    -webkit-mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, black 30%, transparent 70%);
  }
  .cee-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(60px); opacity: 0.5; }
  .cee-orb-1 { width: 300px; height: 300px; top: -10%; right: 10%; background: radial-gradient(circle, rgba(13,148,136,0.15) 0%, transparent 70%); animation: cee-float 8s ease-in-out infinite; }
  .cee-orb-2 { width: 250px; height: 250px; bottom: -5%; left: 5%; background: radial-gradient(circle, rgba(15,118,110,0.10) 0%, transparent 70%); animation: cee-float 10s ease-in-out infinite reverse; }
  .cee-orb-3 { width: 200px; height: 200px; top: 30%; left: 40%; background: radial-gradient(circle, rgba(245,158,11,0.06) 0%, transparent 70%); animation: cee-float 12s ease-in-out infinite 2s; }
  @keyframes cee-float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33%       { transform: translate(20px, -15px) scale(1.05); }
    66%       { transform: translate(-10px, 10px) scale(0.95); }
  }
  @keyframes cee-bounce {
    0%, 100% { transform: translateY(0); opacity: 0.4; }
    50%       { transform: translateY(6px); opacity: 0.8; }
  }

  .cee-hero-eyebrow { font-size: 12px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: var(--color-accent-600); margin-bottom: 20px; }
  .cee-hero-title { font-size: clamp(32px, 4.5vw, 52px); font-weight: 500; color: var(--color-dark-900); line-height: 1.1; letter-spacing: -0.03em; margin-bottom: 16px; }
  .cee-hero-title span { background: linear-gradient(135deg, var(--color-accent-700) 0%, var(--color-accent-500) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
  .cee-hero-desc { font-size: 16px; color: var(--color-dark-500); line-height: 1.7; max-width: 520px; margin: 0 auto 28px; }
  .cee-hero-badges { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
  .cee-badge { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 100px; font-size: 12px; font-weight: 500; background: white; border: 1px solid var(--color-dark-200); color: var(--color-dark-500); box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
  .cee-badge-accent { background: rgba(13,148,136,0.06); border-color: rgba(13,148,136,0.15); color: var(--color-accent-600); }
  .cee-scroll-hint { margin-top: 32px; color: var(--color-dark-300); display: flex; justify-content: center; }

  /* ── Breadcrumb ── */
  .cee-breadcrumb { padding: 14px 0; background: white; border-bottom: 1px solid var(--color-dark-100); }
  .cee-breadcrumb ol { display: flex; align-items: center; gap: 6px; list-style: none; margin: 0; padding: 0; font-size: 13px; }
  .cee-breadcrumb li { display: flex; align-items: center; gap: 6px; color: var(--color-dark-400); }
  .cee-breadcrumb li a { color: var(--color-dark-500); text-decoration: none; transition: color 0.15s; }
  .cee-breadcrumb li a:hover { color: var(--color-accent-600); }
  .cee-breadcrumb li.active { color: var(--color-dark-700); font-weight: 500; }
  .cee-breadcrumb-sep { color: var(--color-dark-300); }

  /* ── Section ── */
  .cee-section { padding: 48px 0 80px; background: var(--color-dark-50); min-height: 600px; }

  /* ── Progress ── */
  .cee-progress-wrap { margin-bottom: 40px; }
  .cee-progress-bar { width: 100%; height: 3px; background: var(--color-dark-200); border-radius: 100px; overflow: hidden; margin-bottom: 24px; }
  .cee-progress-fill { height: 100%; background: var(--color-accent-600); border-radius: 100px; transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
  .cee-progress-steps { display: flex; justify-content: center; gap: 48px; }
  .cee-step-item { display: flex; align-items: center; gap: 10px; }
  .cee-step-dot { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: white; color: var(--color-dark-400); border: 1.5px solid var(--color-dark-200); transition: all 0.3s; }
  .cee-step-item.is-active .cee-step-dot { background: var(--color-dark-900); color: white; border-color: var(--color-dark-900); }
  .cee-step-item.is-done .cee-step-dot { background: var(--color-accent-600); color: white; border-color: var(--color-accent-600); }
  .cee-step-label { font-size: 13px; font-weight: 500; color: var(--color-dark-400); transition: color 0.2s; }
  .cee-step-item.is-active .cee-step-label { color: var(--color-dark-900); }
  .cee-step-item.is-done .cee-step-label { color: var(--color-accent-700); }
  @media (max-width: 640px) { .cee-progress-steps { gap: 16px; } .cee-step-label { display: none; } }

  /* ── Card ── */
  .cee-card { background: white; border-radius: 16px; border: 1px solid var(--color-dark-200); overflow: hidden; }
  .cee-card-header { padding: 28px 28px 0; }
  .cee-card-header h2 { font-size: 20px; font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; margin-bottom: 4px; }
  .cee-card-header p { font-size: 14px; color: var(--color-dark-500); line-height: 1.6; }
  .cee-card-body { padding: 24px 28px; }
  .cee-card-footer { padding: 20px 28px; border-top: 1px solid var(--color-dark-100); display: flex; justify-content: space-between; align-items: center; }

  /* ── Labels ── */
  .cee-label { display: block; font-size: 13px; font-weight: 600; color: var(--color-dark-700); margin-bottom: 10px; letter-spacing: 0.01em; }

  /* ── Inputs ── */
  .cee-input { width: 100%; padding: 12px 16px; border: 1.5px solid var(--color-dark-200); border-radius: 10px; font-size: 14px; color: var(--color-dark-900); background: white; transition: all 0.15s; font-family: inherit; }
  .cee-input:focus { border-color: var(--color-accent-500); outline: none; box-shadow: 0 0 0 3px rgba(13,148,136,0.08); }
  .cee-input.has-error { border-color: #ef4444; }
  .cee-input-wrap { position: relative; }
  .cee-input-suffix { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); font-size: 13px; color: var(--color-dark-400); font-weight: 500; }
  .cee-error { font-size: 12px; color: #ef4444; margin-top: 6px; }

  /* ── Grids ── */
  .cee-grid-6 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 24px; }
  @media (max-width: 640px) { .cee-grid-6 { grid-template-columns: repeat(2, 1fr); } }

  /* ── Choice buttons ── */
  .cee-choice { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 16px 8px; border-radius: 12px; cursor: pointer; border: 1.5px solid var(--color-dark-200); background: white; transition: all 0.2s; font-family: inherit; }
  .cee-choice:hover { border-color: var(--color-dark-300); background: var(--color-dark-50); }
  .cee-choice.is-selected { border-color: var(--color-accent-600); background: rgba(13,148,136,0.04); box-shadow: 0 0 0 3px rgba(13,148,136,0.08); }
  .cee-choice-label { font-size: 13px; font-weight: 500; color: var(--color-dark-700); }
  .cee-choice.is-selected .cee-choice-label { color: var(--color-accent-700); }

  /* ── Zone buttons ── */
  .cee-zone { display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 16px 12px; border-radius: 10px; cursor: pointer; border: 1.5px solid var(--color-dark-200); background: white; transition: all 0.2s; font-family: inherit; }
  .cee-zone:hover { border-color: var(--color-dark-300); }
  .cee-zone.is-selected { border-color: var(--color-accent-600); background: rgba(13,148,136,0.04); box-shadow: 0 0 0 3px rgba(13,148,136,0.08); }
  .cee-zone-id { font-size: 15px; font-weight: 600; color: var(--color-dark-900); }
  .cee-zone-desc { font-size: 12px; color: var(--color-dark-500); }
  .cee-zone-cities { font-size: 11px; color: var(--color-dark-400); text-align: center; line-height: 1.4; }
  .cee-zone-tag { font-size: 11px; font-weight: 500; color: var(--color-dark-500); background: var(--color-dark-100); padding: 2px 8px; border-radius: 4px; margin-top: 4px; }
  .cee-zone-depts { font-size: 10px; color: var(--color-dark-300); text-align: center; line-height: 1.4; margin-top: 4px; }

  /* ── Equipment cards ── */
  .cee-equip { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 16px 8px; border-radius: 12px; cursor: pointer; border: 1.5px solid var(--color-dark-200); background: white; transition: all 0.2s; position: relative; font-family: inherit; }
  .cee-equip:hover { border-color: var(--color-dark-300); }
  .cee-equip.is-selected { border-color: var(--color-accent-600); background: rgba(13,148,136,0.04); box-shadow: 0 0 0 3px rgba(13,148,136,0.08); }
  .cee-equip.is-disabled { opacity: 0.4; cursor: not-allowed; background: var(--color-dark-50); }
  .cee-equip-check { position: absolute; top: 8px; right: 8px; width: 20px; height: 20px; border-radius: 5px; border: 1.5px solid var(--color-dark-200); display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
  .cee-equip.is-selected .cee-equip-check { background: var(--color-accent-600); border-color: var(--color-accent-600); color: white; }
  .cee-equip-label { font-size: 13px; font-weight: 500; color: var(--color-dark-700); }
  .cee-equip-fiche { font-size: 10px; color: var(--color-dark-400); font-family: monospace; }
  .cee-equip.is-selected .cee-equip-label { color: var(--color-accent-700); }

  /* ── Buttons ── */
  .cee-btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 500; font-family: inherit; background: var(--color-dark-900); color: white; border: none; cursor: pointer; transition: all 0.2s; }
  .cee-btn-primary:hover { background: var(--color-dark-800); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
  .cee-btn-accent { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 500; font-family: inherit; background: var(--color-accent-600); color: white; border: none; cursor: pointer; transition: all 0.2s; }
  .cee-btn-accent:hover { background: var(--color-accent-700); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13,148,136,0.25); }
  .cee-btn-ghost { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 500; font-family: inherit; background: white; color: var(--color-dark-600); border: 1.5px solid var(--color-dark-200); cursor: pointer; transition: all 0.15s; }
  .cee-btn-ghost:hover { background: var(--color-dark-50); border-color: var(--color-dark-300); }

  /* ── Fiche toggle ── */
  .cee-fiche-toggle { padding: 20px 24px; border-radius: 14px; border: 1.5px solid var(--color-dark-200); background: white; transition: all 0.2s; }
  .cee-fiche-toggle.is-active { border-color: var(--color-accent-500); background: rgba(13,148,136,0.02); box-shadow: 0 0 0 3px rgba(13,148,136,0.06); }

  /* ── Disclaimer ── */
  .cee-disclaimer { display: flex; gap: 12px; padding: 16px 20px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; margin-top: 20px; }

  /* ── Results ── */
  .cee-results-hero { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .cee-kpi { border-radius: 16px; padding: 32px 24px; text-align: center; position: relative; overflow: hidden; }
  .cee-kpi::after { content: ''; position: absolute; top: -50%; right: -30%; width: 200px; height: 200px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%); pointer-events: none; }
  .cee-kpi-primary { background: var(--color-dark-900); }
  .cee-kpi-accent  { background: var(--color-accent-600); }
  .cee-kpi-label { font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.6); }
  .cee-kpi-value { font-size: clamp(28px, 5vw, 40px); font-weight: 500; color: white; letter-spacing: -0.02em; margin: 8px 0 4px; }
  .cee-kpi-sub { font-size: 12px; color: rgba(255,255,255,0.5); }
  .cee-result-row { display: flex; justify-content: space-between; align-items: center; padding: 14px 16px; border-radius: 10px; border: 1px solid var(--color-dark-100); margin-bottom: 8px; transition: all 0.15s; }
  .cee-result-row:hover { background: var(--color-dark-50); border-color: var(--color-dark-200); }
  .cee-result-name  { font-size: 14px; font-weight: 500; color: var(--color-dark-800); }
  .cee-result-gwh   { font-size: 14px; font-weight: 500; color: var(--color-dark-900); }
  .cee-result-value { font-size: 13px; font-weight: 600; color: var(--color-accent-600); }
  .cee-params-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
  .cee-param { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--color-dark-100); font-size: 13px; }
  .cee-param:nth-child(odd)  { padding-right: 16px; }
  .cee-param:nth-child(even) { padding-left: 16px; border-left: 1px solid var(--color-dark-100); }
  .cee-param-label { color: var(--color-dark-400); }
  .cee-param-value { font-weight: 500; color: var(--color-dark-800); }
  .cee-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }

  /* ── Modal ── */
  .cee-modal-overlay { position: fixed; inset: 0; z-index: 70; display: flex; align-items: center; justify-content: center; padding: 16px; background: rgba(15,23,42,0.5); backdrop-filter: blur(8px); }
  .cee-modal { background: white; border-radius: 16px; max-width: 420px; width: 100%; padding: 28px; border: 1px solid var(--color-dark-200); box-shadow: 0 20px 60px rgba(0,0,0,0.15); }

  @media (max-width: 640px) {
    .cee-results-hero { grid-template-columns: 1fr; }
    .cee-params-grid  { grid-template-columns: 1fr; }
    .cee-param:nth-child(even) { padding-left: 0; border-left: none; }
    .cee-param:nth-child(odd)  { padding-right: 0; }
    .cee-actions { flex-direction: column; }
  }
</style>
@endpush

@section('content')

  {{-- ==================== BREADCRUMB ==================== --}}
  <nav class="cee-breadcrumb" aria-label="Fil d'Ariane">
    <div class="max-w-[720px] mx-auto px-5 md:px-8">
      <ol itemscope itemtype="https://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
          <a href="{{ route('front.home') }}" itemprop="item"><span itemprop="name">Accueil</span></a>
          <meta itemprop="position" content="1" />
        </li>
        <span class="cee-breadcrumb-sep" aria-hidden="true">
          <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </span>
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
          <span itemprop="name" style="color:var(--color-dark-500);">Outils</span>
          <meta itemprop="position" content="2" />
        </li>
        <span class="cee-breadcrumb-sep" aria-hidden="true">
          <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </span>
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
          <span itemprop="name">Générateur CEE</span>
          <meta itemprop="position" content="3" />
        </li>
      </ol>
    </div>
  </nav>

  {{-- ==================== HERO ==================== --}}
  <section class="cee-hero">
    {{-- Hero image: aucune image dédiée hero-cee/hero-generateur/hero-economie/hero-energie n'existe dans /public/images/. Fallback sur hero-gtb-illustration.webp (image mutualisée, meilleure qualité que hero-comparateur.png et évite le doublon visuel avec /comparateur). TODO: créer un visuel dédié CEE. --}}
    <img src="/images/hero-gtb-illustration.webp" alt="Illustration GTB — Générateur de dossier CEE" class="cee-hero-img" width="1200" height="630" loading="eager" fetchpriority="high" />
    <div class="cee-hero-mesh"></div>

    <div class="max-w-[800px] mx-auto px-6 md:px-10 relative z-10 text-center">
      <p class="cee-hero-eyebrow">Outil indépendant · Estimation gratuite</p>
      <h1 class="cee-hero-title">
        Générateur de dossier <span>CEE</span>
      </h1>
      <p class="cee-hero-desc">
        Estimez vos Certificats d'Économies d'Énergie en 3 minutes.<br class="hidden md:block">
        Calcul basé sur les fiches standardisées — résultat objectif, sans engagement.
      </p>
      <div class="cee-hero-badges">
        <span class="cee-badge">
          <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          BAT-TH-116
        </span>
        <span class="cee-badge cee-badge-accent">
          <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          0 € commission · 100% indépendant
        </span>
      </div>
      <div class="cee-scroll-hint">
        <svg style="width:20px;height:20px;animation:cee-bounce 2s infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
      </div>
    </div>
  </section>

  {{-- ==================== FORMULAIRE 3 ÉTAPES ==================== --}}
  <section class="cee-section"
    x-data="ceeGenerator()"
    x-init="init()"
    x-cloak>
    <div class="max-w-[720px] mx-auto px-5 md:px-8">

      {{-- Barre de progression --}}
      <div class="cee-progress-wrap">
        <div class="cee-progress-bar">
          <div class="cee-progress-fill" :style="`width: ${(step / 3) * 100}%`"></div>
        </div>
        <div class="cee-progress-steps">
          <template x-for="(s, i) in [{label: 'Bâtiment', icon: '🏢'}, {label: 'Équipements', icon: '⚙️'}, {label: 'Résultats', icon: '📊'}]" :key="i">
            <div class="cee-step-item" :class="{ 'is-active': step === i + 1, 'is-done': step > i + 1 }">
              <div class="cee-step-dot">
                <span x-show="step <= i + 1" x-text="i + 1" style="font-size:13px;font-weight:600;"></span>
                <svg x-show="step > i + 1" style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
              </div>
              <span class="cee-step-label" x-text="s.label"></span>
            </div>
          </template>
        </div>
      </div>

      {{-- ── ÉTAPE 1 : Bâtiment ── --}}
      <div x-show="step === 1"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 translate-y-4"
           x-transition:enter-end="opacity-100 translate-y-0">
        <div class="cee-card">
          <div class="cee-card-header">
            <h2>Décrivez votre bâtiment</h2>
            <p>Ces informations déterminent les coefficients de calcul CEE applicables.</p>
          </div>

          <div class="cee-card-body">
            <label class="cee-label">Type de bâtiment</label>
            <div class="cee-grid-6">
              <template x-for="type in buildingTypes" :key="type.id">
                <button
                  @click="form.buildingType = type.id"
                  class="cee-choice"
                  :class="{ 'is-selected': form.buildingType === type.id }">
                  <span style="font-size:24px;" x-text="type.icon"></span>
                  <span class="cee-choice-label" x-text="type.label"></span>
                </button>
              </template>
            </div>
            <p x-show="errors.buildingType" x-text="errors.buildingType" class="cee-error"></p>

            <div style="margin-bottom:24px;">
              <label class="cee-label">Surface totale chauffée</label>
              <div class="cee-input-wrap" style="max-width:280px;">
                <input type="number" x-model.number="form.surface" min="100" max="500000" placeholder="5 000"
                  class="cee-input" :class="{ 'has-error': errors.surface }">
                <span class="cee-input-suffix">m²</span>
              </div>
              <p x-show="errors.surface" x-text="errors.surface" class="cee-error"></p>
            </div>

            <label class="cee-label">Où se situe votre bâtiment ?</label>
            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;">
              <button @click="form.climateZone = 'H1'" class="cee-zone" :class="{ 'is-selected': form.climateZone === 'H1' }">
                <span style="font-size:22px;">❄️</span>
                <span class="cee-zone-id">Nord &amp; Est</span>
                <span class="cee-zone-cities">Paris, Lille, Strasbourg, Lyon, Dijon...</span>
                <span class="cee-zone-tag">Zone H1</span>
                <span class="cee-zone-depts">01, 02, 03, 05, 08, 10, 14, 15, 19, 21, 23, 25, 27, 28, 38, 39, 42, 43, 45, 51, 52, 54, 55, 57, 58, 59, 60, 61, 62, 63, 67, 68, 69, 70, 71, 73, 74, 75, 76, 77, 78, 80, 87, 88, 89, 90, 91, 92, 93, 94, 95</span>
              </button>
              <button @click="form.climateZone = 'H2'" class="cee-zone" :class="{ 'is-selected': form.climateZone === 'H2' }">
                <span style="font-size:22px;">🌤️</span>
                <span class="cee-zone-id">Ouest &amp; Centre</span>
                <span class="cee-zone-cities">Nantes, Bordeaux, Toulouse, Rennes, Limoges...</span>
                <span class="cee-zone-tag">Zone H2</span>
                <span class="cee-zone-depts">04, 07, 09, 12, 16, 17, 18, 22, 24, 26, 29, 31, 32, 33, 35, 36, 37, 40, 41, 44, 46, 47, 48, 49, 50, 53, 56, 64, 65, 72, 79, 81, 82, 84, 85, 86</span>
              </button>
              <button @click="form.climateZone = 'H3'" class="cee-zone" :class="{ 'is-selected': form.climateZone === 'H3' }">
                <span style="font-size:22px;">☀️</span>
                <span class="cee-zone-id">Méditerranée</span>
                <span class="cee-zone-cities">Marseille, Nice, Montpellier, Perpignan...</span>
                <span class="cee-zone-tag">Zone H3</span>
                <span class="cee-zone-depts">06, 11, 13, 30, 34, 66, 83</span>
              </button>
              <button @click="form.climateZone = 'DOM'" class="cee-zone" :class="{ 'is-selected': form.climateZone === 'DOM' }">
                <span style="font-size:22px;">🌴</span>
                <span class="cee-zone-id">Corse &amp; Outre-mer</span>
                <span class="cee-zone-cities">Ajaccio, Bastia, Guadeloupe, Martinique, Guyane, Réunion, Mayotte...</span>
                <span class="cee-zone-tag">Zone DOM</span>
                <span class="cee-zone-depts">2A, 2B, 971, 972, 973, 974, 976</span>
              </button>
            </div>
            <p x-show="errors.climateZone" x-text="errors.climateZone" class="cee-error"></p>
          </div>

          <div class="cee-card-footer">
            <div></div>
            <button @click="validateStep1()" class="cee-btn-primary">
              Continuer
              <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
          </div>
        </div>
      </div>

      {{-- ── ÉTAPE 2 : Équipements ── --}}
      <div x-show="step === 2"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 translate-y-4"
           x-transition:enter-end="opacity-100 translate-y-0">
        <div class="cee-card">
          <div class="cee-card-header">
            <h2>Configurez votre projet</h2>
            <p>Sélectionnez les fiches CEE applicables et les usages concernés.</p>
          </div>

          <div class="cee-card-body">

            {{-- BAT-TH-116 --}}
            <div class="cee-fiche-toggle is-active" x-show="form.buildingType !== 'sport'">
              <div style="margin-bottom:20px;">
                <p style="font-size:15px;font-weight:600;color:var(--color-dark-900);">BAT-TH-116 — Système de GTB pour le chauffage, l'ECS, le refroidissement/climatisation, l'éclairage et les auxiliaires</p>
                <p style="font-size:13px;color:var(--color-dark-500);line-height:1.5;">Installation ou amélioration d'un système de gestion technique du bâtiment (durée de vie : 15 ans)</p>
              </div>

              <div>
                <label class="cee-label">Classe GTB visée (NF EN ISO 52120-1 : 2022)</label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;max-width:320px;margin-bottom:24px;">
                  <button @click="form.gtbClass = 'A'" class="cee-zone" :class="{ 'is-selected': form.gtbClass === 'A' }">
                    <span class="cee-zone-id">Classe A</span>
                    <span class="cee-zone-desc">Haute performance</span>
                  </button>
                  <button @click="form.gtbClass = 'B'" class="cee-zone" :class="{ 'is-selected': form.gtbClass === 'B' }">
                    <span class="cee-zone-id">Classe B</span>
                    <span class="cee-zone-desc">Avancée</span>
                  </button>
                </div>

                <label class="cee-label">Usages gérés par la GTB</label>
                <div class="cee-grid-6" style="margin-bottom:8px;">
                  <template x-for="usage in usageList" :key="usage.id">
                    <button
                      @click="if(isUsageAvailable116(usage.id)) form.usages116[usage.id] = !form.usages116[usage.id]"
                      class="cee-equip"
                      :class="{ 'is-selected': form.usages116[usage.id] && isUsageAvailable116(usage.id), 'is-disabled': !isUsageAvailable116(usage.id) }"
                      :disabled="!isUsageAvailable116(usage.id)">
                      <div class="cee-equip-check">
                        <svg x-show="form.usages116[usage.id] && isUsageAvailable116(usage.id)" style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                      </div>
                      <span style="font-size:22px;" x-text="usage.icon"></span>
                      <span class="cee-equip-label" x-text="usage.label"></span>
                      <span class="cee-equip-fiche" x-text="isUsageAvailable116(usage.id) ? getMontant116(usage.id) + ' kWh/m²' : 'Non applicable'"></span>
                    </button>
                  </template>
                </div>
                <p x-show="errors.usages116" x-text="errors.usages116" class="cee-error" style="margin-bottom:12px;"></p>
              </div>
            </div>

            {{-- Info autres fiches --}}
            <div class="cee-disclaimer" style="margin-top:20px;">
              <svg style="width:18px;height:18px;color:#3b82f6;flex-shrink:0;margin-top:2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              <div>
                <p style="font-weight:600;color:#1e40af;font-size:13px;margin-bottom:4px;">Autres fiches CEE éligibles</p>
                <p style="font-size:13px;color:#1e3a5f;line-height:1.6;">D'autres fiches CEE peuvent s'appliquer à votre projet : BAT-SE-104 (CPE Services), BAT-TH-145 (Optimisation climatisation), BAT-EQ-127 (Éclairage), etc. <a href="{{ route('front.contact') }}" style="color:var(--color-accent-600);font-weight:500;text-decoration:underline;">Contactez-nous</a> pour une étude complète.</p>
              </div>
            </div>

          </div>

          <div class="cee-card-footer">
            <button @click="step = 1" class="cee-btn-ghost">
              <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
              Précédent
            </button>
            <button @click="validateStep2()" class="cee-btn-accent">
              Calculer mes CEE
              <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </button>
          </div>
        </div>
      </div>

      {{-- ── ÉTAPE 3 : Résultats ── --}}
      <div x-show="step === 3"
           x-transition:enter="transition ease-out duration-500"
           x-transition:enter-start="opacity-0 scale-95"
           x-transition:enter-end="opacity-100 scale-100">

        {{-- Avertissement barèmes --}}
        <div style="background:#FFF7ED;border:1px solid #FED7AA;border-radius:10px;padding:12px 16px;margin-bottom:16px;">
          <p style="font-size:12px;color:#78350F;line-height:1.5;">Barèmes CEE basés sur les fiches BAT-TH-116 en vigueur. <strong>Dernière mise à jour : avril 2026.</strong> Les montants et conditions d'éligibilité évoluent régulièrement — vérifiez auprès de votre obligé avant engagement.</p>
        </div>

        {{-- BAT-TH-116 Résultats --}}
        <div x-show="results.th116.total > 0">
          <div class="cee-results-hero">
            <div class="cee-kpi cee-kpi-primary">
              <p class="cee-kpi-label">BAT-TH-116 — Volume CEE</p>
              <p class="cee-kpi-value" x-text="formatMwh(results.th116.total)"></p>
              <p class="cee-kpi-sub">cumac · Classe <span x-text="form.gtbClass"></span> · Durée de vie 15 ans</p>
            </div>
            <div class="cee-kpi cee-kpi-accent">
              <p class="cee-kpi-label">Valeur financière estimée</p>
              <p class="cee-kpi-value" x-text="formatCurrency(results.th116.value)"></p>
              <p class="cee-kpi-sub" x-text="formatCurrency(results.th116.value * 0.75) + ' — ' + formatCurrency(results.th116.value * 1.25)"></p>
            </div>
          </div>

          <div class="cee-card" style="margin-top:20px;">
            <div class="cee-card-header"><h2>Détail BAT-TH-116 par usage</h2></div>
            <div class="cee-card-body" style="padding-top:0;">
              <template x-for="d in results.th116.details" :key="d.id">
                <div class="cee-result-row">
                  <div style="display:flex;align-items:center;gap:12px;">
                    <span style="font-size:20px;" x-text="d.icon"></span>
                    <p class="cee-result-name" x-text="d.label"></p>
                  </div>
                  <div style="text-align:right;">
                    <p class="cee-result-gwh" x-text="formatMwh(d.mwh)"></p>
                    <p class="cee-result-value" x-text="formatCurrency(d.value)"></p>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>

        {{-- Avertissement estimation --}}
        <div class="cee-disclaimer" style="margin-top:20px;">
          <svg style="width:18px;height:18px;color:#b45309;flex-shrink:0;margin-top:2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
          <div>
            <p style="font-weight:600;color:#92400e;font-size:13px;margin-bottom:4px;">Estimation indicative</p>
            <p style="font-size:13px;color:#78350f;line-height:1.6;">Calculs basés sur la fiche officielle BAT-TH-116 (v. A62.6). Les volumes réels dépendent du respect des critères d'éligibilité et d'un dossier complet. D'autres fiches CEE (BAT-SE-104, BAT-TH-145, BAT-EQ-127...) peuvent compléter votre projet. NeoGTB ne perçoit aucune commission.</p>
          </div>
        </div>

        {{-- Paramètres utilisés --}}
        <div class="cee-card" style="margin-top:20px;">
          <div class="cee-card-header"><h2>Paramètres utilisés</h2></div>
          <div class="cee-card-body" style="padding-top:0;">
            <div class="cee-params-grid">
              <div class="cee-param">
                <span class="cee-param-label">Secteur</span>
                <span class="cee-param-value" x-text="getBuildingTypeLabel()"></span>
              </div>
              <div class="cee-param">
                <span class="cee-param-label">Surface</span>
                <span class="cee-param-value" x-text="formatNumber(form.surface) + ' m²'"></span>
              </div>
              <div class="cee-param">
                <span class="cee-param-label">Zone climatique</span>
                <span class="cee-param-value" x-text="form.climateZone"></span>
              </div>
              <div class="cee-param">
                <span class="cee-param-label">Classe GTB</span>
                <span class="cee-param-value" x-text="'Classe ' + form.gtbClass"></span>
              </div>
            </div>
          </div>
        </div>

        {{-- Actions --}}
        <div class="cee-actions" x-show="results.th116.total > 0">
          <button @click="downloadPDF()" class="cee-btn-primary" style="flex:1;">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Télécharger PDF
          </button>
          <a href="{{ route('front.contact') }}" class="cee-btn-accent" style="flex:1;text-decoration:none;text-align:center;justify-content:center;">
            Être contacté
          </a>
          <button @click="emailResults()" class="cee-btn-ghost" style="flex:1;">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Recevoir par email
          </button>
          <button @click="step = 1; resetResults()" class="cee-btn-ghost" style="flex:1;">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Nouvelle simulation
          </button>
        </div>

        {{-- Modal email --}}
        <div x-show="showEmailModal" x-transition.opacity class="cee-modal-overlay">
          <div @click.outside="showEmailModal = false" class="cee-modal">
            <h3 style="font-size:18px;font-weight:500;color:var(--color-dark-900);margin-bottom:16px;">Recevoir mon estimation</h3>
            <input type="email" x-model="emailAddress" placeholder="votre@email.com" class="cee-input" style="margin-bottom:12px;">
            <input type="text" name="_gotcha" style="display:none;" tabindex="-1" autocomplete="off">

            <div style="font-size:10.5px;color:var(--color-dark-400);line-height:1.6;margin-bottom:12px;padding:10px 12px;border-left:2px solid var(--color-dark-200);background:var(--color-dark-50);border-radius:0 6px 6px 0;">
              <p style="margin:0 0 4px;font-weight:600;color:var(--color-dark-600);">Information RGPD (art. 13)</p>
              <p style="margin:0;">Responsable : NeoGTB. <strong>Finalité</strong> : envoi de votre estimation CEE personnalisée et suivi conseil. <strong>Base légale</strong> : consentement. <strong>Durée de conservation</strong> : 3 ans à compter du dernier contact. Vous disposez d'un droit d'accès, de rectification, d'effacement, de limitation, d'opposition et de portabilité, ainsi que du droit de retirer votre consentement à tout moment, via <a href="/mes-droits-rgpd" style="color:var(--color-accent-600);">/mes-droits-rgpd</a>. Détails : <a href="/politique-de-confidentialite" style="color:var(--color-accent-600);">politique de confidentialité</a>.</p>
            </div>

            <label class="flex items-start gap-2 cursor-pointer" style="margin-bottom:16px;">
              <input type="checkbox" x-model="consentRgpd" required class="mt-0.5 rounded border-dark-300 text-accent-600 focus:ring-accent-500" />
              <span class="text-[11px] text-dark-400 leading-relaxed">
                J'accepte que mon email soit traité par NeoGTB pour recevoir mon estimation CEE (consentement, art. 6.1.a RGPD). <span style="color:#dc2626;">*</span>
              </span>
            </label>

            <div style="display:flex;gap:12px;">
              <button @click="showEmailModal = false" class="cee-btn-ghost" style="flex:1;">Annuler</button>
              <button @click="sendEmail()" class="cee-btn-primary" style="flex:1;" :disabled="!consentRgpd" :style="!consentRgpd ? 'flex:1;opacity:0.5;cursor:not-allowed;' : 'flex:1;'">Envoyer</button>
            </div>
            <p x-show="emailSent" style="margin-top:12px;font-size:13px;color:var(--color-accent-600);font-weight:500;text-align:center;">Email envoyé ✓</p>
          </div>
        </div>

      </div>{{-- /step 3 --}}

    </div>
  </section>

  {{-- ── Trust badge ── --}}
  <section style="padding:48px 0 64px;background:var(--color-dark-50);border-top:1px solid var(--color-dark-200);">
    <div style="max-width:600px;margin:0 auto;padding:0 24px;text-align:center;">
      <div style="display:inline-flex;align-items:center;gap:10px;padding:10px 20px;border-radius:100px;background:white;border:1px solid var(--color-dark-200);">
        <svg style="width:18px;height:18px;color:var(--color-accent-600);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        <span style="font-size:13px;font-weight:500;color:var(--color-dark-700);">Outil indépendant — NeoGTB ne perçoit aucune commission sur les CEE</span>
      </div>
    </div>
  </section>

  {{-- ── Pages liées ── --}}
  <section style="padding:48px 0;background:white;border-top:1px solid var(--color-dark-100);">
    <div style="max-width:720px;margin:0 auto;padding:0 24px;">
      <p style="font-size:12px;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:var(--color-dark-400);margin-bottom:24px;">Pages liées</p>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
        <a href="{{ route('front.audit') }}" style="display:block;padding:20px;border-radius:12px;border:1px solid var(--color-dark-200);text-decoration:none;transition:border-color 0.2s,background 0.2s;" onmouseover="this.style.borderColor='var(--color-accent-500)';this.style.background='rgba(13,148,136,0.02)'" onmouseout="this.style.borderColor='var(--color-dark-200)';this.style.background='white'">
          <p style="font-size:14px;font-weight:500;color:var(--color-dark-900);margin-bottom:4px;">Audit GTB gratuit</p>
          <p style="font-size:13px;color:var(--color-dark-500);line-height:1.5;">Évaluez la maturité GTB de votre bâtiment en 5 minutes.</p>
        </a>
        <a href="{{ route('front.reglementation') }}" style="display:block;padding:20px;border-radius:12px;border:1px solid var(--color-dark-200);text-decoration:none;transition:border-color 0.2s,background 0.2s;" onmouseover="this.style.borderColor='var(--color-accent-500)';this.style.background='rgba(13,148,136,0.02)'" onmouseout="this.style.borderColor='var(--color-dark-200)';this.style.background='white'">
          <p style="font-size:14px;font-weight:500;color:var(--color-dark-900);margin-bottom:4px;">Réglementation GTB</p>
          <p style="font-size:13px;color:var(--color-dark-500);line-height:1.5;">Décret BACS, CEE BAT-TH-116 — tout le cadre légal.</p>
        </a>
        <a href="{{ route('front.comparateur') }}" style="display:block;padding:20px;border-radius:12px;border:1px solid var(--color-dark-200);text-decoration:none;transition:border-color 0.2s,background 0.2s;" onmouseover="this.style.borderColor='var(--color-accent-500)';this.style.background='rgba(13,148,136,0.02)'" onmouseout="this.style.borderColor='var(--color-dark-200)';this.style.background='white'">
          <p style="font-size:14px;font-weight:500;color:var(--color-dark-900);margin-bottom:4px;">Comparateur de solutions</p>
          <p style="font-size:13px;color:var(--color-dark-500);line-height:1.5;">Comparez les marques GTB pour votre projet.</p>
        </a>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('ceeGenerator', () => ({
      step: 1,
      errors: {},
      showEmailModal: false,
      emailAddress: '',
      emailSent: false,
      consentRgpd: false,

      buildingTypes: [
        { id: 'office',     label: 'Bureaux',                   icon: '🏢' },
        { id: 'education',  label: 'Enseignement',              icon: '🏫' },
        { id: 'commercial', label: 'Commerce',                  icon: '🛒' },
        { id: 'hotel',      label: 'Hôtellerie / Restauration', icon: '🏨' },
        { id: 'health',     label: 'Santé',                     icon: '🏥' },
      ],

      usageList: [
        { id: 'heating',   label: 'Chauffage',              icon: '🌡️' },
        { id: 'cooling',   label: 'Refroidissement / Clim', icon: '❄️' },
        { id: 'ecs',       label: 'Eau chaude sanitaire',   icon: '🚿' },
        { id: 'lighting',  label: 'Éclairage',              icon: '💡' },
        { id: 'auxiliary', label: 'Auxiliaires',            icon: '⚙️' },
      ],

      // ══════════════════════════════════════════════
      // BAT-TH-116 — Tableaux officiels (kWh cumac / m²)
      // NF EN ISO 52120-1 : 2022 — v. A62.6
      // ══════════════════════════════════════════════
      th116: {
        A: {
          office:     { heating: 360, cooling: 233, ecs: 15,  lighting: 184,  auxiliary: 19 },
          education:  { heating: 170, cooling: 60,  ecs: 30,  lighting: 46,   auxiliary: 6  },
          commercial: { heating: 520, cooling: 150, ecs: 32,  lighting: null, auxiliary: 6  },
          hotel:      { heating: 400, cooling: 60,  ecs: 87,  lighting: 65,   auxiliary: 6  },
          health:     { heating: 150, cooling: 60,  ecs: 82,  lighting: null, auxiliary: 19 },
        },
        B: {
          office:     { heating: 240, cooling: 97,  ecs: 7,   lighting: 90,   auxiliary: 8  },
          education:  { heating: 100, cooling: 23,  ecs: 13,  lighting: 21,   auxiliary: 3  },
          commercial: { heating: 250, cooling: 44,  ecs: 14,  lighting: null, auxiliary: 3  },
          hotel:      { heating: 200, cooling: 23,  ecs: 40,  lighting: 30,   auxiliary: 3  },
          health:     { heating: 90,  cooling: 23,  ecs: 38,  lighting: null, auxiliary: 9  },
        },
      },

      // Coefficients zone climatique BAT-TH-116
      zoneCoeff116: { H1: 1.1, H2: 0.9, H3: 0.6, DOM: 1.2 },

      form: {
        buildingType: '',
        surface: null,
        climateZone: '',
        gtbClass: 'A',
        usages116: { heating: true, cooling: false, ecs: false, lighting: false, auxiliary: false },
      },

      results: {
        th116: { total: 0, value: 0, details: [] },
        price: 7,
      },

      init() {
        const diagMap = { bureau: 'office', commerce: 'commercial', industrie: 'office', sante: 'health', education: 'education', hotel: 'hotel' };
        const params = new URLSearchParams(window.location.search);
        let src = {};
        if (params.get('type') || params.get('surface')) {
          src = {
            buildingType: params.get('type') || '',
            surface:      params.get('surface') ? Number(params.get('surface')) : null,
            climateZone:  params.get('zone') || ''
          };
        } else {
          try {
            const d = JSON.parse(localStorage.getItem('neogtb_diag') || '{}');
            if (d.buildingType) src = d;
          } catch(e) {}
        }
        if (src.buildingType) {
          this.form.buildingType = diagMap[src.buildingType] || src.buildingType;
          if (src.surface)     this.form.surface     = src.surface;
          if (src.climateZone) this.form.climateZone = src.climateZone;
        }
      },

      isUsageAvailable116(usageId) {
        const bt = this.form.buildingType;
        if (!bt || bt === 'sport') return false;
        const table = this.th116[this.form.gtbClass];
        if (!table || !table[bt]) return false;
        return table[bt][usageId] !== null && table[bt][usageId] !== undefined;
      },

      getMontant116(usageId) {
        const bt = this.form.buildingType;
        if (!bt || bt === 'sport') return 0;
        const table = this.th116[this.form.gtbClass];
        if (!table || !table[bt]) return 0;
        return table[bt][usageId] || 0;
      },

      getBuildingTypeLabel() {
        const t = this.buildingTypes.find(b => b.id === this.form.buildingType);
        return t ? t.label : '';
      },

      formatNumber(n) {
        if (!n && n !== 0) return '0';
        return new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 0 }).format(Math.round(n));
      },

      formatMwh(mwh) {
        if (!mwh) return '0 MWh';
        if (mwh >= 1000) return new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 2 }).format(mwh / 1000) + ' GWh';
        return new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 0 }).format(Math.round(mwh)) + ' MWh';
      },

      formatCurrency(n) {
        return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR', maximumFractionDigits: 0 }).format(n);
      },

      validateStep1() {
        this.errors = {};
        if (!this.form.buildingType)                        this.errors.buildingType = 'Sélectionnez un secteur';
        if (!this.form.surface || this.form.surface < 100)  this.errors.surface      = 'Surface minimale : 100 m²';
        if (!this.form.climateZone)                         this.errors.climateZone  = 'Sélectionnez une zone';
        if (Object.keys(this.errors).length === 0) { this.step = 2; }
      },

      validateStep2() {
        this.errors = {};
        if (this.form.buildingType !== 'sport') {
          const hasUsage = Object.values(this.form.usages116).some(v => v);
          if (!hasUsage) { this.errors.usages116 = 'Sélectionnez au moins un usage'; return; }
        }
        this.calculateResults();
        this.step = 3;
      },

      calculateResults() {
        const price = 7; // €/MWh cumac (moyenne marché)
        const s     = this.form.surface;
        const zone  = this.form.climateZone;

        // ── BAT-TH-116 ──
        let th116Total   = 0;
        let th116Details = [];
        if (this.form.buildingType !== 'sport') {
          const zc    = this.zoneCoeff116[zone] || 1;
          const table = this.th116[this.form.gtbClass]?.[this.form.buildingType];
          if (table) {
            const labels = { heating: 'Chauffage', cooling: 'Refroidissement / Clim', ecs: 'Eau chaude sanitaire', lighting: 'Éclairage', auxiliary: 'Auxiliaires' };
            const icons  = { heating: '🌡️', cooling: '❄️', ecs: '🚿', lighting: '💡', auxiliary: '⚙️' };
            for (const [uid, enabled] of Object.entries(this.form.usages116)) {
              if (enabled && table[uid] != null) {
                const montant = table[uid];
                const mwh     = montant * zc * s / 1000;
                th116Total   += mwh;
                th116Details.push({ id: uid, label: labels[uid], icon: icons[uid], montant, mwh, value: mwh * price });
              }
            }
          }
        }

        this.results = {
          th116: { total: th116Total, value: th116Total * price, details: th116Details },
          price,
        };
      },

      async downloadPDF() {
        const { jsPDF } = await import('jspdf');
        const doc = new jsPDF();
        const m = 20, pw = 170;
        let y = m;

        const logoImg = new Image();
        logoImg.src = '/images/logo-neogtb-pdf.png';
        await new Promise(r => { logoImg.onload = r; logoImg.onerror = r; });

        // ── HEADER ──
        doc.setFillColor(27, 58, 92);
        doc.rect(0, 0, 210, 45, 'F');
        try { doc.addImage(logoImg, 'PNG', m, 8, 30, 30); } catch(e) {}
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(20); doc.text('NeoGTB', m + 35, 22);
        doc.setFontSize(9); doc.setTextColor(180, 200, 220);
        doc.text('Conseil indépendant en Gestion Technique du Bâtiment', m + 35, 30);
        doc.text('neogtb.fr  |  hello@neogtb.fr  |  06 50 14 32 52', m + 35, 37);
        doc.setFontSize(8); doc.setTextColor(140, 170, 200);
        doc.text(new Date().toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }), 190, 37, { align: 'right' });

        y = 55;

        // ── TITLE ──
        doc.setFontSize(18); doc.setTextColor(15, 23, 42);
        doc.text("Estimation Certificats d'Économies d'Énergie (CEE)", m, y);
        y += 5;
        doc.setDrawColor(13, 148, 136); doc.setLineWidth(1.5); doc.line(m, y, m + 60, y);
        y += 15;

        // ── PARAMETRES ──
        doc.setFillColor(248, 250, 252);
        doc.roundedRect(m, y, pw, 28, 4, 4, 'F');
        doc.setFontSize(9);
        const pdfParams = [
          ['Secteur',         this.getBuildingTypeLabel()],
          ['Surface',         this.formatNumber(this.form.surface) + ' m\u00B2'],
          ['Zone climatique', this.form.climateZone + ' (coeff. ' + (this.zoneCoeff116[this.form.climateZone] || '') + ')'],
        ];
        let py = y + 10;
        for (const [label, val] of pdfParams) {
          doc.setTextColor(100, 116, 139); doc.text(label,  m + 5,  py);
          doc.setTextColor(15, 23, 42);   doc.text(val,    m + 55, py);
          py += 6;
        }
        y += 36;

        // ── BAT-TH-116 ──
        if (this.results.th116.total > 0) {
          doc.setFillColor(240, 253, 250);
          doc.roundedRect(m, y, 80, 30, 4, 4, 'F');
          doc.setDrawColor(13, 148, 136); doc.setLineWidth(0.3);
          doc.roundedRect(m, y, 80, 30, 4, 4, 'S');
          doc.setFontSize(7); doc.setTextColor(13, 148, 136); doc.text('BAT-TH-116 — CLASSE ' + this.form.gtbClass, m + 5, y + 8);
          doc.setFontSize(16); doc.setTextColor(15, 23, 42);
          doc.text(this.formatMwh(this.results.th116.total), m + 5, y + 20);
          doc.setFontSize(8); doc.setTextColor(100, 116, 139); doc.text('cumac · 15 ans', m + 5, y + 26);

          doc.setFillColor(13, 148, 136);
          doc.roundedRect(m + 85, y, 85, 30, 4, 4, 'F');
          doc.setFontSize(7); doc.setTextColor(180, 240, 220); doc.text('VALEUR ESTIMÉE', m + 90, y + 8);
          doc.setFontSize(18); doc.setTextColor(255, 255, 255);
          doc.text(this.formatCurrency(this.results.th116.value), m + 90, y + 21);
          doc.setFontSize(8); doc.setTextColor(180, 240, 220);
          doc.text(this.formatCurrency(this.results.th116.value * 0.75) + ' - ' + this.formatCurrency(this.results.th116.value * 1.25), m + 90, y + 27);
          y += 38;

          // Tableau détail
          doc.setFillColor(27, 58, 92);
          doc.roundedRect(m, y, pw, 8, 2, 2, 'F');
          doc.setFontSize(8); doc.setTextColor(255, 255, 255);
          doc.text('USAGE',         m + 3, y + 5.5);
          doc.text('kWh/m\u00B2',  90,    y + 5.5);
          doc.text('MWh CUMAC',    120,    y + 5.5);
          doc.text('VALEUR',       160,    y + 5.5);
          y += 11;
          doc.setFontSize(9);
          let ri = 0;
          for (const d of this.results.th116.details) {
            if (ri % 2 === 0) { doc.setFillColor(248, 250, 252); doc.rect(m, y - 4, pw, 8, 'F'); }
            doc.setTextColor(15, 23, 42);    doc.text(d.label,                       m + 3, y);
            doc.setTextColor(100, 116, 139); doc.text(String(d.montant),              90,    y);
            doc.setTextColor(15, 23, 42);    doc.text(this.formatMwh(d.mwh),          120,   y);
            doc.setTextColor(13, 148, 136);  doc.text(this.formatCurrency(d.value),   160,   y);
            y += 8; ri++;
          }
          y += 8;
        }

        // ── DISCLAIMER ──
        if (y > 250) { doc.addPage(); y = 20; }
        doc.setFillColor(255, 251, 235);
        doc.roundedRect(m, y, pw, 22, 4, 4, 'F');
        doc.setDrawColor(245, 158, 11); doc.setLineWidth(0.3);
        doc.roundedRect(m, y, pw, 22, 4, 4, 'S');
        doc.setFontSize(8); doc.setTextColor(146, 64, 14);
        doc.text('ESTIMATION INDICATIVE', m + 5, y + 7);
        doc.setTextColor(120, 80, 20);
        doc.text('Calculs basés sur la fiche officielle BAT-TH-116 (v. A62.6).', m + 5, y + 13);
        doc.text('NeoGTB ne perçoit aucune commission sur les CEE. Indépendance totale.', m + 5, y + 18);

        // ── FOOTER ──
        doc.setFillColor(27, 58, 92);
        doc.rect(0, 282, 210, 15, 'F');
        doc.setFontSize(7); doc.setTextColor(180, 200, 220);
        doc.text('NeoGTB — neogtb.fr — Conseil indépendant en GTB — EYNOR EURL, Eysines (33)', 105, 289, { align: 'center' });
        doc.setTextColor(140, 170, 200);
        doc.text('Ce document ne constitue pas un engagement contractuel.', 105, 293, { align: 'center' });

        doc.save('estimation-cee-neogtb.pdf');
      },

      emailResults() { this.showEmailModal = true; this.emailSent = false; },

      async sendEmail() {
        if (!this.emailAddress || !this.emailAddress.includes('@')) return;
        if (!this.consentRgpd) return;
        try {
          const payload = {
            email:             this.emailAddress,
            th116_mwh:         this.results.th116.total,
            th116_value:       this.results.th116.value,
            sector:            this.getBuildingTypeLabel(),
            surface:           this.form.surface,
            climate_zone:      this.form.climateZone,
            consentement_rgpd: this.consentRgpd,
            payload:           { form: this.form, results: this.results },
          };
          await fetch('/cee/lead', {
            method: 'POST',
            body: JSON.stringify(payload),
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '',
              'X-Requested-With': 'XMLHttpRequest',
            }
          });
          this.emailSent = true;
          setTimeout(() => { this.showEmailModal = false; this.emailSent = false; }, 2000);
        } catch(e) {}
      },

      resetResults() {
        this.results = { th116: { total: 0, value: 0, details: [] }, price: 7 };
        this.errors  = {};
        this.form    = {
          buildingType: '', surface: null, climateZone: '', gtbClass: 'A',
          usages116: { heating: true, cooling: false, ecs: false, lighting: false, auxiliary: false }
        };
      },
    }));
  });
</script>
@endpush
