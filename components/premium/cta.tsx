"use client"

import Link from "next/link"

export function CTA() {
  return (
    <section className="py-24 lg:py-32 relative overflow-hidden">
      {/* Dark gradient background */}
      <div className="absolute inset-0 hero-gradient-dark" />
      
      {/* Animated orbs */}
      <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-[hsl(var(--accent)/0.1)] rounded-full blur-[100px] animate-float" />
      <div className="absolute bottom-1/4 right-1/4 w-80 h-80 bg-[hsl(var(--primary)/0.15)] rounded-full blur-[80px] animate-float delay-200" />
      
      {/* Content */}
      <div className="relative z-10 container-premium">
        <div className="max-w-3xl mx-auto text-center">
          <h2 className="font-display text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight text-balance">
            Prêt à optimiser votre{" "}
            <span className="text-gradient-accent">gestion technique</span> ?
          </h2>
          
          <p className="mt-6 text-lg text-[hsl(210_20%_70%)] leading-relaxed max-w-2xl mx-auto">
            Commencez par un pré-diagnostic gratuit de 7 minutes pour évaluer 
            votre conformité ISO 52120-1 et identifier vos priorités.
          </p>
          
          {/* CTAs */}
          <div className="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            <Link 
              href="/audit" 
              className="btn-premium btn-primary-premium text-base px-8 py-4 w-full sm:w-auto justify-center"
            >
              Lancer le pré-diagnostic
              <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
              </svg>
            </Link>
            <Link 
              href="/contact" 
              className="btn-premium bg-white/10 text-white border border-white/20 backdrop-blur-sm hover:bg-white/20 text-base px-8 py-4 w-full sm:w-auto justify-center"
            >
              Parler à un expert
            </Link>
          </div>
          
          {/* Trust badges */}
          <div className="mt-12 flex flex-wrap items-center justify-center gap-4">
            <span className="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-medium text-white/70">
              ISO 52120-1
            </span>
            <span className="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-medium text-white/70">
              Décret BACS
            </span>
            <span className="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-medium text-white/70">
              RE2020
            </span>
            <span className="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-medium text-white/70">
              CEE BAT-TH-116
            </span>
          </div>
        </div>
      </div>
    </section>
  )
}
