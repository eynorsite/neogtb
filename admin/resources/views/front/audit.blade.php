@extends('front.layouts.app')


@push('head')
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "Pré-diagnostic GTB ISO 52120-1",
  "description": "Évaluez la maturité technique de votre bâtiment en 8 questions et obtenez une estimation de classe GTB (A/B/C/D) selon la norme ISO 52120-1 (ex-EN 15232).",
  "totalTime": "PT5M",
  "step": [
    { "@type": "HowToStep", "position": 1, "name": "Décrivez votre bâtiment", "text": "Renseignez le type de bâtiment (bureaux, commerce, industrie, santé, enseignement, hôtellerie), la surface utile et la zone climatique (H1, H2, H3 ou DOM)." },
    { "@type": "HowToStep", "position": 2, "name": "Identifiez vos lots techniques", "text": "Sélectionnez les lots techniques présents dans votre bâtiment (CVC, éclairage, ECS, stores, comptage, etc.) afin de calibrer le diagnostic." },
    { "@type": "HowToStep", "position": 3, "name": "Régulation CVC", "text": "Indiquez le niveau de régulation du chauffage, ventilation et climatisation (manuel, thermostats, programmation horaire ou optimisation automatique)." },
    { "@type": "HowToStep", "position": 4, "name": "Gestion de l'éclairage", "text": "Précisez le mode de gestion de l'éclairage (interrupteurs, minuteries, détection de présence ou gestion intelligente avec daylight harvesting)." },
    { "@type": "HowToStep", "position": 5, "name": "Suivi des consommations", "text": "Indiquez le niveau de suivi énergétique (aucun, relevé manuel, sous-comptage automatique ou monitoring temps réel avec alertes de dérive)." },
    { "@type": "HowToStep", "position": 6, "name": "Supervision des lots techniques", "text": "Précisez si vous disposez d'une supervision centralisée (aucune, partielle, GTC multi-lots ou GTB complète avec pilotage)." },
    { "@type": "HowToStep", "position": 7, "name": "Maintenance dominante", "text": "Indiquez votre mode de maintenance principal : curatif, préventif planifié, conditionnel basé sur les capteurs ou prédictif." },
    { "@type": "HowToStep", "position": 8, "name": "Conformité réglementaire", "text": "Précisez votre niveau de conformité au décret tertiaire et au décret BACS (inconnu, partiel, en cours ou pleinement conforme avec reporting OPERAT)." },
    { "@type": "HowToStep", "position": 9, "name": "Recevez vos résultats", "text": "Obtenez instantanément votre classe GTB estimée (A/B/C/D), un benchmark énergétique, un récapitulatif et des recommandations personnalisées au format PDF." }
  ]
}
</script>
@endverbatim
<style>
  /* Palette accent/dark héritée de resources/css/app.css (@theme global). Pas de redéfinition locale pour éviter le silo CSS / palette zombie. */
  [x-cloak] { display: none !important; }

  /* Hero */
  .hero-lum { position: relative; overflow: hidden; padding: 56px 0 32px; background: #0a1628; }
  @media (min-width: 1024px) { .hero-lum { padding: 80px 0 64px; } }
  @media (max-width: 1023px) { .hero-orb-1, .hero-orb-2, .hero-orb-3, .hero-lum-grid { display: none !important; } }
  .hero-lum-img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center; opacity: 0.45; }
  .hero-lum-mesh { position: absolute; inset: 0; pointer-events: none; background: linear-gradient(to top, rgba(10,22,40,0.85) 0%, rgba(10,22,40,0.3) 50%, rgba(10,22,40,0.6) 100%); }
  .hero-lum-grid { position: absolute; inset: 0; pointer-events: none; background-image: linear-gradient(rgba(13,148,136,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(13,148,136,0.04) 1px, transparent 1px), radial-gradient(circle 2px at center, rgba(13,148,136,0.12) 0%, transparent 2px); background-size: 48px 48px, 48px 48px, 48px 48px; mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 20%, transparent 70%); -webkit-mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 20%, transparent 70%); }
  .hero-orb { position: absolute; pointer-events: none; opacity: 0.5; }
  .hero-orb-1 { width: 200px; height: 200px; top: 8%; right: 15%; border: 1px solid rgba(13,148,136,0.08); border-radius: 50%; animation: hero-float 12s ease-in-out infinite; }
  .hero-orb-1::after { content: ''; position: absolute; top: 50%; left: 50%; width: 8px; height: 8px; border-radius: 50%; background: rgba(13,148,136,0.2); transform: translate(-50%, -50%); }
  .hero-orb-2 { width: 140px; height: 140px; bottom: 10%; left: 8%; border: 1px solid rgba(13,148,136,0.06); border-radius: 50%; animation: hero-float 10s ease-in-out infinite reverse; }
  .hero-orb-2::after { content: ''; position: absolute; top: 50%; left: 50%; width: 6px; height: 6px; border-radius: 50%; background: rgba(245,158,11,0.2); transform: translate(-50%, -50%); }
  .hero-orb-3 { width: 100px; height: 100px; top: 40%; left: 35%; border: 1px solid rgba(13,148,136,0.05); border-radius: 50%; animation: hero-float 14s ease-in-out infinite 2s; }
  .hero-orb-3::after { content: ''; position: absolute; top: 50%; left: 50%; width: 5px; height: 5px; border-radius: 50%; background: rgba(13,148,136,0.15); transform: translate(-50%, -50%); }
  @keyframes hero-float { 0%, 100% { transform: translate(0, 0) scale(1); } 33% { transform: translate(12px, -8px) scale(1.02); } 66% { transform: translate(-6px, 6px) scale(0.98); } }

  .diag-eyebrow { font-size: 12px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: var(--color-accent-600); margin-bottom: 20px; }
  .diag-hero-badges { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 24px; }
  .diag-badge { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 100px; font-size: 12px; font-weight: 500; background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.8); }
  .diag-badge-accent { background: rgba(45,212,191,0.12); border-color: rgba(45,212,191,0.25); color: #2DD4BF; }
  .diag-section { padding: 48px 0 80px; background: var(--color-dark-50); min-height: 600px; }
  .diag-progress-wrap { margin-bottom: 40px; }
  .diag-progress-bar { width: 100%; height: 3px; background: var(--color-dark-200); border-radius: 100px; overflow: hidden; margin-bottom: 24px; }
  .diag-progress-fill { height: 100%; background: var(--color-accent-600); border-radius: 100px; transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
  .diag-progress-steps { display: flex; justify-content: center; gap: 48px; }
  .diag-step-item { display: flex; align-items: center; gap: 10px; }
  .diag-step-dot { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: white; color: var(--color-dark-400); border: 1.5px solid var(--color-dark-200); transition: all 0.3s; }
  .diag-step-item.is-active .diag-step-dot { background: var(--color-dark-900); color: white; border-color: var(--color-dark-900); }
  .diag-step-item.is-done .diag-step-dot { background: var(--color-accent-600); color: white; border-color: var(--color-accent-600); }
  .diag-step-label { font-size: 13px; font-weight: 500; color: var(--color-dark-400); transition: color 0.2s; }
  .diag-step-item.is-active .diag-step-label { color: var(--color-dark-900); }
  .diag-step-item.is-done .diag-step-label { color: var(--color-accent-700); }
  @media (max-width: 640px) { .diag-progress-steps { gap: 16px; } .diag-step-label { display: none; } }
  .diag-card { background: white; border-radius: 16px; border: 1px solid var(--color-dark-100); overflow: hidden; }
  .diag-card-header { padding: 20px 20px 0; }
  @media (min-width: 1024px) { .diag-card-header { padding: 28px 28px 0; } }
  .diag-card-header h2 { font-size: 20px; font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; margin-bottom: 4px; }
  .diag-card-header p { font-size: 14px; color: var(--color-dark-500); line-height: 1.6; }
  .diag-card-body { padding: 20px; }
  @media (min-width: 1024px) { .diag-card-body { padding: 24px 28px; } }
  .diag-card-footer { padding: 16px 20px; border-top: 1px solid var(--color-dark-100); display: flex; justify-content: space-between; align-items: center; }
  @media (min-width: 1024px) { .diag-card-footer { padding: 20px 28px; } }
  .diag-label { display: block; font-size: 13px; font-weight: 600; color: var(--color-dark-700); margin-bottom: 10px; letter-spacing: 0.01em; }
  .diag-label-sm { display: block; font-size: 12px; font-weight: 500; color: var(--color-dark-500); margin-bottom: 6px; }
  .diag-input { width: 100%; padding: 12px 16px; border: 1.5px solid var(--color-dark-200); border-radius: 10px; font-size: 14px; color: var(--color-dark-900); background: white; transition: all 0.15s; font-family: inherit; }
  .diag-input:focus { border-color: var(--color-accent-500); outline: none; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.08); }
  .diag-input.has-error { border-color: #ef4444; }
  .diag-input-sm { width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-dark-200); border-radius: 8px; font-size: 13px; font-family: inherit; color: var(--color-dark-900); background: white; }
  .diag-input-sm:focus { border-color: var(--color-accent-500); outline: none; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.08); }
  .diag-input-sm.has-error { border-color: #ef4444; }
  .diag-input-wrap { position: relative; }
  .diag-input-suffix { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); font-size: 13px; color: var(--color-dark-400); font-weight: 500; pointer-events: none; }
  .diag-input-suffix-sm { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); font-size: 12px; color: var(--color-dark-400); font-weight: 500; pointer-events: none; }
  .diag-error { font-size: 12px; color: #ef4444; margin-top: 6px; }
  .diag-grid-6 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 24px; }
  .diag-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
  .diag-field-group { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
  @media (max-width: 640px) { .diag-grid-6 { grid-template-columns: repeat(2, 1fr); } .diag-field-group { grid-template-columns: 1fr; } }
  .diag-choice { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 16px 8px; border-radius: 12px; cursor: pointer; border: 1.5px solid var(--color-dark-200); background: white; transition: all 0.2s; font-family: inherit; }
  .diag-choice:hover { border-color: var(--color-dark-300); background: var(--color-dark-50); }
  .diag-choice.is-selected { border-color: var(--color-accent-600); background: rgba(13, 148, 136, 0.04); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.08); }
  .diag-choice-label { font-size: 13px; font-weight: 500; color: var(--color-dark-700); }
  .diag-choice.is-selected .diag-choice-label { color: var(--color-accent-700); }
  .diag-zone { display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 16px 12px; border-radius: 12px; cursor: pointer; border: 1.5px solid var(--color-dark-200); background: white; transition: all 0.2s; font-family: inherit; }
  .diag-zone:hover { border-color: var(--color-dark-300); }
  .diag-zone.is-selected { border-color: var(--color-accent-600); background: rgba(13, 148, 136, 0.04); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.08); }
  .diag-zone-id { font-size: 14px; font-weight: 600; color: var(--color-dark-900); }
  .diag-zone-desc { font-size: 11px; color: var(--color-dark-400); text-align: center; line-height: 1.4; }
  .diag-zone-tag { font-size: 10px; font-weight: 500; color: var(--color-dark-400); background: var(--color-dark-100); padding: 2px 8px; border-radius: 100px; margin-top: 4px; letter-spacing: 0.02em; }
  .diag-zone.is-selected .diag-zone-tag { background: rgba(13, 148, 136, 0.1); color: var(--color-accent-700); }
  .diag-lot-block { border: 1.5px solid var(--color-dark-200); border-radius: 14px; padding: 20px; margin-bottom: 16px; background: white; transition: border-color 0.15s; }
  .diag-lot-block:hover { border-color: var(--color-dark-300); }
  .diag-lot-header { display: flex; align-items: center; gap: 12px; }
  .diag-lot-title { font-size: 15px; font-weight: 600; color: var(--color-dark-800); display: block; }
  .diag-lot-subtitle { font-size: 12px; color: var(--color-dark-400); display: block; margin-top: 2px; }
  .diag-choice-sm { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; cursor: pointer; border: 1.5px solid var(--color-dark-200); background: white; transition: all 0.15s; font-family: inherit; font-size: 13px; }
  .diag-choice-sm:hover { border-color: var(--color-dark-300); }
  .diag-choice-sm.is-selected { border-color: var(--color-accent-600); background: rgba(13, 148, 136, 0.04); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.08); }
  .diag-choice-sm.is-selected .diag-choice-label { color: var(--color-accent-700); }
  .diag-q-progress { display: flex; gap: 6px; justify-content: center; padding: 20px 28px 0; }
  .diag-q-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--color-dark-200); transition: all 0.3s; }
  .diag-q-dot.is-current { background: var(--color-dark-900); transform: scale(1.3); box-shadow: 0 0 0 3px rgba(28, 25, 23, 0.15); }
  .diag-q-dot.is-done { background: var(--color-accent-500); }
  .diag-q-counter { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--color-accent-600); margin-bottom: 8px; }
  .diag-question-options { display: flex; flex-direction: column; gap: 8px; }
  @keyframes diag-option-in { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
  .diag-option { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 10px; cursor: pointer; border: 1.5px solid var(--color-dark-100); transition: all 0.15s; font-size: 13px; color: var(--color-dark-600); line-height: 1.5; }
  .diag-option:hover { border-color: var(--color-dark-300); background: var(--color-dark-50); }
  .diag-option.is-selected { border-color: var(--color-accent-500); background: rgba(13, 148, 136, 0.04); color: var(--color-accent-800); }
  .diag-option-dot { width: 18px; height: 18px; border-radius: 50%; flex-shrink: 0; border: 2px solid var(--color-dark-300); display: flex; align-items: center; justify-content: center; transition: border-color 0.15s; }
  .diag-option.is-selected .diag-option-dot { border-color: var(--color-accent-500); }
  .diag-option-dot-inner { width: 8px; height: 8px; border-radius: 50%; background: var(--color-accent-500); }
  .diag-btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 500; font-family: inherit; background: var(--color-dark-900); color: white; border: none; cursor: pointer; transition: all 0.2s; }
  .diag-btn-primary:hover { background: var(--color-dark-800); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
  .diag-btn-accent { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 500; font-family: inherit; background: var(--color-accent-600); color: white; border: none; cursor: pointer; transition: all 0.2s; }
  .diag-btn-accent:hover { background: var(--color-accent-700); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25); }
  .diag-btn-ghost { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 500; font-family: inherit; background: white; color: var(--color-dark-600); border: 1.5px solid var(--color-dark-200); cursor: pointer; transition: all 0.15s; }
  .diag-btn-ghost:hover { background: var(--color-dark-50); border-color: var(--color-dark-300); }
  .diag-results-hero { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .diag-kpi { border-radius: 16px; padding: 32px 24px; text-align: center; position: relative; overflow: hidden; }
  .diag-kpi::after { content: ''; position: absolute; top: -50%; right: -30%; width: 200px; height: 200px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%); pointer-events: none; }
  .diag-kpi-d { background: #991b1b; } .diag-kpi-c { background: #92400e; } .diag-kpi-b { background: #065f46; } .diag-kpi-a { background: var(--color-accent-700); }
  .diag-kpi-savings { background: var(--color-dark-900); }
  .diag-kpi-label { font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.6); }
  .diag-kpi-score { font-size: clamp(28px, 5vw, 40px); font-weight: 500; color: white; letter-spacing: -0.02em; margin: 8px 0 4px; }
  .diag-kpi-level { font-size: 12px; color: rgba(255,255,255,0.5); }
  @keyframes diag-kpi-pop { from { opacity: 0; transform: scale(0.9) translateY(12px); } to { opacity: 1; transform: scale(1) translateY(0); } }
  .diag-btn-disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }
  @media (max-width: 640px) { .diag-results-hero { grid-template-columns: 1fr; } }
  .diag-gauge { display: flex; align-items: center; gap: 4px; justify-content: center; margin-bottom: 16px; }
  .diag-gauge-bar { height: 40px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; letter-spacing: 0.02em; color: white; transition: all 0.3s; }
  .diag-gauge-bar.level-d { background: #DC2626; width: 56px; } .diag-gauge-bar.level-c { background: #F59E0B; width: 68px; } .diag-gauge-bar.level-b { background: #22C55E; width: 80px; } .diag-gauge-bar.level-a { background: var(--color-accent-600); width: 92px; }
  .diag-gauge-bar.active { transform: scaleY(1.25); box-shadow: 0 4px 16px rgba(0,0,0,0.2); z-index: 1; }
  .diag-gauge-bar.dimmed { opacity: 0.2; }
  .diag-gauge-desc { font-size: 14px; color: var(--color-dark-500); max-width: 500px; margin: 0 auto; line-height: 1.6; }
  .diag-regulatory { display: flex; gap: 16px; align-items: flex-start; padding: 20px; border-radius: 12px; }
  .diag-regulatory-critical { background: #fef2f2; border: 1px solid #fecaca; }
  .diag-regulatory-critical .diag-regulatory-icon { color: #dc2626; } .diag-regulatory-critical .diag-regulatory-title { color: #991b1b; } .diag-regulatory-critical .diag-regulatory-text { color: #7f1d1d; } .diag-regulatory-critical .diag-regulatory-countdown { color: #dc2626; font-weight: 700; font-size: 15px; margin-top: 8px; }
  .diag-regulatory-warning { background: #fffbeb; border: 1px solid #fde68a; }
  .diag-regulatory-warning .diag-regulatory-icon { color: #d97706; } .diag-regulatory-warning .diag-regulatory-title { color: #92400e; } .diag-regulatory-warning .diag-regulatory-text { color: #78350f; } .diag-regulatory-warning .diag-regulatory-countdown { color: #d97706; font-weight: 700; font-size: 15px; margin-top: 8px; }
  .diag-regulatory-ok { background: #f0fdf4; border: 1px solid #bbf7d0; }
  .diag-regulatory-ok .diag-regulatory-icon { color: #16a34a; } .diag-regulatory-ok .diag-regulatory-title { color: #166534; } .diag-regulatory-ok .diag-regulatory-text { color: #14532d; }
  .diag-regulatory-title { font-size: 14px; font-weight: 600; margin-bottom: 4px; }
  .diag-regulatory-text { font-size: 13px; line-height: 1.6; }
  .diag-benchmark { position: relative; margin-bottom: 32px; padding-top: 40px; }
  .diag-benchmark-bar-wrap { display: flex; height: 28px; border-radius: 8px; overflow: hidden; }
  .diag-benchmark-zone { display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; color: white; }
  .diag-benchmark-good { background: #16a34a; } .diag-benchmark-avg { background: #f59e0b; } .diag-benchmark-bad { background: #ef4444; }
  .diag-benchmark-marker { position: absolute; top: 0; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center; z-index: 2; }
  .diag-benchmark-marker-dot { width: 14px; height: 14px; border-radius: 50%; background: var(--color-dark-900); border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.2); margin-bottom: 4px; }
  .diag-benchmark-marker-label { display: flex; flex-direction: column; align-items: center; font-size: 13px; font-weight: 600; color: var(--color-dark-900); white-space: nowrap; }
  .diag-benchmark-legend { display: flex; gap: 20px; flex-wrap: wrap; font-size: 12px; color: var(--color-dark-500); }
  .diag-benchmark-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 4px; }
  .diag-energy-row { display: flex; justify-content: space-between; align-items: center; padding: 14px 16px; border-radius: 10px; border: 1px solid var(--color-dark-100); margin-bottom: 8px; }
  .diag-energy-total { display: flex; justify-content: space-between; padding: 16px; background: var(--color-dark-50); border-radius: 10px; margin-top: 8px; font-size: 14px; font-weight: 600; color: var(--color-dark-900); }
  .diag-rec-row { display: flex; gap: 12px; align-items: flex-start; padding: 14px 16px; border-radius: 10px; border: 1px solid var(--color-dark-100); margin-bottom: 8px; font-size: 13px; color: var(--color-dark-600); line-height: 1.6; }
  .diag-rec-icon { color: var(--color-accent-500); margin-top: 2px; flex-shrink: 0; }
  .diag-premium-card { margin-top: 24px; border-radius: 16px; padding: 32px 28px; background: linear-gradient(135deg, #f0fdfa 0%, #ecfdf5 50%, #fffbeb 100%); border: 1.5px solid var(--color-accent-200); }
  .diag-premium-badge { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--color-accent-700); background: rgba(13, 148, 136, 0.1); padding: 4px 12px; border-radius: 100px; margin-bottom: 16px; }
  .diag-premium-title { font-size: 18px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 8px; }
  .diag-premium-desc { font-size: 14px; color: var(--color-dark-500); line-height: 1.6; margin-bottom: 24px; }
  .diag-premium-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  @media (max-width: 640px) { .diag-premium-grid { grid-template-columns: 1fr; } }
  .diag-premium-col { background: white; border-radius: 12px; padding: 24px; border: 1px solid var(--color-dark-200); }
  .diag-premium-col-highlight { border-color: var(--color-accent-500); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.08); }
  .diag-premium-col-title { font-size: 16px; font-weight: 600; color: var(--color-dark-900); margin-bottom: 2px; }
  .diag-premium-col-subtitle { font-size: 12px; color: var(--color-dark-400); margin-bottom: 16px; }
  .diag-premium-list { list-style: none; padding: 0; margin: 0 0 20px; font-size: 13px; color: var(--color-dark-600); line-height: 2; }
  .diag-premium-list li::before { content: '\2713 '; color: var(--color-accent-500); font-weight: 700; }
  .diag-premium-price { font-size: 20px; font-weight: 600; color: var(--color-dark-900); }
  .diag-disclaimer { display: flex; gap: 12px; padding: 16px 20px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; margin-top: 20px; }
  .diag-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
  @media (max-width: 640px) { .diag-actions { flex-direction: column; } }
  @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; } }
  .diag-btn-primary:focus-visible, .diag-btn-accent:focus-visible, .diag-btn-ghost:focus-visible { outline: 2px solid var(--color-accent-500); outline-offset: 2px; }
  @media screen and (-webkit-min-device-pixel-ratio: 0) { .diag-input, .diag-input-sm, select { font-size: 16px !important; } }
  .diag-modal-overlay { position: fixed; inset: 0; z-index: 70; display: flex; align-items: center; justify-content: center; padding: 16px; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(8px); }
  .diag-modal { background: white; border-radius: 16px; max-width: 420px; width: 100%; padding: 28px; border: 1px solid var(--color-dark-200); box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
  @media (max-width: 480px) { .diag-modal { max-width: 100%; padding: 20px; } .diag-modal-overlay { padding: 12px; } }
</style>
@endpush

@section('content')

  {{-- Breadcrumbs --}}
  <nav class="max-w-7xl mx-auto px-5 lg:px-10 py-3 text-sm text-dark-400">
    <a href="/" class="hover:text-primary-600 transition-colors">{{ $site->label('breadcrumb.home', 'Accueil') }}</a>
    <span class="mx-2">/</span>
    <span class="text-dark-300">{{ $site->label('breadcrumb.tools', 'Outils') }}</span>
    <span class="mx-2">/</span>
    <span class="text-dark-600 font-medium">{{ $site->label('audit.breadcrumb', 'Pré-diagnostic GTB') }}</span>
  </nav>

  <!-- HERO -->
  <section class="hero-lum" data-hero>
    <img src="/images/hero-audit.png" alt="Bâtiment intelligent connecté — GTB" class="hero-lum-img" width="1200" height="630" loading="eager" fetchpriority="high" />
    <div class="hero-lum-mesh"></div>
    <div class="max-w-[800px] mx-auto px-5 lg:px-10 relative z-10 text-center">
      <p class="diag-eyebrow" style="color: rgba(255,255,255,0.7);">{{ $site->label('audit.hero.eyebrow', 'Diagnostic gratuit · Rapport PDF') }}</p>
      <h1 class="mt-5 text-[30px] lg:text-[44px] font-heading font-medium" style="letter-spacing: -0.4px; color: #fff;">
        {!! $site->label('audit.hero.title', 'Pré-diagnostic <span style="color: #2DD4BF;">GTB</span> de votre bâtiment') !!}
      </h1>
      <p class="mt-4 text-lg max-w-2xl mx-auto" style="font-weight: 400; color: rgba(255,255,255,0.65);">
        {{ $site->label('audit.hero.subtitle', "Évaluez votre conformité au décret BACS, estimez vos économies d'énergie et recevez un rapport personnalisé avec recommandations ISO 52120-1.") }}
      </p>
      <div class="diag-hero-badges">
        <span class="diag-badge">
          <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          {{ $site->label('audit.hero.badge1', 'ISO 52120-1 · Décret BACS · Données ADEME') }}
        </span>
        <span class="diag-badge diag-badge-accent">
          <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          {{ $site->label('audit.hero.badge2', '100% indépendant · 0 € commission') }}
        </span>
      </div>
    </div>
  </section>

  <!-- FORMULAIRE (Alpine.js identique à Astro) -->
  <section class="diag-section" x-data="diagWizard()" x-cloak x-ref="wizardTop">
    <div class="max-w-[720px] mx-auto px-5 md:px-8">

      <!-- Barre de progression -->
      <div class="diag-progress-wrap">
        <div class="diag-progress-bar">
          <div class="diag-progress-fill" :style="`width: ${(step / totalSteps) * 100}%`"></div>
        </div>
        <div class="diag-progress-steps">
          <template x-for="(s, i) in stepLabels" :key="i">
            <div class="diag-step-item" :class="{ 'is-active': step === i + 1, 'is-done': step > i + 1 }">
              <div class="diag-step-dot">
                <span x-show="step <= i + 1" x-text="i + 1" style="font-size:13px;font-weight:600;"></span>
                <svg x-show="step > i + 1" style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
              </div>
              <span class="diag-step-label" x-text="s"></span>
            </div>
          </template>
        </div>
      </div>

      <!-- ÉTAPE 1 : BÂTIMENT -->
      <div x-show="step === 1" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-x-8">
        <div class="diag-card">
          <div class="diag-card-header">
            <h2>{{ $site->label('audit.step1_title', 'Décrivez votre bâtiment') }}</h2>
            <p>{{ $site->label('audit.step1_subtitle', "Ces données permettent d'estimer votre obligation réglementaire et vos références de consommation ADEME.") }}</p>
          </div>
          <div class="diag-card-body">
            <label class="diag-label">{{ $site->label('forms.building_type', 'Type de bâtiment') }}</label>
            <div class="diag-grid-6">
              <template x-for="type in buildingTypes" :key="type.id">
                <button @click="form.buildingType = type.id" class="diag-choice" :class="{ 'is-selected': form.buildingType === type.id }">
                  <span style="font-size:24px;" x-text="type.icon"></span>
                  <span class="diag-choice-label" x-text="type.label"></span>
                </button>
              </template>
            </div>
            <p x-show="errors.buildingType" x-text="errors.buildingType" class="diag-error"></p>

            <div class="diag-field-group">
              <div>
                <label class="diag-label">{{ $site->label('forms.surface', 'Surface utile') }}</label>
                <div class="diag-input-wrap">
                  <input type="number" x-model.number="form.surface" min="50" max="500000" placeholder="3 000" class="diag-input" :class="{ 'has-error': errors.surface }">
                  <span class="diag-input-suffix">m&sup2;</span>
                </div>
                <p x-show="errors.surface" x-text="errors.surface" class="diag-error"></p>
              </div>
              <div>
                <label class="diag-label">{{ $site->label('forms.building_age', 'Année de construction') }}</label>
                <select x-model="form.buildingAge" class="diag-input">
                  <option value="">{{ $site->label('forms.select_placeholder', 'Sélectionnez') }}</option>
                  <option value="before1975">{{ $site->label('audit.age_before1975', 'Avant 1975') }}</option>
                  <option value="1975-2000">{{ $site->label('audit.age_1975_2000', '1975 — 2000') }}</option>
                  <option value="2000-2012">{{ $site->label('audit.age_2000_2012', '2000 — 2012') }}</option>
                  <option value="after2012">{{ $site->label('audit.age_after2012', 'Après 2012 (RT2012 / RE2020)') }}</option>
                </select>
                <p x-show="errors.buildingAge" x-text="errors.buildingAge" class="diag-error"></p>
              </div>
            </div>

            <label class="diag-label">{{ $site->label('forms.climate_zone', 'Où se situe votre bâtiment ?') }}</label>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
              <template x-for="z in [{id:'H1', label:'Nord & Est', villes:'Paris, Lille, Strasbourg, Lyon, Dijon...', icon:'&#10052;&#65039;'}, {id:'H2', label:'Ouest & Centre', villes:'Nantes, Bordeaux, Toulouse, Rennes, Limoges...', icon:'&#127780;&#65039;'}, {id:'H3', label:'Mediterranee', villes:'Marseille, Nice, Montpellier, Perpignan...', icon:'&#9728;&#65039;'}, {id:'DOM', label:'Corse & Outre-mer', villes:'Ajaccio, Bastia, Guadeloupe, Martinique, Reunion...', icon:'&#127796;'}]" :key="z.id">
                <button @click="form.climateZone = z.id" class="diag-zone" :class="{ 'is-selected': form.climateZone === z.id }">
                  <span style="font-size:22px;" x-text="z.icon"></span>
                  <span class="diag-zone-id" x-text="z.label"></span>
                  <span class="diag-zone-desc" x-text="z.villes"></span>
                  <span class="diag-zone-tag" x-text="'Zone ' + z.id"></span>
                </button>
              </template>
            </div>
            <p x-show="errors.climateZone" x-text="errors.climateZone" class="diag-error"></p>
          </div>
          <div class="diag-card-footer">
            <div></div>
            <button @click="validateStep1()" class="diag-btn-primary">
              {{ $site->label('forms.continue', 'Continuer') }}
              <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
          </div>
        </div>
      </div>

      <!-- ÉTAPE 2 : ÉQUIPEMENTS & LOTS TECHNIQUES -->
      <div x-show="step === 2" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-x-8">
        <div class="diag-card">
          <div class="diag-card-header">
            <h2>{{ $site->label('audit.step2_title', 'Vos lots techniques') }}</h2>
            <p>{{ $site->label('audit.step2_subtitle', 'Décrivez les équipements et usages de votre bâtiment. Ces informations sont essentielles pour dimensionner votre GTB.') }}</p>
          </div>
          <div class="diag-card-body">

            <!-- Chauffage -->
            <div class="diag-lot-block">
              <div class="diag-lot-header">
                <span style="font-size: 22px;">&#128293;</span>
                <div>
                  <span class="diag-lot-title">{{ $site->label('audit.lot_heating', 'Chauffage') }}</span>
                  <span class="diag-lot-subtitle">{{ $site->label('audit.lot_heating_desc', 'Surface gérée par le système de chauffage') }}</span>
                </div>
              </div>
              <div style="margin-top: 12px;">
                <label class="diag-label-sm">{{ $site->label('audit.heated_surface', 'Surface chauffée') }}</label>
                <div class="diag-input-wrap" style="max-width: 280px;">
                  <input type="number" x-model.number="form.surfaceChauffage" min="0" max="500000" placeholder="2 500" class="diag-input-sm" :class="{ 'has-error': errors.surfaceChauffage }">
                  <span class="diag-input-suffix-sm">m&sup2;</span>
                </div>
                <p x-show="errors.surfaceChauffage" x-text="errors.surfaceChauffage" class="diag-error"></p>
              </div>
            </div>

            <!-- ECS -->
            <div class="diag-lot-block">
              <div class="diag-lot-header">
                <span style="font-size: 22px;">&#128703;</span>
                <div>
                  <span class="diag-lot-title">{{ $site->label('audit.lot_ecs', 'Eau chaude sanitaire (ECS)') }}</span>
                  <span class="diag-lot-subtitle">{{ $site->label('audit.lot_ecs_desc', "Production et distribution d'eau chaude") }}</span>
                </div>
              </div>
              <div style="margin-top: 12px;">
                <label class="diag-label-sm">{{ $site->label('audit.has_ecs_question', "Votre bâtiment dispose-t-il d'une production ECS ?") }}</label>
                <div style="display: flex; gap: 10px; margin-top: 8px;">
                  <button @click="form.hasEcs = true" class="diag-choice-sm" :class="{ 'is-selected': form.hasEcs === true }"><span class="diag-choice-label">{{ $site->label('forms.yes', 'Oui') }}</span></button>
                  <button @click="form.hasEcs = false" class="diag-choice-sm" :class="{ 'is-selected': form.hasEcs === false }"><span class="diag-choice-label">{{ $site->label('forms.no', 'Non') }}</span></button>
                </div>
                <p x-show="errors.hasEcs" x-text="errors.hasEcs" class="diag-error"></p>
                <div x-show="form.hasEcs === true" x-transition style="margin-top: 12px;">
                  <label class="diag-label-sm">{{ $site->label('audit.ecs_surface', "Surface desservie par l'ECS") }}</label>
                  <div class="diag-input-wrap" style="max-width: 280px;">
                    <input type="number" x-model.number="form.surfaceEcs" min="0" max="500000" placeholder="1 500" class="diag-input-sm" :class="{ 'has-error': errors.surfaceEcs }">
                    <span class="diag-input-suffix-sm">m&sup2;</span>
                  </div>
                  <p x-show="errors.surfaceEcs" x-text="errors.surfaceEcs" class="diag-error"></p>
                </div>
              </div>
            </div>

            <!-- Climatisation -->
            <div class="diag-lot-block">
              <div class="diag-lot-header">
                <span style="font-size: 22px;">&#10052;&#65039;</span>
                <div>
                  <span class="diag-lot-title">{{ $site->label('audit.lot_cooling', 'Climatisation / Refroidissement') }}</span>
                  <span class="diag-lot-subtitle">{{ $site->label('audit.lot_cooling_desc', 'Système de climatisation, groupes froids, CTA') }}</span>
                </div>
              </div>
              <div style="margin-top: 12px;">
                <label class="diag-label-sm">{{ $site->label('audit.has_cooling_question', 'Votre bâtiment est-il climatisé ?') }}</label>
                <div style="display: flex; gap: 10px; margin-top: 8px;">
                  <button @click="form.hasClim = true" class="diag-choice-sm" :class="{ 'is-selected': form.hasClim === true }"><span class="diag-choice-label">{{ $site->label('forms.yes', 'Oui') }}</span></button>
                  <button @click="form.hasClim = false" class="diag-choice-sm" :class="{ 'is-selected': form.hasClim === false }"><span class="diag-choice-label">{{ $site->label('forms.no', 'Non') }}</span></button>
                </div>
                <p x-show="errors.hasClim" x-text="errors.hasClim" class="diag-error"></p>
                <div x-show="form.hasClim === true" x-transition style="margin-top: 12px;">
                  <label class="diag-label-sm">{{ $site->label('audit.cooled_surface', 'Surface climatisée') }}</label>
                  <div class="diag-input-wrap" style="max-width: 280px;">
                    <input type="number" x-model.number="form.surfaceClim" min="0" max="500000" placeholder="2 000" class="diag-input-sm" :class="{ 'has-error': errors.surfaceClim }">
                    <span class="diag-input-suffix-sm">m&sup2;</span>
                  </div>
                  <p x-show="errors.surfaceClim" x-text="errors.surfaceClim" class="diag-error"></p>
                </div>
              </div>
            </div>

            <!-- Éclairage -->
            <div class="diag-lot-block">
              <div class="diag-lot-header">
                <span style="font-size: 22px;">&#128161;</span>
                <div>
                  <span class="diag-lot-title">{{ $site->label('audit.lot_lighting', 'Éclairage') }}</span>
                  <span class="diag-lot-subtitle">{{ $site->label('audit.lot_lighting_desc', "Gestion de l'éclairage intérieur et extérieur") }}</span>
                </div>
              </div>
              <div style="margin-top: 12px;">
                <label class="diag-label-sm">{{ $site->label('audit.has_lighting_question', "L'éclairage est-il géré de manière centralisée ?") }}</label>
                <div style="display: flex; gap: 10px; margin-top: 8px;">
                  <button @click="form.hasEclairage = true" class="diag-choice-sm" :class="{ 'is-selected': form.hasEclairage === true }"><span class="diag-choice-label">{{ $site->label('forms.yes', 'Oui') }}</span></button>
                  <button @click="form.hasEclairage = false" class="diag-choice-sm" :class="{ 'is-selected': form.hasEclairage === false }"><span class="diag-choice-label">{{ $site->label('forms.no', 'Non') }}</span></button>
                </div>
                <p x-show="errors.hasEclairage" x-text="errors.hasEclairage" class="diag-error"></p>
                <div x-show="form.hasEclairage === true" x-transition style="margin-top: 12px;">
                  <label class="diag-label-sm">{{ $site->label('audit.lit_surface', 'Surface éclairée') }}</label>
                  <div class="diag-input-wrap" style="max-width: 280px;">
                    <input type="number" x-model.number="form.surfaceEclairage" min="0" max="500000" placeholder="3 000" class="diag-input-sm" :class="{ 'has-error': errors.surfaceEclairage }">
                    <span class="diag-input-suffix-sm">m&sup2;</span>
                  </div>
                  <p x-show="errors.surfaceEclairage" x-text="errors.surfaceEclairage" class="diag-error"></p>
                  <label class="diag-label-sm" style="margin-top: 12px;">{{ $site->label('audit.lighting_type', 'Type de gestion') }}</label>
                  <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px;">
                    <button @click="form.eclairage = 'manuel'" class="diag-choice-sm" :class="{ 'is-selected': form.eclairage === 'manuel' }"><span class="diag-choice-label">{{ $site->label('audit.lighting_manual', 'Manuel') }}</span></button>
                    <button @click="form.eclairage = 'minuterie'" class="diag-choice-sm" :class="{ 'is-selected': form.eclairage === 'minuterie' }"><span class="diag-choice-label">{{ $site->label('audit.lighting_timer', 'Minuteries') }}</span></button>
                    <button @click="form.eclairage = 'detection'" class="diag-choice-sm" :class="{ 'is-selected': form.eclairage === 'detection' }"><span class="diag-choice-label">{{ $site->label('audit.lighting_presence', 'Détection de présence') }}</span></button>
                    <button @click="form.eclairage = 'intelligent'" class="diag-choice-sm" :class="{ 'is-selected': form.eclairage === 'intelligent' }"><span class="diag-choice-label">{{ $site->label('audit.lighting_smart', 'Gestion intelligente') }}</span></button>
                  </div>
                  <p x-show="errors.eclairage" x-text="errors.eclairage" class="diag-error"></p>
                </div>
              </div>
            </div>

            <!-- Auxiliaires -->
            <div class="diag-lot-block">
              <div class="diag-lot-header">
                <span style="font-size: 22px;">&#128268;</span>
                <div>
                  <span class="diag-lot-title">{{ $site->label('audit.lot_auxiliary', 'Auxiliaires') }}</span>
                  <span class="diag-lot-subtitle">{{ $site->label('audit.lot_auxiliary_desc', 'Contacts de porte, domotique, station météo, sous-comptage, stores, ventilation / CTA...') }}</span>
                </div>
              </div>
              <div style="margin-top: 12px;">
                <label class="diag-label-sm">{{ $site->label('audit.has_auxiliary_question', "Votre bâtiment dispose-t-il d'équipements auxiliaires ?") }}</label>
                <div style="display: flex; gap: 10px; margin-top: 8px;">
                  <button @click="form.hasAuxiliaires = true" class="diag-choice-sm" :class="{ 'is-selected': form.hasAuxiliaires === true }"><span class="diag-choice-label">{{ $site->label('forms.yes', 'Oui') }}</span></button>
                  <button @click="form.hasAuxiliaires = false" class="diag-choice-sm" :class="{ 'is-selected': form.hasAuxiliaires === false }"><span class="diag-choice-label">{{ $site->label('forms.no', 'Non') }}</span></button>
                </div>
                <p x-show="errors.hasAuxiliaires" x-text="errors.hasAuxiliaires" class="diag-error"></p>
                <div x-show="form.hasAuxiliaires === true" x-transition style="margin-top: 12px;">
                  <label class="diag-label-sm">{{ $site->label('audit.auxiliary_surface', 'Surface concernée par les auxiliaires') }}</label>
                  <div class="diag-input-wrap" style="max-width: 280px;">
                    <input type="number" x-model.number="form.surfaceAuxiliaires" min="0" max="500000" placeholder="3 000" class="diag-input-sm" :class="{ 'has-error': errors.surfaceAuxiliaires }">
                    <span class="diag-input-suffix-sm">m&sup2;</span>
                  </div>
                  <p x-show="errors.surfaceAuxiliaires" x-text="errors.surfaceAuxiliaires" class="diag-error"></p>
                </div>
              </div>
            </div>

          </div>
          <div class="diag-card-footer">
            <button @click="step = 1" class="diag-btn-ghost">
              <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
              {{ $site->label('forms.previous', 'Précédent') }}
            </button>
            <button @click="validateStep2()" class="diag-btn-primary">
              {{ $site->label('forms.continue', 'Continuer') }}
              <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
          </div>
        </div>
      </div>

      <!-- ÉTAPE 3 : MATURITÉ GTB -->
      <div x-show="step === 3" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-x-8">
        <div class="diag-card">
          <div class="diag-q-progress">
            <template x-for="(q, qi) in gtbQuestions" :key="qi">
              <div class="diag-q-dot" :class="{ 'is-done': form.gtbAnswers[qi] !== undefined, 'is-current': currentQuestion === qi }"></div>
            </template>
          </div>
          <div class="diag-card-header">
            <p class="diag-q-counter" x-text="'Question ' + (currentQuestion + 1) + ' / ' + gtbQuestions.length"></p>
            <h2 x-text="gtbQuestions[currentQuestion].title" style="font-size:17px;line-height:1.5;"></h2>
          </div>
          <div class="diag-card-body">
            <div class="diag-question-options">
              <template x-for="(opt, oi) in gtbQuestions[currentQuestion].options" :key="opt.value">
                <label class="diag-option" :class="{ 'is-selected': form.gtbAnswers[currentQuestion] === opt.value }" :style="'animation: diag-option-in 0.3s ease ' + (oi * 0.06) + 's both;'" @click="selectAnswer(currentQuestion, opt.value)">
                  <input type="radio" :name="'q' + currentQuestion" :value="opt.value" x-model.number="form.gtbAnswers[currentQuestion]" class="sr-only">
                  <div class="diag-option-dot">
                    <div class="diag-option-dot-inner" x-show="form.gtbAnswers[currentQuestion] === opt.value"></div>
                  </div>
                  <span x-text="opt.label"></span>
                </label>
              </template>
            </div>
          </div>
          <div class="diag-card-footer">
            <button @click="currentQuestion > 0 ? currentQuestion-- : step = 2" class="diag-btn-ghost">
              <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
              <span x-text="currentQuestion > 0 ? 'Précédent' : 'Retour'"></span>
            </button>
            <button x-show="currentQuestion < gtbQuestions.length - 1" @click="nextQuestion()" :disabled="form.gtbAnswers[currentQuestion] === undefined" class="diag-btn-primary" :class="{ 'diag-btn-disabled': form.gtbAnswers[currentQuestion] === undefined }">
              {{ $site->label('forms.next', 'Suivant') }}
              <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <button x-show="currentQuestion === gtbQuestions.length - 1" @click="validateStep3()" :disabled="form.gtbAnswers[currentQuestion] === undefined" class="diag-btn-accent" :class="{ 'diag-btn-disabled': form.gtbAnswers[currentQuestion] === undefined }">
              {{ $site->label('audit.see_results', 'Voir mon diagnostic') }}
              <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </button>
          </div>
          <p x-show="errors.gtb" x-text="errors.gtb" class="diag-error"></p>
        </div>
      </div>

      <!-- ÉTAPE 4 : RÉSULTATS -->
      <div x-show="step === 4" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

        <div class="diag-results-hero">
          <div class="diag-kpi diag-kpi-animate" :class="'diag-kpi-' + results.levelKey" style="animation: diag-kpi-pop 0.6s cubic-bezier(0.34,1.56,0.64,1) 0.1s both;">
            <p class="diag-kpi-label">{{ $site->label('audit.results.score_label', 'Score de maturité GTB') }}</p>
            <p class="diag-kpi-score" x-text="animatedScore + ' / 100'"></p>
            <p class="diag-kpi-level" x-text="results.levelLabel"></p>
          </div>
          <div class="diag-kpi diag-kpi-savings diag-kpi-animate" style="animation: diag-kpi-pop 0.6s cubic-bezier(0.34,1.56,0.64,1) 0.3s both;">
            <p class="diag-kpi-label">{{ $site->label('audit.results.savings_label', 'Économies potentielles estimées') }}</p>
            <p class="diag-kpi-score" x-text="formatCurrency(results.savingsEuro) + ' /an'"></p>
            <p class="diag-kpi-level" x-text="'soit ' + results.savingsPercent + '% de vos dépenses énergie'"></p>
          </div>
        </div>

        <!-- Prime CEE -->
        <div x-show="results.cee.eligible" class="diag-card" style="margin-top:20px;">
          <div class="diag-card-body" style="padding:24px 28px;">
            <div style="display:flex;align-items:flex-start;gap:16px;">
              <div style="width:44px;height:44px;border-radius:12px;background:rgba(245,158,11,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:22px;height:22px;color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
              </div>
              <div style="flex:1;">
                <p style="font-size:14px;font-weight:600;color:var(--color-dark-900);margin-bottom:4px;">{{ $site->label('audit.results.cee_title', 'Primes CEE estimées — fiches cumulables') }}</p>
                <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:12px;">
                  <template x-for="f in results.cee.fiches" :key="f.fiche">
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:100px;font-size:11px;font-weight:600;background:rgba(245,158,11,0.1);color:#92400e;">
                      <span x-text="f.fiche"></span>
                      <span style="font-weight:400;color:#b45309;" x-text="'(' + formatNumber(f.gwh * 1000) + ' MWh)'"></span>
                    </span>
                  </template>
                </div>
                <div style="display:flex;align-items:baseline;gap:8px;margin-bottom:8px;">
                  <span style="font-size:28px;font-weight:600;color:#d97706;" x-text="formatCurrency(results.cee.valueLow) + ' — ' + formatCurrency(results.cee.valueHigh)"></span>
                </div>
                <p style="font-size:12px;color:var(--color-dark-400);">Volume total cumulé : <span x-text="formatNumber(results.cee.gwh * 1000)"></span> MWh cumac. Cours CEE : 6,50 &euro;/MWh cumac. Estimation indicative.</p>
                <a :href="'/generateur-cee?surface=' + form.surface + '&type=' + form.buildingType + '&age=' + form.buildingAge + '&zone=' + form.climateZone" style="display:inline-flex;align-items:center;gap:6px;margin-top:12px;font-size:13px;font-weight:500;color:var(--color-accent-600);text-decoration:none;">
                  {{ $site->label('audit.results.cee_cta', 'Affiner avec le simulateur CEE complet') }}
                  <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Jauge ISO 52120-1 -->
        <div class="diag-card" style="margin-top:20px;">
          <div class="diag-card-body" style="text-align:center;padding:28px;">
            <p style="font-size:13px;font-weight:600;color:var(--color-dark-500);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:16px;">{{ $site->label('audit.results.iso_class', 'Classe ISO 52120-1') }}</p>
            <div class="diag-gauge">
              <template x-for="lvl in [{key:'d', letter:'D', label:'Non performant'}, {key:'c', letter:'C', label:'Standard'}, {key:'b', letter:'B', label:'Avancé'}, {key:'a', letter:'A', label:'Haute perf.'}]" :key="lvl.key">
                <div class="diag-gauge-bar" :class="'level-' + lvl.key + (results.levelKey === lvl.key ? ' active' : (results.levelKey !== lvl.key ? ' dimmed' : ''))">
                  <span x-text="lvl.letter"></span>
                </div>
              </template>
            </div>
            <p class="diag-gauge-desc" x-text="results.levelDescription"></p>
          </div>
        </div>

        <!-- Urgence réglementaire -->
        <div class="diag-card" style="margin-top:20px;" x-show="results.regulatory.show">
          <div class="diag-card-body" style="padding:24px 28px;">
            <div class="diag-regulatory" :class="'diag-regulatory-' + results.regulatory.severity">
              <div class="diag-regulatory-icon">
                <svg x-show="results.regulatory.severity === 'critical'" style="width:22px;height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <svg x-show="results.regulatory.severity === 'warning'" style="width:22px;height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <svg x-show="results.regulatory.severity === 'ok'" style="width:22px;height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              </div>
              <div>
                <p class="diag-regulatory-title" x-text="results.regulatory.title"></p>
                <p class="diag-regulatory-text" x-text="results.regulatory.text"></p>
                <p x-show="results.regulatory.daysLeft > 0" class="diag-regulatory-countdown">
                  <span x-text="results.regulatory.daysLeft"></span> {{ $site->label('audit.results.days_left', "jours restants avant l'échéance") }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Benchmark ADEME -->
        <div class="diag-card" style="margin-top:20px;">
          <div class="diag-card-header"><h2>{{ $site->label('audit.results.benchmark_title', 'Benchmark énergétique') }}</h2><p>{{ $site->label('audit.results.benchmark_subtitle', 'Positionnement de votre bâtiment par rapport aux références ADEME.') }}</p></div>
          <div class="diag-card-body">
            <div class="diag-benchmark">
              <div class="diag-benchmark-bar-wrap">
                <div class="diag-benchmark-zone diag-benchmark-good" :style="'width:' + results.benchmark.goodPercent + '%'"><span>{{ $site->label('audit.results.benchmark_good', 'Performant') }}</span></div>
                <div class="diag-benchmark-zone diag-benchmark-avg" :style="'width:' + results.benchmark.avgPercent + '%'"><span>{{ $site->label('audit.results.benchmark_avg', 'Moyen') }}</span></div>
                <div class="diag-benchmark-zone diag-benchmark-bad" :style="'width:' + results.benchmark.badPercent + '%'"><span>{{ $site->label('audit.results.benchmark_bad', 'Énergivore') }}</span></div>
              </div>
              <div class="diag-benchmark-marker" :style="'left:' + results.benchmark.position + '%'">
                <div class="diag-benchmark-marker-dot"></div>
                <div class="diag-benchmark-marker-label">
                  <span x-text="formatNumber(results.benchmark.kwhM2) + ' kWh/m\u00B2/an'"></span>
                  <span style="font-weight:400;color:var(--color-dark-400);font-size:11px;">{{ $site->label('audit.results.your_building', 'Votre bâtiment') }}</span>
                </div>
              </div>
            </div>
            <div class="diag-benchmark-legend">
              <div><span class="diag-benchmark-dot" style="background:#16a34a;"></span><span x-text="'Réf. performant : ' + results.benchmark.refGood + ' kWh/m\u00B2/an'"></span></div>
              <div><span class="diag-benchmark-dot" style="background:#f59e0b;"></span><span x-text="'Réf. moyen : ' + results.benchmark.refAvg + ' kWh/m\u00B2/an'"></span></div>
              <div><span class="diag-benchmark-dot" style="background:#ef4444;"></span><span x-text="'Réf. énergivore : ' + results.benchmark.refBad + ' kWh/m\u00B2/an'"></span></div>
            </div>
            <p style="font-size:11px;color:var(--color-dark-400);margin-top:12px;">{{ $site->label('audit.results.benchmark_sources', 'Sources : OID/ADEME Baromètre 2022, OPERAT 2021, Arrêté valeurs absolues décret tertiaire (24/11/2020). Économies : NF EN ISO 52120-1:2022.') }}</p>
          </div>
        </div>

        <!-- Récap énergies -->
        <div class="diag-card" style="margin-top:20px;">
          <div class="diag-card-header"><h2>{{ $site->label('audit.results.energy_title', 'Récapitulatif de vos consommations') }}</h2></div>
          <div class="diag-card-body" style="padding-top:0;">
            <template x-for="(e, i) in results.energySummary" :key="i">
              <div class="diag-energy-row">
                <div style="display:flex;align-items:center;gap:12px;">
                  <span style="font-size:20px;" x-text="e.icon"></span>
                  <div>
                    <p style="font-size:14px;font-weight:500;color:var(--color-dark-800);" x-text="e.label"></p>
                    <p style="font-size:12px;color:var(--color-dark-400);" x-text="formatNumber(e.conso) + ' kWh/an'"></p>
                  </div>
                </div>
                <p style="font-size:14px;font-weight:600;color:var(--color-accent-600);" x-text="formatCurrency(e.facture) + ' /an'"></p>
              </div>
            </template>
            <div class="diag-energy-total">
              <span>{{ $site->label('audit.results.total', 'Total') }}</span>
              <span x-text="formatNumber(results.totalConso) + ' kWh — ' + formatCurrency(results.totalFacture) + ' /an'"></span>
            </div>
          </div>
        </div>

        <!-- Recommandations -->
        <div class="diag-card" style="margin-top:20px;">
          <div class="diag-card-header"><h2>{{ $site->label('audit.results.reco_title', 'Recommandations personnalisées') }}</h2></div>
          <div class="diag-card-body" style="padding-top:0;">
            <template x-for="(rec, i) in results.recommendations" :key="i">
              <div class="diag-rec-row">
                <div class="diag-rec-icon">
                  <svg style="width:16px;height:16px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </div>
                <p x-text="rec"></p>
              </div>
            </template>
          </div>
        </div>

        <!-- Offre premium -->
        <div class="diag-premium-card">
          <div class="diag-premium-badge">{{ $site->label('audit.premium.badge', 'Aller plus loin') }}</div>
          <h3 class="diag-premium-title">{{ $site->label('audit.premium.title', 'Ce diagnostic est une estimation basée sur vos déclarations') }}</h3>
          <p class="diag-premium-desc">{{ $site->label('audit.premium.desc', "Pour une analyse précise avec mesures terrain, un expert indépendant peut auditer votre bâtiment et identifier les gisements d'économies réels.") }}</p>
          <div class="diag-premium-grid">
            <div class="diag-premium-col">
              <p class="diag-premium-col-title">{{ $site->label('audit.premium.online_title', 'Diagnostic en ligne') }}</p>
              <p class="diag-premium-col-subtitle">{{ $site->label('audit.premium.online_subtitle', 'Ce que vous venez de faire') }}</p>
              <ul class="diag-premium-list">
                <li>{{ $site->label('audit.premium.online_1', 'Score ISO 52120-1 estimé') }}</li>
                <li>{{ $site->label('audit.premium.online_2', 'Benchmark ADEME indicatif') }}</li>
                <li>{{ $site->label('audit.premium.online_3', 'Recommandations génériques') }}</li>
                <li>{{ $site->label('audit.premium.online_4', 'Rapport PDF basique') }}</li>
              </ul>
              <p class="diag-premium-price">{{ $site->label('audit.premium.online_price', 'Gratuit') }}</p>
            </div>
            <div class="diag-premium-col diag-premium-col-highlight">
              <p class="diag-premium-col-title">{{ $site->label('audit.premium.onsite_title', 'Audit sur site') }}</p>
              <p class="diag-premium-col-subtitle">{{ $site->label('audit.premium.onsite_subtitle', 'Par un expert indépendant NeoGTB') }}</p>
              <ul class="diag-premium-list">
                <li>{{ $site->label('audit.premium.onsite_1', 'Mesures terrain instrumentées') }}</li>
                <li>{{ $site->label('audit.premium.onsite_2', 'Classification ISO 52120-1 certifiée') }}</li>
                <li>{{ $site->label('audit.premium.onsite_3', "Plan d'actions chiffré et priorisé") }}</li>
                <li>{{ $site->label('audit.premium.onsite_4', 'Rapport 20+ pages avec ROI') }}</li>
                <li>{{ $site->label('audit.premium.onsite_5', 'Conformité décret BACS vérifiée') }}</li>
                <li>{{ $site->label('audit.premium.onsite_6', 'Dossier CEE pré-constitué') }}</li>
              </ul>
              <a href="/contact" class="diag-btn-accent" style="width:100%;justify-content:center;text-decoration:none;">
                {{ $site->label('audit.premium.onsite_cta', 'Demander un audit sur site') }}
              </a>
            </div>
          </div>
        </div>

        <!-- Disclaimer -->
        <div class="diag-disclaimer">
          <svg style="width:18px;height:18px;color:#b45309;flex-shrink:0;margin-top:2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
          <div>
            <p style="font-weight:600;color:#92400e;font-size:13px;margin-bottom:4px;">{{ $site->label('audit.disclaimer.title', 'Estimation indicative') }}</p>
            <p style="font-size:13px;color:#78350f;line-height:1.6;">{{ $site->label('audit.disclaimer.text', "Ce résultat est basé sur vos déclarations et des données statistiques (OID/ADEME 2022, OPERAT 2021, NF EN ISO 52120-1:2022). Il ne constitue pas un document réglementaire. NeoGTB est indépendant et ne perçoit aucune commission.") }}</p>
          </div>
        </div>

        <!-- Actions -->
        <div class="diag-actions">
          <button @click="showEmailGate()" class="diag-btn-primary" style="flex:1;">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            {{ $site->label('audit.actions.download_pdf', 'Télécharger le rapport PDF') }}
          </button>
          <a href="/contact" class="diag-btn-accent" style="flex:1;text-decoration:none;text-align:center;justify-content:center;">{{ $site->label('audit.actions.contact_expert', 'Être contacté par un expert') }}</a>
          <a :href="'/comparateur?surface=' + form.surface + '&type=' + form.buildingType" class="diag-btn-ghost" style="flex:1;text-decoration:none;text-align:center;justify-content:center;">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            {{ $site->label('audit.actions.compare', 'Comparer les solutions GTB') }}
          </a>
          <a :href="'/generateur-cee?surface=' + form.surface + '&type=' + form.buildingType + '&age=' + form.buildingAge + '&zone=' + form.climateZone" class="diag-btn-ghost" style="flex:1;text-decoration:none;text-align:center;justify-content:center;">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            {{ $site->label('audit.actions.estimate_cee', 'Estimer mes aides CEE') }}
          </a>
          <button @click="resetDiag()" class="diag-btn-ghost" style="flex:1;">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            {{ $site->label('audit.actions.new_diag', 'Nouveau diagnostic') }}
          </button>
        </div>

        <!-- Modal email gate -->
        <div x-show="showEmailModal" x-transition.opacity @keydown.escape.window="showEmailModal = false" class="diag-modal-overlay" role="presentation">
          <div @click.outside="showEmailModal = false" class="diag-modal" role="dialog" aria-modal="true">
            <h3 style="font-size:18px;font-weight:500;color:var(--color-dark-900);margin-bottom:4px;">{{ $site->label('audit.modal.title', 'Recevoir votre rapport PDF') }}</h3>
            <p style="font-size:13px;color:var(--color-dark-400);margin-bottom:16px;">{{ $site->label('audit.modal.subtitle', 'Entrez votre email pour télécharger votre diagnostic complet.') }}</p>
            <input type="email" x-model="emailAddress" placeholder="{{ $site->label('audit.modal.email_placeholder', 'votre@email.com') }}" class="diag-input" style="margin-bottom:8px;">
            <input type="text" x-model="userName" placeholder="{{ $site->label('audit.modal.name_placeholder', 'Votre nom (optionnel)') }}" class="diag-input" style="margin-bottom:8px;">
            <input type="text" x-model="userCompany" placeholder="{{ $site->label('audit.modal.company_placeholder', 'Entreprise (optionnel)') }}" class="diag-input" style="margin-bottom:12px;">
            {{-- Honeypot anti-bot (champ leurre, ne pas remplir) --}}
            <input type="text" x-model="honeypot" name="_gotcha" style="display:none!important;position:absolute;left:-9999px" tabindex="-1" autocomplete="off" aria-hidden="true">

            <label style="display:flex;gap:10px;align-items:flex-start;padding:12px;border:1px solid var(--color-dark-200);border-radius:10px;background:var(--color-dark-50);margin-bottom:12px;cursor:pointer;" :style="consentError ? 'border-color:#dc2626;background:#fef2f2;' : ''">
              <input type="checkbox" x-model="consentRgpd" @change="consentError = false" style="margin-top:3px;width:16px;height:16px;accent-color:var(--color-accent-600);flex-shrink:0;" aria-required="true">
              <span style="font-size:12px;color:var(--color-dark-700);line-height:1.55;">
                {{ $site->label('audit.modal.consent_text', "J'accepte que NeoGTB utilise mon email pour m'envoyer mon rapport d'audit personnalisé et, le cas échéant, un suivi conseil.") }} <span style="color:#dc2626;">*</span>
              </span>
            </label>
            <p x-show="consentError" x-transition style="font-size:11px;color:#dc2626;margin:-6px 0 10px;">{{ $site->label('audit.modal.consent_error', 'Merci de cocher cette case pour recevoir votre rapport.') }}</p>

            <div style="font-size:10.5px;color:var(--color-dark-400);line-height:1.6;margin-bottom:16px;padding:10px 12px;border-left:2px solid var(--color-dark-200);background:var(--color-dark-50);border-radius:0 6px 6px 0;">
              <p style="margin:0 0 4px;font-weight:600;color:var(--color-dark-600);">{{ $site->label('audit.modal.rgpd_title', 'Information RGPD (art. 13)') }}</p>
              <p style="margin:0;">{!! $site->label('audit.modal.rgpd_text', 'Responsable : NeoGTB. <strong>Finalité</strong> : envoi du rapport d\'audit GTB personnalisé et suivi conseil. <strong>Base légale</strong> : consentement. <strong>Durée de conservation</strong> : 3 ans à compter du dernier contact. Vous disposez d\'un droit d\'accès, de rectification, d\'effacement, de limitation, d\'opposition et de portabilité, ainsi que du droit de retirer votre consentement à tout moment, via <a href="/mes-droits-rgpd" style="color:var(--color-accent-600);">/mes-droits-rgpd</a>. Détails : <a href="/politique-de-confidentialite" style="color:var(--color-accent-600);">politique de confidentialité</a>.') !!}</p>
            </div>

            <div style="display:flex;gap:12px;">
              <button @click="showEmailModal = false" class="diag-btn-ghost" style="flex:1;">{{ $site->label('forms.cancel', 'Annuler') }}</button>
              <button @click="downloadPDF()" class="diag-btn-accent" style="flex:1;" :disabled="!consentRgpd || !emailAddress" :style="(!consentRgpd || !emailAddress) ? 'opacity:0.5;cursor:not-allowed;' : ''">
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                {{ $site->label('audit.modal.download_btn', 'Télécharger') }}
              </button>
            </div>
            <p x-show="emailSent" style="margin-top:12px;font-size:13px;color:var(--color-accent-600);font-weight:500;text-align:center;">{{ $site->label('audit.modal.success', 'PDF téléchargé !') }}</p>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- Trust badge -->
  <section style="padding:48px 0 64px;background:var(--color-dark-50);border-top:1px solid var(--color-dark-200);">
    <div style="max-width:600px;margin:0 auto;padding:0 24px;text-align:center;">
      <div style="display:inline-flex;align-items:center;gap:10px;padding:10px 20px;border-radius:100px;background:white;border:1px solid var(--color-dark-200);">
        <svg style="width:18px;height:18px;color:var(--color-accent-600);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        <span style="font-size:13px;font-weight:500;color:var(--color-dark-700);">{{ $site->label('audit.trust_badge', 'Outil indépendant — NeoGTB ne perçoit aucune commission') }}</span>
      </div>
    </div>
  </section>

  <!-- Pages associées -->
  <section class="py-10 lg:py-20 bg-white">
    <div class="max-w-4xl mx-auto px-5 lg:px-10">
      <h2 class="text-lg font-heading font-medium text-dark-800 mb-6">{{ $site->label('audit.related.title', 'Pages associées') }}</h2>
      <div class="grid md:grid-cols-3 gap-4">
        <a href="/comparateur" class="block p-5 rounded-2xl border border-dark-100 hover:border-primary-300 transition-colors group">
          <p class="font-medium text-dark-900 group-hover:text-primary-600 transition-colors">{{ $site->label('audit.related.comparateur', 'Comparateur GTB') }}</p>
          <p class="text-sm text-dark-400 mt-1">{{ $site->label('audit.related.comparateur_desc', 'Comparez les solutions après votre diagnostic.') }}</p>
        </a>
        <a href="/generateur-cee" class="block p-5 rounded-2xl border border-dark-100 hover:border-primary-300 transition-colors group">
          <p class="font-medium text-dark-900 group-hover:text-primary-600 transition-colors">{{ $site->label('audit.related.cee', 'Simulateur CEE') }}</p>
          <p class="text-sm text-dark-400 mt-1">{{ $site->label('audit.related.cee_desc', 'Estimez vos primes pour financer votre projet GTB.') }}</p>
        </a>
        <a href="/reglementation" class="block p-5 rounded-2xl border border-dark-100 hover:border-primary-300 transition-colors group">
          <p class="font-medium text-dark-900 group-hover:text-primary-600 transition-colors">{{ $site->label('audit.related.reglementation', 'Réglementation GTB') }}</p>
          <p class="text-sm text-dark-400 mt-1">{{ $site->label('audit.related.reglementation_desc', 'Décret BACS, calendrier des obligations.') }}</p>
        </a>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('diagWizard', () => ({
      step: 1,
      totalSteps: 4,
      currentQuestion: 0,
      animatedScore: 0,
      stepLabels: ['B\u00e2timent', 'Lots techniques', 'Maturit\u00e9 GTB', 'R\u00e9sultats'],
      errors: {},
      showEmailModal: false,
      emailAddress: '',
      userName: '',
      userCompany: '',
      honeypot: '',
      emailSent: false,
      consentRgpd: false,
      consentError: false,

      buildingTypes: [
        { id: 'bureau', label: 'Bureaux', icon: '\u{1F3E2}' },
        { id: 'commerce', label: 'Commerce', icon: '\u{1F6D2}' },
        { id: 'industrie', label: 'Industrie', icon: '\u{1F3ED}' },
        { id: 'sante', label: 'Sant\u00e9', icon: '\u{1F3E5}' },
        { id: 'education', label: 'Enseignement', icon: '\u{1F3EB}' },
        { id: 'hotel', label: 'H\u00f4tellerie', icon: '\u{1F3E8}' },
      ],

      ademeRefs: {
        bureau: [107, 170, 300], commerce: [160, 280, 450], industrie: [100, 220, 400],
        sante: [200, 400, 700], education: [80, 118, 230], hotel: [150, 260, 420],
      },

      puissanceRatios: {
        bureau: 0.07, commerce: 0.09, industrie: 0.06, sante: 0.12, education: 0.06, hotel: 0.10,
      },

      gtbQuestions: [
        { title: 'R\u00e9gulation CVC \u2014 Disposez-vous d\'un syst\u00e8me de r\u00e9gulation du chauffage, ventilation et climatisation ?', options: [
          { value: 0, label: 'Aucune r\u00e9gulation (tout en manuel)' },
          { value: 1, label: 'R\u00e9gulation basique (thermostats simples)' },
          { value: 2, label: 'R\u00e9gulation par zone avec programmation horaire' },
          { value: 3, label: 'R\u00e9gulation avanc\u00e9e avec optimisation automatique' },
        ]},
        { title: '\u00c9clairage \u2014 Comment est g\u00e9r\u00e9 l\'\u00e9clairage de votre b\u00e2timent ?', options: [
          { value: 0, label: 'Interrupteurs manuels uniquement' },
          { value: 1, label: 'Minuteries ou programmation horaire' },
          { value: 2, label: 'D\u00e9tection de pr\u00e9sence et variation d\'intensit\u00e9' },
          { value: 3, label: 'Gestion intelligente compl\u00e8te (daylight harvesting, sc\u00e9narios)' },
        ]},
        { title: 'Suivi des consommations \u2014 Avez-vous un suivi \u00e9nerg\u00e9tique en place ?', options: [
          { value: 0, label: 'Aucun suivi' },
          { value: 1, label: 'Relev\u00e9 manuel des compteurs' },
          { value: 2, label: 'Sous-comptage automatique par usage' },
          { value: 3, label: 'Monitoring temps r\u00e9el avec alertes de d\u00e9rive' },
        ]},
        { title: 'Supervision \u2014 Disposez-vous d\'une supervision centralis\u00e9e des lots techniques ?', options: [
          { value: 0, label: 'Aucune supervision' },
          { value: 1, label: 'Supervision partielle (un seul lot technique)' },
          { value: 2, label: 'GTC centralis\u00e9e sur plusieurs lots' },
          { value: 3, label: 'GTB compl\u00e8te avec pilotage et optimisation multi-lots' },
        ]},
        { title: 'Maintenance \u2014 Quel est votre mode de maintenance dominant ?', options: [
          { value: 0, label: 'Curative uniquement (on r\u00e9pare quand \u00e7a casse)' },
          { value: 1, label: 'Pr\u00e9ventive planifi\u00e9e' },
          { value: 2, label: 'Conditionnelle (bas\u00e9e sur les donn\u00e9es capteurs)' },
          { value: 3, label: 'Pr\u00e9dictive (anticipation des pannes par IA/analyse)' },
        ]},
        { title: 'Conformit\u00e9 \u2014 Quel est votre niveau de connaissance et conformit\u00e9 r\u00e9glementaire ?', options: [
          { value: 0, label: 'Je ne connais pas les obligations r\u00e9glementaires' },
          { value: 1, label: 'Connaissance partielle, conformit\u00e9 incertaine' },
          { value: 2, label: 'Conforme au d\u00e9cret tertiaire, BACS en cours' },
          { value: 3, label: 'Pleinement conforme avec reporting automatis\u00e9 (OPERAT)' },
        ]},
      ],

      form: {
        buildingType: '', surface: null, surfaceChauffage: null, buildingAge: '', climateZone: '',
        hasEcs: null, surfaceEcs: null, hasClim: null, surfaceClim: null, hasEclairage: null,
        eclairage: '', surfaceEclairage: null, hasAuxiliaires: null, surfaceAuxiliaires: null, gtbAnswers: {},
      },

      ceeZoneCoeff: { 'H1': 1.3, 'H2': 1.0, 'H3': 0.7, 'DOM': 1.4 },
      ceeAgeCoeff: { 'before1975': 1.5, '1975-2000': 1.2, '2000-2012': 1.0, 'after2012': 0.6 },
      ceeTypeCoeff: { 'bureau': 1.0, 'commerce': 0.9, 'industrie': 1.3, 'sante': 1.4, 'education': 1.1, 'hotel': 1.2 },
      ceePricePerMwh: 6.50,

      results: {
        score: 0, levelKey: 'd', levelLabel: '', levelDescription: '',
        savingsEuro: 0, savingsPercent: 0, totalConso: 0, totalFacture: 0,
        energySummary: [],
        benchmark: { kwhM2: 0, position: 50, refGood: 0, refAvg: 0, refBad: 0, goodPercent: 33, avgPercent: 34, badPercent: 33 },
        regulatory: { show: false, severity: 'ok', title: '', text: '', daysLeft: 0 },
        recommendations: [],
        cee: { gwh: 0, valueLow: 0, valueHigh: 0, eligible: false, fiches: [] },
      },

      formatNumber(n) { if (!n) return '0'; return new Intl.NumberFormat('fr-FR').format(Math.round(n)); },
      formatCurrency(n) { return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR', maximumFractionDigits: 0 }).format(n || 0); },

      scrollToWizard() {
        const el = this.$refs.wizardTop;
        if (!el) return;
        const top = el.getBoundingClientRect().top + window.scrollY - 90;
        if (window.scrollY > top + 20) { window.scrollTo({ top, behavior: 'smooth' }); }
      },

      selectAnswer(qi, value) {
        this.form.gtbAnswers[qi] = value;
        if (qi < this.gtbQuestions.length - 1) { setTimeout(() => { this.nextQuestion(); }, 800); }
      },

      nextQuestion() {
        if (this.form.gtbAnswers[this.currentQuestion] !== undefined && this.currentQuestion < this.gtbQuestions.length - 1) { this.currentQuestion++; }
      },

      validateStep1() {
        this.errors = {};
        if (!this.form.buildingType) this.errors.buildingType = 'S\u00e9lectionnez un type';
        if (!this.form.surface || this.form.surface < 50) this.errors.surface = 'Surface minimale : 50 m\u00b2';
        if (!this.form.climateZone) this.errors.climateZone = 'S\u00e9lectionnez une zone';
        if (!this.form.buildingAge) this.errors.buildingAge = 'S\u00e9lectionnez une p\u00e9riode';
        if (Object.keys(this.errors).length === 0) { this.step = 2; this.scrollToWizard(); }
      },

      validateStep2() {
        this.errors = {};
        if (!this.form.surfaceChauffage || this.form.surfaceChauffage < 1) this.errors.surfaceChauffage = 'Renseignez la surface chauff\u00e9e.';
        if (this.form.hasEcs === null) this.errors.hasEcs = 'R\u00e9pondez \u00e0 cette question.';
        if (this.form.hasEcs === true && (!this.form.surfaceEcs || this.form.surfaceEcs < 1)) this.errors.surfaceEcs = 'Renseignez la surface desservie.';
        if (this.form.hasClim === null) this.errors.hasClim = 'R\u00e9pondez \u00e0 cette question.';
        if (this.form.hasClim === true && (!this.form.surfaceClim || this.form.surfaceClim < 1)) this.errors.surfaceClim = 'Renseignez la surface climatis\u00e9e.';
        if (this.form.hasEclairage === null) this.errors.hasEclairage = 'R\u00e9pondez \u00e0 cette question.';
        if (this.form.hasEclairage === true && (!this.form.surfaceEclairage || this.form.surfaceEclairage < 1)) this.errors.surfaceEclairage = 'Renseignez la surface \u00e9clair\u00e9e.';
        if (this.form.hasEclairage === true && !this.form.eclairage) this.errors.eclairage = 'S\u00e9lectionnez un type de gestion.';
        if (this.form.hasAuxiliaires === null) this.errors.hasAuxiliaires = 'R\u00e9pondez \u00e0 cette question.';
        if (this.form.hasAuxiliaires === true && (!this.form.surfaceAuxiliaires || this.form.surfaceAuxiliaires < 1)) this.errors.surfaceAuxiliaires = 'Renseignez la surface concern\u00e9e.';
        if (Object.keys(this.errors).length === 0) { this.step = 3; this.scrollToWizard(); }
      },

      validateStep3() {
        this.errors = {};
        const answered = Object.keys(this.form.gtbAnswers).length;
        if (answered < this.gtbQuestions.length) { this.errors.gtb = 'R\u00e9pondez \u00e0 toutes les questions.'; return; }
        this.calculateResults();
        this.animatedScore = 0;
        this.step = 4;
        this.scrollToWizard();
        if (!window._jsPDFModule) { import('jspdf').then(m => { window._jsPDFModule = m; }).catch(() => {}); }
        if (!window._neogtbLogo) { const img = new Image(); img.src = '/images/logo-neogtb-pdf.png'; img.onload = () => { window._neogtbLogo = img; }; }
        const target = this.results.score; const self = this; let current = 0;
        const interval = setInterval(() => { current += Math.ceil(target / 25); if (current >= target) { current = target; clearInterval(interval); } self.animatedScore = current; }, 30);
        try { localStorage.setItem('neogtb_diag', JSON.stringify({ buildingType: this.form.buildingType, surface: this.form.surface, buildingAge: this.form.buildingAge, climateZone: this.form.climateZone, score: this.results.score, levelKey: this.results.levelKey })); } catch(e) {}
      },

      calculateResults() {
        let gtbTotal = 0;
        for (let i = 0; i < this.gtbQuestions.length; i++) { gtbTotal += parseInt(this.form.gtbAnswers[i] || 0); }
        const ratiosConso = {
          chauffage: { bureau: 80, education: 90, commerce: 100, hotel: 110, sante: 120, industrie: 100 },
          ecs: { bureau: 10, education: 15, commerce: 8, hotel: 40, sante: 35, industrie: 8 },
          clim: { bureau: 30, education: 15, commerce: 50, hotel: 25, sante: 20, industrie: 25 },
          eclairage: { bureau: 25, education: 20, commerce: 40, hotel: 15, sante: 22, industrie: 30 },
          auxiliaires: { bureau: 10, education: 8, commerce: 12, hotel: 10, sante: 15, industrie: 15 },
        };
        const prixMoyenKwh = 0.14;
        const bt = this.form.buildingType;
        let totalConso = 0;
        const energySummary = [];
        if (this.form.surfaceChauffage > 0) { const ratio = ratiosConso.chauffage[bt] || 90; const conso = Math.round(this.form.surfaceChauffage * ratio); totalConso += conso; energySummary.push({ label: 'Chauffage', icon: '\u{1F525}', conso, facture: Math.round(conso * prixMoyenKwh), surface: this.form.surfaceChauffage }); }
        if (this.form.hasEcs && this.form.surfaceEcs > 0) { const ratio = ratiosConso.ecs[bt] || 15; const conso = Math.round(this.form.surfaceEcs * ratio); totalConso += conso; energySummary.push({ label: 'ECS', icon: '\u{1F6BF}', conso, facture: Math.round(conso * prixMoyenKwh), surface: this.form.surfaceEcs }); }
        if (this.form.hasClim && this.form.surfaceClim > 0) { const ratio = ratiosConso.clim[bt] || 30; const conso = Math.round(this.form.surfaceClim * ratio); totalConso += conso; energySummary.push({ label: 'Climatisation', icon: '\u2744\uFE0F', conso, facture: Math.round(conso * prixMoyenKwh), surface: this.form.surfaceClim }); }
        if (this.form.hasEclairage && this.form.surfaceEclairage > 0) { const ratio = ratiosConso.eclairage[bt] || 25; const conso = Math.round(this.form.surfaceEclairage * ratio); totalConso += conso; energySummary.push({ label: '\u00c9clairage', icon: '\u{1F4A1}', conso, facture: Math.round(conso * prixMoyenKwh), surface: this.form.surfaceEclairage }); }
        if (this.form.hasAuxiliaires && this.form.surfaceAuxiliaires > 0) { const ratio = ratiosConso.auxiliaires[bt] || 10; const conso = Math.round(this.form.surfaceAuxiliaires * ratio); totalConso += conso; energySummary.push({ label: 'Auxiliaires', icon: '\u{1F50C}', conso, facture: Math.round(conso * prixMoyenKwh), surface: this.form.surfaceAuxiliaires }); }
        const totalFacture = Math.round(totalConso * prixMoyenKwh);
        this.results.totalConso = totalConso; this.results.totalFacture = totalFacture; this.results.energySummary = energySummary;
        const refs = this.ademeRefs[this.form.buildingType] || [100, 200, 350];
        const kwhM2 = this.form.surface > 0 ? totalConso / this.form.surface : 0;
        this.results.benchmark.kwhM2 = kwhM2; this.results.benchmark.refGood = refs[0]; this.results.benchmark.refAvg = refs[1]; this.results.benchmark.refBad = refs[2];
        const barMax = refs[2] * 1.3;
        this.results.benchmark.goodPercent = Math.floor((refs[0] / barMax) * 100);
        this.results.benchmark.avgPercent = Math.floor(((refs[1] - refs[0]) / barMax) * 100);
        this.results.benchmark.badPercent = 100 - this.results.benchmark.goodPercent - this.results.benchmark.avgPercent;
        this.results.benchmark.position = Math.min(98, Math.max(2, Math.round((kwhM2 / barMax) * 100)));
        const weights = [2, 1, 1, 2, 1, 1];
        let weightedTotal = 0, weightedMax = 0;
        for (let i = 0; i < this.gtbQuestions.length; i++) { weightedTotal += parseInt(this.form.gtbAnswers[i] || 0) * weights[i]; weightedMax += 3 * weights[i]; }
        const score = Math.round((weightedTotal / weightedMax) * 100);
        this.results.score = score;
        if (score < 25) { this.results.levelKey = 'd'; this.results.levelLabel = 'Classe D \u2014 Non performant'; this.results.levelDescription = 'Votre b\u00e2timent ne dispose pas de gestion technique conforme. Le potentiel d\'optimisation est estim\u00e9 entre 30 et 50 % selon la norme ISO 52120-1.'; }
        else if (score < 50) { this.results.levelKey = 'c'; this.results.levelLabel = 'Classe C \u2014 Standard'; this.results.levelDescription = 'Automatisation de base correspondant \u00e0 la classe C. Un passage en classe B permettrait 10 \u00e0 20 % d\'\u00e9conomies suppl\u00e9mentaires.'; }
        else if (score < 75) { this.results.levelKey = 'b'; this.results.levelLabel = 'Classe B \u2014 Avanc\u00e9'; this.results.levelDescription = 'GTB performante de classe B. Quelques optimisations cibl\u00e9es peuvent vous rapprocher de la classe A.'; }
        else { this.results.levelKey = 'a'; this.results.levelLabel = 'Classe A \u2014 Haute performance'; this.results.levelDescription = 'Niveau le plus \u00e9lev\u00e9 d\'automatisation ISO 52120-1. Vous \u00eates conforme aux exigences les plus strictes du d\u00e9cret BACS.'; }
        let savingsPercent = 0;
        if (score < 25) savingsPercent = 30; else if (score < 50) savingsPercent = 25; else if (score < 75) savingsPercent = 15; else savingsPercent = 5;
        this.results.savingsPercent = savingsPercent;
        this.results.savingsEuro = Math.round(totalFacture * savingsPercent / 100);
        if (score < 75) {
          const zC = this.ceeZoneCoeff[this.form.climateZone] || 1; const aC = this.ceeAgeCoeff[this.form.buildingAge] || 1; const tC = this.ceeTypeCoeff[this.form.buildingType] || 1;
          const cvcScore = parseInt(this.form.gtbAnswers[0] || 0); const eclScore = parseInt(this.form.gtbAnswers[1] || 0);
          const fiches = [];
          if (cvcScore < 3) { const surfCvc = (this.form.surfaceChauffage || 0) + (this.form.hasClim && this.form.surfaceClim ? this.form.surfaceClim : 0); if (surfCvc > 0) { const gwh = 0.042 * surfCvc * zC * aC * tC / 1000; fiches.push({ fiche: 'BAT-TH-116', label: 'GTB r\u00e9gulation CVC', gwh }); } }
          if (cvcScore < 2 && this.form.hasClim && this.form.surfaceClim > 0) { const gwh = 0.028 * this.form.surfaceClim * zC * aC * tC / 1000; fiches.push({ fiche: 'BAT-TH-145', label: 'Climatisation performante', gwh }); }
          if (eclScore < 2 && this.form.hasEclairage && this.form.surfaceEclairage > 0) { const gwh = 0.018 * this.form.surfaceEclairage * zC * aC * tC / 1000; fiches.push({ fiche: 'BAT-EQ-127', label: '\u00c9clairage performant', gwh }); }
          const totalGwh = fiches.reduce((sum, f) => sum + f.gwh, 0); const valueBase = totalGwh * this.ceePricePerMwh * 1000;
          this.results.cee = { gwh: totalGwh, valueLow: Math.round(valueBase * 0.75), valueHigh: Math.round(valueBase * 1.25), eligible: fiches.length > 0, fiches };
        } else { this.results.cee = { gwh: 0, valueLow: 0, valueHigh: 0, eligible: false, fiches: [] }; }
        const puissanceKW = this.form.surface * (this.puissanceRatios[this.form.buildingType] || 0.07);
        const now = new Date();
        if (puissanceKW >= 290) { this.results.regulatory = { show: true, severity: 'critical', title: 'Obligation GTB d\u00e9pass\u00e9e \u2014 d\u00e9cret BACS', text: 'Puissance CVC estim\u00e9e : ' + Math.round(puissanceKW) + ' kW (> 290 kW). L\'obligation de GTB de classe C minimum est effective depuis le 1er janvier 2025.', daysLeft: 0 }; }
        else if (puissanceKW >= 70) { const deadline = new Date('2030-01-01'); const daysLeft = Math.max(0, Math.ceil((deadline - now) / (1000*60*60*24))); this.results.regulatory = { show: true, severity: 'warning', title: '\u00c9ch\u00e9ance d\u00e9cret BACS \u2014 1er janvier 2030', text: 'Puissance CVC estim\u00e9e : ' + Math.round(puissanceKW) + ' kW (> 70 kW). L\'obligation GTB de classe C minimum s\'appliquera au 1er janvier 2030.', daysLeft }; }
        else { this.results.regulatory = { show: true, severity: 'ok', title: 'Pas d\'obligation imm\u00e9diate', text: 'Puissance CVC estim\u00e9e : ' + Math.round(puissanceKW) + ' kW (< 70 kW). Vous n\'\u00eates pas soumis au d\u00e9cret BACS actuellement.', daysLeft: 0 }; }
        const recs = [];
        if (score < 25) { recs.push('R\u00e9aliser un audit \u00e9nerg\u00e9tique conforme NF EN 16247-2'); recs.push('Installer des capteurs de temp\u00e9rature et de pr\u00e9sence'); recs.push('Mettre en place un suivi des consommations par sous-comptage'); recs.push('\u00c9tudier la faisabilit\u00e9 d\'une GTB de classe C minimum'); recs.push('Identifier les CEE mobilisables (fiches BAT-TH-116, BAT-TH-145)'); }
        else if (score < 50) { recs.push('Centraliser la supervision sur une GTC unique avec BACnet/IP ou KNX'); recs.push('Am\u00e9liorer la r\u00e9gulation CVC avec capteurs CO\u2082'); recs.push('Automatiser le suivi \u00e9nerg\u00e9tique avec alertes de d\u00e9rive'); recs.push('Passer \u00e0 une maintenance conditionnelle'); recs.push('\u00c9tudier la migration vers une classe B ISO 52120-1'); }
        else if (score < 75) { recs.push('Explorer les solutions d\'IA pour l\'optimisation pr\u00e9dictive'); recs.push('Optimiser les sc\u00e9narios selon l\'occupation r\u00e9elle'); recs.push('Automatiser le reporting r\u00e9glementaire (OPERAT)'); recs.push('\u00c9valuer la conformit\u00e9 au label R2S-4GRIDS'); }
        else { recs.push('Partager votre retour d\'exp\u00e9rience (AFNOR, CEN TC 247)'); recs.push('Explorer les derni\u00e8res innovations : IA g\u00e9n\u00e9rative, Matter, blockchain'); recs.push('\u00c9tendre votre approche GTB classe A \u00e0 l\'ensemble de votre parc'); recs.push('Viser les certifications HQE, BREEAM In-Use, LEED O+M'); }
        if (kwhM2 > refs[1]) { recs.push('Votre consommation (' + Math.round(kwhM2) + ' kWh/m\u00b2/an) d\u00e9passe la moyenne ADEME (' + refs[1] + ' kWh/m\u00b2/an)'); }
        this.results.recommendations = recs;
      },

      showEmailGate() { this.showEmailModal = true; this.emailSent = false; },

      async downloadPDF() {
        if (!this.consentRgpd) { this.consentError = true; return; }
        try {
          if (this.emailAddress && this.emailAddress.includes('@')) {
            try { fetch('/audit/lead', { method: 'POST', body: JSON.stringify({ _gotcha: this.honeypot || '', email: this.emailAddress, name: this.userName || null, company: this.userCompany || null, consentement_rgpd: true, score: this.results.score, level_label: this.results.levelLabel, surface: this.form.surface, building_type: this.form.buildingType, savings_euro: this.results.savingsEuro, payload: { form: this.form, results: this.results } }), headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '', 'X-Requested-With': 'XMLHttpRequest' } }).catch(() => {}); } catch(e) {}
          }
          const jsPDFModule = window.jspdf || await import('jspdf');
          const { jsPDF } = jsPDFModule;
          const doc = new jsPDF(); const m = 20; const pw = 170; let y = m;
          let logoImg = window._neogtbLogo;
          if (!logoImg) { logoImg = new Image(); logoImg.src = '/images/logo-neogtb-pdf.png'; try { await new Promise((resolve) => { logoImg.onload = resolve; logoImg.onerror = resolve; setTimeout(resolve, 2000); }); } catch(e) {} window._neogtbLogo = logoImg; }
          doc.setFillColor(27, 58, 92); doc.rect(0, 0, 210, 45, 'F');
          try { doc.addImage(logoImg, 'PNG', m, 8, 30, 30); } catch(e) {}
          doc.setTextColor(255,255,255); doc.setFontSize(20); doc.text('NeoGTB', m+35, 22);
          doc.setFontSize(9); doc.setTextColor(180,200,220); doc.text('Conseil indépendant en GTB', m+35, 30);
          doc.text('neogtb.fr  |  hello@neogtb.fr', m+35, 37);
          const ref = crypto.randomUUID ? crypto.randomUUID().slice(0,8) : Math.random().toString(36).slice(2,10);
          doc.setFontSize(7); doc.setTextColor(140,170,200); doc.text('Ref : DIAG-'+ref.toUpperCase(), 190, 10, {align:'right'});
          doc.text(new Date().toLocaleDateString('fr-FR', {day:'numeric',month:'long',year:'numeric'}), 190, 15, {align:'right'});
          y = 55;
          doc.setFontSize(18); doc.setTextColor(15,23,42); doc.text('Diagnostic GTB \u2014 Rapport de performance', m, y); y += 5;
          doc.setDrawColor(13,148,136); doc.setLineWidth(1.5); doc.line(m, y, m+60, y); y += 15;
          const levelColors = {d:[153,27,27],c:[146,64,14],b:[6,95,70],a:[13,148,136]};
          const lc = levelColors[this.results.levelKey] || [15,23,42];
          doc.setFillColor(lc[0],lc[1],lc[2]); doc.roundedRect(m, y, 80, 38, 4, 4, 'F');
          doc.setFontSize(8); doc.setTextColor(255,255,255,160); doc.text('SCORE DE MATURITÉ GTB', m+5, y+10);
          doc.setFontSize(24); doc.setTextColor(255,255,255); doc.text(this.results.score+' / 100', m+5, y+26);
          doc.setFontSize(9); doc.setTextColor(255,255,255,180); doc.text(this.results.levelLabel, m+5, y+34);
          doc.setFillColor(28,25,23); doc.roundedRect(m+85, y, 85, 38, 4, 4, 'F');
          doc.setFontSize(8); doc.setTextColor(180,200,220); doc.text('ÉCONOMIES POTENTIELLES', m+90, y+10);
          doc.setFontSize(22); doc.setTextColor(255,255,255); doc.text(this.formatCurrency(this.results.savingsEuro)+' /an', m+90, y+26);
          doc.setFontSize(9); doc.setTextColor(180,200,220); doc.text('soit '+this.results.savingsPercent+'% de vos dépenses', m+90, y+34);
          y += 50;
          doc.setFillColor(248,250,252); doc.roundedRect(m, y, pw, 32, 4, 4, 'F');
          doc.setFontSize(10); doc.setTextColor(15,23,42); doc.text('Paramètres du bâtiment', m+5, y+10); y += 15;
          doc.setFontSize(9);
          const bType = this.buildingTypes.find(b => b.id === this.form.buildingType);
          const ageLabels = {'before1975':'Avant 1975','1975-2000':'1975-2000','2000-2012':'2000-2012','after2012':'Après 2012'};
          const params = [['Type', bType ? bType.label : ''],['Surface', this.formatNumber(this.form.surface)+' m\u00B2'],['Zone', this.form.climateZone],['Construction', ageLabels[this.form.buildingAge]||'']];
          for (const [label, val] of params) { doc.setTextColor(100,116,139); doc.text(label, m+5, y); doc.setTextColor(15,23,42); doc.text(val, m+50, y); y += 5; }
          y += 10;
          doc.setFontSize(10); doc.setTextColor(15,23,42); doc.text('Recommandations', m, y); y += 7;
          doc.setFontSize(8.5); doc.setTextColor(68,64,60);
          for (const rec of this.results.recommendations) { const lines = doc.splitTextToSize('\u2022  '+rec, pw-5); const lineH = lines.length*4.5+2; if (y+lineH > 270) { doc.addPage(); y = m; } doc.text(lines, m+2, y); y += lineH; }
          doc.setFillColor(27,58,92); doc.rect(0, 282, 210, 15, 'F');
          doc.setFontSize(7); doc.setTextColor(180,200,220); doc.text('NeoGTB \u2014 neogtb.fr \u2014 Conseil indépendant en GTB', 105, 289, {align:'center'});
          doc.save('diagnostic-gtb-neogtb.pdf');
          this.emailSent = true; setTimeout(() => { this.showEmailModal = false; this.emailSent = false; }, 1500);
        } catch(err) { console.error('Erreur PDF:', err); alert('Erreur lors de la g\u00e9n\u00e9ration du PDF.'); }
      },

      resetDiag() {
        this.step = 1; this.currentQuestion = 0; this.animatedScore = 0;
        this.form = { buildingType: '', surface: null, surfaceChauffage: null, buildingAge: '', climateZone: '', hasEcs: null, surfaceEcs: null, hasClim: null, surfaceClim: null, hasEclairage: null, eclairage: '', surfaceEclairage: null, hasAuxiliaires: null, surfaceAuxiliaires: null, gtbAnswers: {} };
        this.results = { score: 0, levelKey: 'd', levelLabel: '', levelDescription: '', savingsEuro: 0, savingsPercent: 0, totalConso: 0, totalFacture: 0, energySummary: [], benchmark: { kwhM2: 0, position: 50, refGood: 0, refAvg: 0, refBad: 0, goodPercent: 33, avgPercent: 34, badPercent: 33 }, regulatory: { show: false, severity: 'ok', title: '', text: '', daysLeft: 0 }, cee: { gwh: 0, valueLow: 0, valueHigh: 0, eligible: false, fiches: [] }, recommendations: [] };
        this.errors = {}; this.scrollToWizard();
      },
    }));
  });
</script>
@endpush
