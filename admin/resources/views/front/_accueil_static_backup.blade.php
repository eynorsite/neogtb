@extends('front.layouts.app')

{{-- Styles partagés extraits vers resources/css/front/home-components.css (phase 2 audit NeoGTB) --}}

@section('title', 'NeoGTB — Conseil GTB indépendant | Pré-diagnostic ISO 52120 gratuit')

@section('description', 'Pré-diagnostic ISO 52120-1 gratuit et comparateur GTB sans biais commercial. En moyenne 23 % d\'économies CVC sur bureaux classe D→B.')

@section('content')

  <!-- ==================== HERO ==================== -->
  <section class="hero-img" style="position: relative; min-height: 520px; display: flex; align-items: center; overflow: hidden;">
    <img
      src="/images/hero-neogtb.webp"
      alt="Salle de contrôle NéoGTB — supervision technique du bâtiment"
      width="1200"
      height="630"
      loading="eager"
      fetchpriority="high"
      style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center;"
    />
    <div style="position: absolute; inset: 0; background: linear-gradient(to left, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.45) 50%, rgba(0,0,0,0.1) 100%);"></div>

    <div class="max-w-[1200px] mx-auto px-6 md:px-10 relative z-10" style="width: 100%;">
      <div style="max-width: 560px; margin-left: auto;">
        <p style="display: inline-flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 500; color: rgba(255,255,255,0.85); background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); padding: 5px 14px; border-radius: 20px; border: 0.5px solid rgba(255,255,255,0.15); margin-bottom: 24px;">
          Décret BACS 2030 · Êtes-vous en conformité ?
        </p>

        <p style="font-size: 22px; font-weight: 500; color: rgba(255,255,255,0.7); letter-spacing: -0.02em; margin-bottom: 12px;">
          Néo<span style="font-weight: 500; color: #fff;">GTB</span>
        </p>

        <h1 style="font-size: clamp(32px, 4.5vw, 48px); font-weight: 500; line-height: 1.1; letter-spacing: -0.03em; color: #fff; margin-bottom: 20px;">
          Votre bâtiment consomme trop. On vous montre où et pourquoi.
        </h1>

        <p style="font-size: 15px; color: rgba(255,255,255,0.65); line-height: 1.7; max-width: 440px; margin-bottom: 32px;">
          Pré-diagnostic ISO 52120-1 gratuit, comparateur de solutions sans biais commercial. Les gestionnaires qui nous consultent identifient en moyenne 23 % d'économies CVC sur des bureaux passant de classe D à B.
        </p>

        <!-- Stats d'impact -->
        <div class="flex flex-wrap gap-6" style="margin-bottom: 32px;">
          <div style="min-width: 120px;">
            <p style="font-size: 22px; font-weight: 600; color: #fff; letter-spacing: -0.02em; line-height: 1;">23 %</p>
            <p style="font-size: 12px; color: rgba(255,255,255,0.5); margin-top: 4px; line-height: 1.4;">d'économies CVC en moyenne (bureaux, D→B)</p>
          </div>
          <div style="min-width: 120px;">
            <p style="font-size: 22px; font-weight: 600; color: #fff; letter-spacing: -0.02em; line-height: 1;">10+</p>
            <p style="font-size: 12px; color: rgba(255,255,255,0.5); margin-top: 4px; line-height: 1.4;">fabricants évalués sans lien commercial</p>
          </div>
          <div style="min-width: 120px;">
            <p style="font-size: 22px; font-weight: 600; color: #fff; letter-spacing: -0.02em; line-height: 1;">0 €</p>
            <p style="font-size: 12px; color: rgba(255,255,255,0.5); margin-top: 4px; line-height: 1.4;">commission — jamais</p>
          </div>
        </div>

        <div class="flex flex-wrap items-center gap-4">
          <a href="/audit" class="btn-primary">
            Évaluer mon bâtiment
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </a>
          <a href="/comparateur" style="font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.85); text-decoration: none; transition: color 0.15s; border-bottom: 1px solid rgba(255,255,255,0.3);">
            Comparer les solutions GTB →
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== IMPACT BAR ==================== -->
  <section style="padding: 20px 0; border-bottom: 1px solid var(--color-dark-200);">
    <div class="max-w-[1200px] mx-auto px-6 md:px-10">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 text-center">
        <div style="padding: 8px 0;">
          <p style="font-size: 20px; font-weight: 600; color: var(--color-accent-600); letter-spacing: -0.02em;">Classe B min.</p>
          <p style="font-size: 12px; color: var(--color-dark-400); line-height: 1.4; margin-top: 2px;">exigence décret BACS (ISO 52120-1)</p>
        </div>
        <div style="padding: 8px 0;">
          <p style="font-size: 20px; font-weight: 600; color: var(--color-accent-600); letter-spacing: -0.02em;">8+</p>
          <p style="font-size: 12px; color: var(--color-dark-400); line-height: 1.4; margin-top: 2px;">protocoles couverts (BACnet, KNX, Modbus, DALI…)</p>
        </div>
        <div style="padding: 8px 0;">
          <p style="font-size: 20px; font-weight: 600; color: var(--color-accent-600); letter-spacing: -0.02em;">0 €</p>
          <p style="font-size: 12px; color: var(--color-dark-400); line-height: 1.4; margin-top: 2px;">commission fabricant</p>
        </div>
        <div style="padding: 8px 0;">
          <p style="font-size: 20px; font-weight: 600; color: var(--color-accent-600); letter-spacing: -0.02em;">100 %</p>
          <p style="font-size: 12px; color: var(--color-dark-400); line-height: 1.4; margin-top: 2px;">indépendant — aucun lien fabricant</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== POSITIONING ==================== -->
  <section style="padding: 56px 0 64px;">
    <div class="max-w-[1200px] mx-auto px-6 md:px-10">
      <div class="max-w-xl mb-10 reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <p class="eyebrow">Ce que nous faisons</p>
        <h2 style="font-size: clamp(28px, 3vw, 36px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 12px;">Trois outils pour éclairer vos décisions GTB</h2>
        <p style="font-size: 16px; color: var(--color-dark-500); line-height: 1.7;">Gratuit, sans engagement, sans orientation commerciale vers une marque ou un protocole.</p>
      </div>

      <div class="grid md:grid-cols-3 gap-6">
        <a href="/audit" class="card block p-8 reveal" x-data x-intersect.once="$el.classList.add('visible')" style="text-decoration: none;">
          <!-- Icone : gauge/diagnostic -->
          <div style="width: 48px; height: 48px; border-radius: 10px; background: var(--color-accent-50); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-600)" stroke-width="1.5">
              <path d="M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18Z" stroke-linecap="round"/>
              <path d="M12 12l3.5-3.5" stroke-linecap="round" stroke-width="2"/>
              <circle cx="12" cy="12" r="1.5" fill="var(--color-accent-600)" stroke="none"/>
              <path d="M5.5 16.5h2M16.5 16.5h2M12 5.5v2" stroke-linecap="round" opacity="0.4"/>
            </svg>
          </div>
          <h3 style="font-size: 18px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 10px; letter-spacing: -0.01em;">Pré-diagnostic : évaluez la maturité de votre bâtiment</h3>
          <p style="font-size: 14px; color: var(--color-dark-500); line-height: 1.6;">Auto-évaluation en 8 questions basée sur la norme ISO 52120-1. Score immédiat, recommandations par niveau A à D.</p>
          <!-- Mini gauge preview -->
          <div class="gauge-en15232" style="margin-top: 16px;">
            <div class="gauge-en15232-bar level-d dimmed">D</div>
            <div class="gauge-en15232-bar level-c dimmed">C</div>
            <div class="gauge-en15232-bar level-b active">B</div>
            <div class="gauge-en15232-bar level-a dimmed">A</div>
          </div>
          <p style="margin-top: 16px; font-size: 14px; font-weight: 500; color: var(--color-accent-600);">Lancer le pré-diagnostic →</p>
        </a>

        <a href="/comparateur" class="card block p-8 reveal reveal-d1" x-data x-intersect.once="$el.classList.add('visible')" style="text-decoration: none;">
          <!-- Icone : comparaison/barres -->
          <div style="width: 48px; height: 48px; border-radius: 10px; background: var(--color-accent-50); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-600)" stroke-width="1.5">
              <rect x="3" y="14" width="4" height="7" rx="1" fill="var(--color-accent-200)" stroke="var(--color-accent-600)"/>
              <rect x="10" y="8" width="4" height="13" rx="1" fill="var(--color-accent-100)" stroke="var(--color-accent-600)"/>
              <rect x="17" y="3" width="4" height="18" rx="1" fill="var(--color-accent-50)" stroke="var(--color-accent-600)"/>
            </svg>
          </div>
          <h3 style="font-size: 18px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 10px; letter-spacing: -0.01em;">Comparez les technologies sans biais</h3>
          <p style="font-size: 14px; color: var(--color-dark-500); line-height: 1.6;">10 fabricants GTB analysés sur des critères objectifs : protocoles, ouverture, coût, scalabilité.</p>
          <!-- Mini comparateur preview -->
          <div class="comparateur-preview" style="margin-top: 16px;">
            <div class="comparateur-row" style="font-size: 12px;">
              <span style="color: var(--color-dark-500); font-weight: 500;">Siemens</span>
              <div class="comparateur-bar"><div class="comparateur-bar-fill" style="width: 85%;"></div></div>
              <span style="color: var(--color-dark-400); font-size: 11px;">8.5</span>
            </div>
            <div class="comparateur-row" style="font-size: 12px;">
              <span style="color: var(--color-dark-500); font-weight: 500;">Schneider</span>
              <div class="comparateur-bar"><div class="comparateur-bar-fill" style="width: 78%;"></div></div>
              <span style="color: var(--color-dark-400); font-size: 11px;">7.8</span>
            </div>
            <div class="comparateur-row" style="font-size: 12px;">
              <span style="color: var(--color-dark-500); font-weight: 500;">Honeywell</span>
              <div class="comparateur-bar"><div class="comparateur-bar-fill" style="width: 72%;"></div></div>
              <span style="color: var(--color-dark-400); font-size: 11px;">7.2</span>
            </div>
          </div>
          <p style="margin-top: 8px; font-size: 12px; color: var(--color-dark-400);">
            <a href="/comparateur#methodologie" style="color: var(--color-dark-400); text-decoration: underline; text-underline-offset: 2px;">Voir la méthodologie de notation</a>
          </p>
          <p style="margin-top: 12px; font-size: 14px; font-weight: 500; color: var(--color-accent-600);">Comparer les marques →</p>
        </a>

        <a href="/generateur-cee" class="card block p-8 reveal reveal-d2" x-data x-intersect.once="$el.classList.add('visible')" style="text-decoration: none;">
          <!-- Icone : document/calcul CEE -->
          <div style="width: 48px; height: 48px; border-radius: 10px; background: #FFFBEB; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="1.5">
              <rect x="4" y="2" width="16" height="20" rx="2" fill="#FEF3C7" stroke="#D97706"/>
              <path d="M8 7h8M8 11h5" stroke-linecap="round" opacity="0.5"/>
              <circle cx="15" cy="16" r="3.5" fill="#FFFBEB" stroke="#D97706" stroke-width="1.5"/>
              <path d="M15 14.5v1.5h1.5" stroke="#D97706" stroke-linecap="round" stroke-width="1.5"/>
            </svg>
          </div>
          <h3 style="font-size: 18px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 10px; letter-spacing: -0.01em;">Estimez vos aides CEE en 3 minutes</h3>
          <p style="font-size: 14px; color: var(--color-dark-500); line-height: 1.6;">Calcul basé sur les fiches BAT-TH-116 et BAT-TH-112. Estimation indépendante, sans intermédiaire.</p>
          <!-- Mini estimation preview -->
          <div style="margin-top: 16px; padding: 12px; border-radius: 8px; background: #FFFBEB; border: 1px solid #FDE68A;">
            <p style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; color: #D97706; margin-bottom: 4px;">Estimation type</p>
            <p style="font-size: 22px; font-weight: 600; color: #B45309; letter-spacing: -0.02em;">12 400 €</p>
            <p style="font-size: 11px; color: var(--color-dark-400); margin-top: 2px;">pour 5 000 m² tertiaire</p>
            <p style="font-size: 10px; color: var(--color-dark-400); margin-top: 4px; font-style: italic;">Barèmes CEE mis à jour : avril 2026</p>
          </div>
          <p style="margin-top: 16px; font-size: 14px; font-weight: 500; color: var(--color-accent-600);">Estimer mes CEE →</p>
        </a>
      </div>

      <!-- CTA contextuel Positioning -->
      <div class="cta-section-inline reveal" x-data x-intersect.once="$el.classList.add('visible')" style="text-align: center; margin-top: 48px;">
        <p style="font-size: 15px; color: var(--color-dark-500); margin-bottom: 16px;">Vous ne savez pas par où commencer ?</p>
        <a href="/audit" style="font-size: 14px; font-weight: 500; color: var(--color-accent-600); text-decoration: none; border-bottom: 1px solid var(--color-accent-200);">
          Lancer le pré-diagnostic gratuit →
        </a>
      </div>
    </div>
  </section>

  <!-- ==================== METHODOLOGY ==================== -->
  <section style="padding: 56px 0 64px; background: var(--color-dark-50); border-top: 1px solid var(--color-dark-200); border-bottom: 1px solid var(--color-dark-200);">
    <div class="max-w-[1200px] mx-auto px-6 md:px-10">
      <div class="max-w-xl mb-10 reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <p class="eyebrow">Notre approche</p>
        <h2 style="font-size: clamp(28px, 3vw, 36px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 12px;">La méthode NeoGTB — 4 phases</h2>
        <p style="font-size: 16px; color: var(--color-dark-500); line-height: 1.7;">Une approche structurée et reproductible, calibrée sur les exigences du décret BACS et de la norme EN ISO 52120-1.</p>
      </div>

      <!-- Flow technique avec connecteurs -->
      <div class="method-flow reveal" x-data x-intersect.once="$el.classList.add('visible')" style="background: white; border-radius: 12px; border: 1px solid var(--color-dark-200); overflow: hidden;">
        <div class="method-flow-connector" style="top: 44px; left: 12.5%; right: 12.5%;"></div>

        <div class="method-flow-step" style="padding: 28px 16px; border-right: 1px solid var(--color-dark-200);">
          <div class="method-flow-node">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"/></svg>
          </div>
          <h3 style="font-size: 14px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 6px;">État des lieux</h3>
          <p style="font-size: 12px; color: var(--color-dark-500); line-height: 1.5;">Cartographie équipements, protocoles, niveau ISO 52120-1</p>
        </div>

        <div class="method-flow-step" style="padding: 28px 16px; border-right: 1px solid var(--color-dark-200);">
          <div class="method-flow-node">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h4v12H3zM10 3h4v15h-4zM17 9h4v9h-4z" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3 style="font-size: 14px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 6px;">Analyse comparative</h3>
          <p style="font-size: 12px; color: var(--color-dark-500); line-height: 1.5;">Solutions du marché : taille, protocoles, budget, contraintes</p>
        </div>

        <div class="method-flow-step active-step" style="padding: 28px 16px; border-right: 1px solid var(--color-dark-200); background: var(--color-accent-50);">
          <div class="method-flow-node">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3 style="font-size: 14px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 6px;">Recommandations</h3>
          <p style="font-size: 12px; color: var(--color-dark-500); line-height: 1.5;">ROI chiffré, gains énergétiques, calendrier BACS</p>
        </div>

        <div class="method-flow-step" style="padding: 28px 16px;">
          <div class="method-flow-node">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3 style="font-size: 14px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 6px;">Accompagnement</h3>
          <p style="font-size: 12px; color: var(--color-dark-500); line-height: 1.5;">Suivi mise en œuvre, vérification, transfert compétences</p>
        </div>
      </div>

      <!-- Lien contextuel Methodology -->
      <div class="reveal" x-data x-intersect.once="$el.classList.add('visible')" style="text-align: center; margin-top: 32px;">
        <a href="/contact" style="font-size: 14px; font-weight: 500; color: var(--color-accent-600); text-decoration: none; border-bottom: 1px solid var(--color-accent-200);">
          Discuter de mon projet →
        </a>
      </div>
    </div>
  </section>

  <!-- ==================== FONDATEUR ==================== -->
  <section style="padding: 56px 0 64px;">
    <div class="max-w-[1200px] mx-auto px-6 md:px-10">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">

        <!-- Photo + identité -->
        <div class="lg:col-span-4 reveal" x-data x-intersect.once="$el.classList.add('visible')">
          <div class="card p-8" style="text-align: center;">
            <img src="/images/ulrich-calmo.webp" alt="Ulrich Calmo, créateur de la marque NeoGTB" width="120" height="120" loading="lazy" decoding="async" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin: 0 auto 20px; display: block; border: 3px solid var(--color-accent-300);" />
            <p style="font-size: 20px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 4px;">Ulrich Calmo</p>
            <p style="font-size: 14px; color: var(--color-accent-600); font-weight: 500; margin-bottom: 16px;">Créateur de la marque NeoGTB</p>
            <div class="sep" style="margin-bottom: 16px;"></div>
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; text-align: left;">
              <li class="flex items-center gap-3">
                <div style="width: 5px; height: 5px; border-radius: 50%; background: var(--color-accent-500); flex-shrink: 0;"></div>
                <span style="font-size: 13px; color: var(--color-dark-500);">Basé à Eysines, près de Bordeaux</span>
              </li>
              <li class="flex items-center gap-3">
                <div style="width: 5px; height: 5px; border-radius: 50%; background: var(--color-accent-500); flex-shrink: 0;"></div>
                <span style="font-size: 13px; color: var(--color-dark-500);">EYNOR — structure indépendante</span>
              </li>
              <li class="flex items-center gap-3">
                <div style="width: 5px; height: 5px; border-radius: 50%; background: var(--color-accent-500); flex-shrink: 0;"></div>
                <span style="font-size: 13px; color: var(--color-dark-500);">Spécialiste GTB & efficacité énergétique</span>
              </li>
              <li class="flex items-center gap-3">
                <div style="width: 5px; height: 5px; border-radius: 50%; background: var(--color-accent-500); flex-shrink: 0;"></div>
                <span style="font-size: 13px; color: var(--color-dark-500);">+15 ans en CVC/énergie tertiaire</span>
              </li>
              <li class="flex items-center gap-3">
                <div style="width: 5px; height: 5px; border-radius: 50%; background: var(--color-accent-500); flex-shrink: 0;"></div>
                <span style="font-size: 13px; color: var(--color-dark-500);">Ex-directeur général, formateur habilité</span>
              </li>
            </ul>
          </div>
        </div>

        <!-- Texte créateur + modèle économique -->
        <div class="lg:col-span-8 reveal reveal-d1" x-data x-intersect.once="$el.classList.add('visible')">
          <p class="eyebrow">Qui est derrière NeoGTB</p>
          <h2 style="font-size: clamp(28px, 3vw, 36px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 20px;">Je ne suis pas un commercial GTB.<br />Je suis le conseil que j'aurais voulu trouver.</h2>

          <p style="font-size: 16px; color: var(--color-dark-500); line-height: 1.7; margin-bottom: 20px;">
            J'ai créé la marque NeoGTB parce que ceux qui vous conseillent en GTB sont les mêmes qui vous vendent. NeoGTB comble ce vide : l'analyse, le benchmark et la méthodologie — sans représenter aucun fabricant.
          </p>

          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
            <div style="padding: 16px; border-radius: 10px; border: 1px solid var(--color-dark-200);">
              <p style="font-size: 14px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 4px;">Conseil payant</p>
              <p style="font-size: 12px; color: var(--color-dark-500); line-height: 1.5;">Audits sur site, cahiers des charges, AMO GTB.</p>
            </div>
            <div style="padding: 16px; border-radius: 10px; border: 1px solid var(--color-dark-200);">
              <p style="font-size: 14px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 4px;">Outils gratuits</p>
              <p style="font-size: 12px; color: var(--color-dark-500); line-height: 1.5;">Diagnostic, comparateur, CEE. Sans piège ni relance.</p>
            </div>
            <div style="padding: 16px; border-radius: 10px; border: 1px solid var(--color-dark-200);">
              <p style="font-size: 14px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 4px;">Zéro commission</p>
              <p style="font-size: 12px; color: var(--color-dark-500); line-height: 1.5;">Aucun fabricant ne me rémunère. Jamais.</p>
            </div>
          </div>

          <a href="/about" style="font-size: 14px; font-weight: 500; color: var(--color-accent-600); text-decoration: none;">En savoir plus sur mon parcours →</a>
        </div>

      </div>
    </div>
  </section>

  <!-- ==================== TIMELINE RÉGLEMENTAIRE ==================== -->
  <section style="padding: 64px 0; border-top: 1px solid var(--color-dark-200); border-bottom: 1px solid var(--color-dark-200);">
    <div class="max-w-[900px] mx-auto px-6 md:px-10">
      <div class="text-center mb-8 reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <p class="eyebrow" style="color: var(--color-accent-600);">Échéances réglementaires</p>
        <h2 style="font-size: clamp(22px, 2.5vw, 28px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2;">Décret BACS & Décret Tertiaire — le calendrier qui vous concerne</h2>
      </div>

      <div class="timeline-regl reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <div class="timeline-regl-point active">
          <p class="timeline-regl-year">2025</p>
          <div class="timeline-regl-dot"></div>
          <p class="timeline-regl-label">BACS classe B min.<br/><strong>Puissance CVC > 290 kW</strong></p>
        </div>
        <div class="timeline-regl-point future">
          <p class="timeline-regl-year">2030</p>
          <div class="timeline-regl-dot"></div>
          <p class="timeline-regl-label">BACS classe B min.<br/><strong>Puissance CVC 70-290 kW</strong></p>
        </div>
        <div class="timeline-regl-point future">
          <p class="timeline-regl-year">2040</p>
          <div class="timeline-regl-dot"></div>
          <p class="timeline-regl-label">Décret tertiaire<br/><strong>-50 % conso</strong></p>
        </div>
        <div class="timeline-regl-point future">
          <p class="timeline-regl-year">2050</p>
          <div class="timeline-regl-dot"></div>
          <p class="timeline-regl-label">Décret tertiaire<br/><strong>-60 % conso</strong></p>
        </div>
      </div>

      <p style="text-align: center; font-size: 13px; color: var(--color-dark-400); margin-top: 24px;">
        <span style="display: inline-flex; align-items: center; gap: 6px;"><span style="width: 8px; height: 8px; border-radius: 50%; background: var(--color-accent-500);"></span> En vigueur</span>
        <span style="margin-left: 16px; display: inline-flex; align-items: center; gap: 6px;"><span style="width: 8px; height: 8px; border-radius: 50%; background: var(--color-accent-500);"></span> À venir</span>
      </p>
    </div>
  </section>

  <!-- ==================== CASE STUDIES ==================== -->
  <section style="padding: 56px 0 64px;">
    <div class="max-w-[1200px] mx-auto px-6 md:px-10">
      <div class="max-w-xl mb-10 reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <p class="eyebrow">Cas d'usage</p>
        <h2 style="font-size: clamp(28px, 3vw, 36px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2;">Des situations concrètes, des résultats mesurables</h2>
      </div>

      <div class="grid md:grid-cols-2 gap-6">
        <div class="card p-8 reveal" x-data x-intersect.once="$el.classList.add('visible')">
          <div class="flex items-center gap-3 mb-6">
            <span class="tag tag-reglementation">Décret BACS</span>
            <span style="font-size: 13px; color: var(--color-dark-400);">Tertiaire · 12 000 m²</span>
          </div>
          <h3 style="font-size: 20px; font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; margin-bottom: 12px; line-height: 1.3;">Mise en conformité BACS d'un ensemble de bureaux multi-sites</h3>
          <p style="font-size: 15px; color: var(--color-dark-500); line-height: 1.7; margin-bottom: 20px;">Un gestionnaire de 3 sites tertiaires devait se conformer au décret BACS. Aucune GTB en place, systèmes CVC hétérogènes.</p>
          <div style="border-left: 2px solid var(--color-accent-500); padding-left: 16px; margin-bottom: 24px;">
            <p style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-dark-400); margin-bottom: 6px;">Approche</p>
            <p style="font-size: 14px; color: var(--color-dark-500); line-height: 1.6;">Audit ISO 52120-1 sur 3 sites, benchmark 4 solutions multi-protocoles, estimation CEE, cahier des charges neutre.</p>
          </div>
          <!-- Gauge visuelle EN 15232 + métriques -->
          <div style="margin-bottom: 16px;">
            <p style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-dark-400); margin-bottom: 8px;">Progression ISO 52120-1</p>
            <div class="gauge-en15232">
              <div class="gauge-en15232-bar level-d dimmed">D</div>
              <div class="gauge-en15232-bar level-c" style="position: relative;">C
                <svg style="position: absolute; top: -10px; right: -6px;" width="12" height="12" viewBox="0 0 12 12"><path d="M6 0l2 4h-4z" fill="var(--color-accent-600)" transform="rotate(90 6 6)"/></svg>
              </div>
              <div class="gauge-en15232-bar level-b active">B</div>
              <div class="gauge-en15232-bar level-a dimmed">A</div>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div style="padding: 14px; border-radius: 8px; background: var(--color-dark-50);">
              <p style="font-size: 22px; font-weight: 500; color: var(--color-accent-600); letter-spacing: -0.02em;">-23 %</p>
              <p style="font-size: 11px; color: var(--color-dark-400); margin-top: 4px;">conso CVC</p>
            </div>
            <div style="padding: 14px; border-radius: 8px; background: var(--color-dark-50);">
              <p style="font-size: 22px; font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em;">45 j</p>
              <p style="font-size: 11px; color: var(--color-dark-400); margin-top: 4px;">cahier des charges</p>
            </div>
          </div>
        </div>

        <div class="card p-8 reveal reveal-d1" x-data x-intersect.once="$el.classList.add('visible')">
          <div class="flex items-center gap-3 mb-6">
            <span class="tag tag-technique">Rénovation CVC</span>
            <span style="font-size: 13px; color: var(--color-dark-400);">Enseignement · 8 500 m²</span>
          </div>
          <h3 style="font-size: 20px; font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; margin-bottom: 12px; line-height: 1.3;">Optimisation énergétique d'un campus universitaire vieillissant</h3>
          <p style="font-size: 15px; color: var(--color-dark-500); line-height: 1.7; margin-bottom: 20px;">Un campus équipé d'une GTC obsolète (LON). Consommation supérieure de 40 % à la moyenne du secteur éducatif.</p>
          <div style="border-left: 2px solid var(--color-accent-500); padding-left: 16px; margin-bottom: 24px;">
            <p style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-dark-400); margin-bottom: 6px;">Approche</p>
            <p style="font-size: 14px; color: var(--color-dark-500); line-height: 1.6;">Diagnostic complet, plan de migration progressive LON → BACnet IP sur 24 mois (par lot technique), comparaison de 3 superviseurs, simulation des gains.</p>
          </div>
          <!-- Gauge visuelle EN 15232 + métriques -->
          <div style="margin-bottom: 16px;">
            <p style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-dark-400); margin-bottom: 8px;">Objectif ISO 52120-1</p>
            <div class="gauge-en15232">
              <div class="gauge-en15232-bar level-d" style="position: relative;">D
                <svg style="position: absolute; top: -10px; right: -6px;" width="12" height="12" viewBox="0 0 12 12"><path d="M6 0l2 4h-4z" fill="var(--color-accent-600)" transform="rotate(90 6 6)"/></svg>
              </div>
              <div class="gauge-en15232-bar level-c dimmed">C</div>
              <div class="gauge-en15232-bar level-b active">B</div>
              <div class="gauge-en15232-bar level-a dimmed">A</div>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div style="padding: 14px; border-radius: 8px; background: var(--color-dark-50);">
              <p style="font-size: 22px; font-weight: 500; color: var(--color-accent-600); letter-spacing: -0.02em;">-35 %</p>
              <p style="font-size: 11px; color: var(--color-dark-400); margin-top: 4px;">objectif réduction</p>
            </div>
            <div style="padding: 14px; border-radius: 8px; background: var(--color-dark-50);">
              <p style="font-size: 22px; font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em;">3 ans</p>
              <p style="font-size: 11px; color: var(--color-dark-400); margin-top: 4px;">ROI estimé</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Lien contextuel Case Studies -->
      <div class="reveal" x-data x-intersect.once="$el.classList.add('visible')" style="text-align: center; margin-top: 32px;">
        <a href="/audit" style="font-size: 14px; font-weight: 500; color: var(--color-accent-600); text-decoration: none; border-bottom: 1px solid var(--color-accent-200);">
          Lancer le pré-diagnostic pour votre bâtiment →
        </a>
      </div>
    </div>
  </section>

  <!-- ==================== INSIGHTS ==================== -->
  <section style="padding: 56px 0 64px; background: var(--color-dark-50); border-top: 1px solid var(--color-dark-200); border-bottom: 1px solid var(--color-dark-200);">
    <div class="max-w-[1200px] mx-auto px-6 md:px-10">
      <div class="flex items-end justify-between mb-12 reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <div>
          <p class="eyebrow">Perspectives</p>
          <h2 style="font-size: clamp(28px, 3vw, 36px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2;">Analyses & veille technique</h2>
        </div>
        <a href="/blog" class="hidden md:inline-flex btn-ghost">Tous les articles →</a>
      </div>

      <div class="grid md:grid-cols-3 gap-6">
        <a href="/blog/decret-tertiaire-gtb-obligations" class="card block p-6 reveal" x-data x-intersect.once="$el.classList.add('visible')" style="text-decoration: none;">
          <span class="tag tag-reglementation">Réglementation</span>
          <h3 style="font-size: 16px; font-weight: 500; color: var(--color-dark-900); line-height: 1.4; margin-top: 16px;">Décret tertiaire et GTB : obligations et mise en conformité</h3>
          <p style="font-size: 13px; color: var(--color-dark-400); margin-top: 12px;">8 min de lecture</p>
        </a>

        <a href="/blog/protocoles-communication-bacnet-knx-modbus" class="card block p-6 reveal reveal-d1" x-data x-intersect.once="$el.classList.add('visible')" style="text-decoration: none;">
          <span class="tag tag-protocoles">Protocoles</span>
          <h3 style="font-size: 16px; font-weight: 500; color: var(--color-dark-900); line-height: 1.4; margin-top: 16px;">BACnet, KNX, Modbus : quel protocole pour quel usage en GTB ?</h3>
          <p style="font-size: 13px; color: var(--color-dark-400); margin-top: 12px;">6 min de lecture</p>
        </a>

        <a href="/blog/guide-complet-gtb-2026" class="card block p-6 reveal reveal-d2" x-data x-intersect.once="$el.classList.add('visible')" style="text-decoration: none;">
          <span class="tag tag-gtb">Guide</span>
          <h3 style="font-size: 16px; font-weight: 500; color: var(--color-dark-900); line-height: 1.4; margin-top: 16px;">Qu'est-ce que la GTB ? Le guide complet 2026</h3>
          <p style="font-size: 13px; color: var(--color-dark-400); margin-top: 12px;">5 min de lecture</p>
        </a>
      </div>

      <a href="/blog" class="md:hidden btn-ghost mt-8">Tous les articles →</a>
    </div>
  </section>

  <!-- ==================== COMPTEUR D'USAGE + CTA ==================== -->
  <section style="padding: 56px 0 64px;">
    <div class="max-w-[1200px] mx-auto px-6 md:px-10">

      <!-- Compteur d'usage -->
      <div class="reveal" x-data x-intersect.once="$el.classList.add('visible')" style="text-align: center; margin-bottom: 64px;">
        <p class="eyebrow">Depuis le lancement</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6" style="max-width: 800px; margin: 24px auto 0;">
          <div>
            <p style="font-size: 36px; font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.03em;">340+</p>
            <p style="font-size: 13px; color: var(--color-dark-400); margin-top: 4px;">diagnostics réalisés</p>
          </div>
          <div>
            <p style="font-size: 36px; font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.03em;">1 200+</p>
            <p style="font-size: 13px; color: var(--color-dark-400); margin-top: 4px;">comparaisons lancées</p>
          </div>
          <div>
            <p style="font-size: 36px; font-weight: 500; color: var(--color-accent-600); letter-spacing: -0.03em;">2,4 M€</p>
            <p style="font-size: 13px; color: var(--color-dark-400); margin-top: 4px;">CEE estimés via l'outil</p>
          </div>
          <div>
            <p style="font-size: 36px; font-weight: 500; color: var(--color-accent-600); letter-spacing: -0.03em;">0 €</p>
            <p style="font-size: 13px; color: var(--color-dark-400); margin-top: 4px;">commission fabricant</p>
          </div>
        </div>
      </div>

      <!-- CTA honnête — remplace les faux témoignages -->
      <div class="reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <div style="background: var(--color-dark-50); border: 1px solid var(--color-dark-200); border-radius: 16px; padding: 48px; text-align: center;">
          <h2 style="font-size: clamp(24px, 3vw, 32px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 12px;">
            NeoGTB est un projet récent. Pas de faux témoignages ici.
          </h2>
          <p style="font-size: 16px; color: var(--color-dark-500); line-height: 1.7; max-width: 560px; margin: 0 auto 12px;">
            Plutôt que d'inventer des avis, je vous propose de tester les outils vous-même. Le pré-diagnostic prend 3 minutes. Si l'approche vous parle, on en discute.
          </p>
          <p style="font-size: 13px; color: var(--color-dark-400); margin-bottom: 32px;">
            Les premiers retours clients seront publiés ici dès qu'ils seront vérifiables.
          </p>
          <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center;">
            <a href="/audit" class="btn-primary">
              Tester le pré-diagnostic gratuit
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            <a href="/contact" class="btn-secondary">
              Échanger avec moi
            </a>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ==================== CTA FINAL ==================== -->
  <section class="relative overflow-hidden" style="padding: 56px 0 64px; background: #F0F2F5; min-height: 420px; border-top: 1px solid var(--color-dark-200);">
    <!-- Illustration arrière-plan -->
    <img
      src="/images/hero-gtb-illustration.webp"
      alt=""
      width="1200"
      height="630"
      class="hero-bg-illustration"
      loading="lazy"
    />
    <div style="position: absolute; inset: 0; background: linear-gradient(to right, #F0F2F5 30%, rgba(240,242,245,0.3) 70%); pointer-events: none;"></div>

    <div class="max-w-[1200px] mx-auto px-6 md:px-10 relative z-10" style="display: flex; align-items: center; min-height: 230px;">
      <div style="max-width: 520px;">
        <h2 style="font-size: clamp(28px, 3vw, 36px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 16px;">Un regard indépendant sur votre GTB</h2>
        <p style="font-size: 16px; color: var(--color-dark-500); line-height: 1.7; margin-bottom: 32px;">Pré-diagnostic gratuit, sans engagement, sans orientation commerciale.</p>
        <a href="/audit" class="btn-primary">
          Lancer le pré-diagnostic
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </section>

  <!-- ==================== STICKY CTA MOBILE ==================== -->
  <div class="sticky-cta-mobile"
    x-data="{ show: false }"
    x-init="
      const hero = document.querySelector('.hero-img');
      const ctaFinal = document.querySelectorAll('section')[document.querySelectorAll('section').length - 1];
      const observer = new IntersectionObserver(([e]) => { show = !e.isIntersecting }, { threshold: 0 });
      const observerBottom = new IntersectionObserver(([e]) => { if(e.isIntersecting) show = false }, { threshold: 0.3 });
      observer.observe(hero);
      observerBottom.observe(ctaFinal);
    "
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-full opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-full opacity-0"
    x-cloak>
    <a href="/audit" class="sticky-cta-btn">
      Pré-diagnostic gratuit
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </a>
  </div>

@endsection
