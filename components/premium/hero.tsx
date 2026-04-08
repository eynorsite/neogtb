"use client"

import Link from "next/link"

export function Hero() {
  return (
    <section className="relative min-h-[90vh] flex items-center overflow-hidden">
      {/* Background */}
      <div className="absolute inset-0 hero-gradient-dark" />
      
      {/* Subtle grid pattern */}
      <div className="absolute inset-0 grid-pattern opacity-[0.02]" />
      
      {/* Gradient orbs */}
      <div className="absolute top-1/4 left-1/4 w-[600px] h-[600px] bg-[hsl(var(--accent)/0.08)] rounded-full blur-[120px] animate-float" />
      <div className="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-[hsl(var(--primary)/0.1)] rounded-full blur-[100px] animate-float delay-200" />
      
      {/* Content */}
      <div className="relative z-10 container-premium py-32">
        <div className="max-w-4xl">
          {/* Badge */}
          <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[hsl(var(--accent)/0.1)] border border-[hsl(var(--accent)/0.2)] text-[hsl(var(--accent))] text-sm font-medium mb-8 animate-fade-up">
            <span className="w-2 h-2 rounded-full bg-[hsl(var(--accent))] animate-pulse" />
            Tiers de confiance indépendant
          </div>
          
          {/* Headline */}
          <h1 className="font-display text-5xl sm:text-6xl lg:text-7xl text-white leading-[1.1] tracking-tight animate-fade-up delay-100">
            Le conseil{" "}
            <span className="text-gradient-accent">GTB</span>
            <br />
            sans conflit d&apos;intérêt
          </h1>
          
          {/* Subheadline */}
          <p className="mt-8 text-lg sm:text-xl text-[hsl(210_20%_70%)] max-w-2xl leading-relaxed animate-fade-up delay-200">
            Accompagnement décret BACS, pré-diagnostic ISO 52120-1 gratuit, 
            comparateur indépendant. Aucun lien commercial avec les fabricants.
          </p>
          
          {/* CTAs */}
          <div className="mt-10 flex flex-wrap gap-4 animate-fade-up delay-300">
            <Link href="/audit" className="btn-premium btn-primary-premium text-base px-8 py-4">
              Pré-diagnostic gratuit
              <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
              </svg>
            </Link>
            <Link 
              href="/comparateur" 
              className="btn-premium bg-white/10 text-white border border-white/20 backdrop-blur-sm hover:bg-white/20 text-base px-8 py-4"
            >
              Comparateur objectif
            </Link>
          </div>
          
          {/* Trust indicators */}
          <div className="mt-16 flex flex-wrap items-center gap-6 animate-fade-up delay-400">
            <div className="flex items-center gap-2">
              <div className="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                <svg className="w-5 h-5 text-[hsl(var(--accent))]" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
              </div>
              <span className="text-sm text-[hsl(210_20%_60%)]">100% indépendant</span>
            </div>
            <div className="w-px h-8 bg-white/10 hidden sm:block" />
            <div className="flex items-center gap-2">
              <div className="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                <svg className="w-5 h-5 text-[hsl(var(--accent))]" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <span className="text-sm text-[hsl(210_20%_60%)]">Pré-diagnostic en 7 min</span>
            </div>
            <div className="w-px h-8 bg-white/10 hidden sm:block" />
            <div className="flex items-center gap-2">
              <div className="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                <svg className="w-5 h-5 text-[hsl(var(--accent))]" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                </svg>
              </div>
              <span className="text-sm text-[hsl(210_20%_60%)]">10+ fabricants comparés</span>
            </div>
          </div>
        </div>
      </div>
      
      {/* Bottom fade */}
      <div className="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-[hsl(var(--background))] to-transparent" />
    </section>
  )
}
