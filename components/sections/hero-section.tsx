"use client"

import { ArrowRight } from "lucide-react"

export function HeroSection() {
  return (
    <section className="relative min-h-[90vh] flex items-center justify-center overflow-hidden bg-[#09090b]">
      {/* Premium gradient background */}
      <div className="absolute inset-0 bg-gradient-to-br from-[#09090b] via-[#102A43]/50 to-[#09090b]" />
      
      {/* Subtle noise texture */}
      <div 
        className="absolute inset-0 opacity-[0.015]" 
        style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E")`
        }} 
      />
      
      {/* Premium floating orbs */}
      <div className="absolute top-[10%] left-[5%] w-[500px] h-[500px] bg-[#10b981]/10 rounded-full blur-[120px] animate-float" />
      <div className="absolute bottom-[15%] right-[10%] w-[400px] h-[400px] bg-[#102A43]/30 rounded-full blur-[100px] animate-float" style={{ animationDelay: "-4s" }} />
      <div className="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#10b981]/5 rounded-full blur-[150px]" />
      
      {/* Grid overlay */}
      <div 
        className="absolute inset-0 opacity-[0.03]" 
        style={{
          backgroundImage: "linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px)",
          backgroundSize: "64px 64px"
        }} 
      />

      <div className="relative z-10 mx-auto max-w-5xl px-6 py-32 text-center">
        {/* Badge */}
        <div 
          className="mb-8 inline-flex items-center gap-3 rounded-full bg-white/[0.05] border border-white/[0.08] px-5 py-2.5 text-sm font-medium text-white/80 backdrop-blur-sm animate-fade-in-up"
        >
          <span className="w-2 h-2 rounded-full bg-[#34d399] animate-pulse-soft" />
          Tiers de confiance indépendant
        </div>

        {/* Title */}
        <h1 
          className="heading-premium text-5xl text-white sm:text-6xl lg:text-7xl animate-fade-in-up"
          style={{ animationDelay: "0.1s" }}
        >
          L&apos;expertise <span className="text-gradient">GTB</span> au service
          <br className="hidden sm:block" /> de votre bâtiment
        </h1>

        {/* Subtitle */}
        <p 
          className="subheading-premium mt-8 text-xl text-white/60 sm:text-2xl max-w-3xl mx-auto animate-fade-in-up"
          style={{ animationDelay: "0.2s" }}
        >
          Conseil indépendant en Gestion Technique du Bâtiment. 
          Zéro conflit d&apos;intérêt, 100% objectivité.
        </p>

        {/* CTAs */}
        <div 
          className="mt-12 flex flex-wrap gap-4 justify-center animate-fade-in-up"
          style={{ animationDelay: "0.3s" }}
        >
          <a 
            href="#" 
            className="group inline-flex items-center gap-3 rounded-2xl bg-white px-8 py-4 text-base font-semibold text-[#18181b] shadow-xl transition-all duration-300 hover:shadow-2xl hover:shadow-white/10 hover:-translate-y-1"
          >
            Pré-diagnostic gratuit
            <ArrowRight className="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" />
          </a>
          <a 
            href="#" 
            className="group inline-flex items-center gap-3 rounded-2xl border border-white/15 bg-white/5 px-8 py-4 text-base font-semibold text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:bg-white/10 hover:border-white/25 hover:-translate-y-1"
          >
            Découvrir NeoGTB
            <ArrowRight className="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" />
          </a>
        </div>
        
        {/* Scroll indicator */}
        <div 
          className="absolute bottom-12 left-1/2 -translate-x-1/2 animate-fade-in-up"
          style={{ animationDelay: "0.5s" }}
        >
          <div className="flex flex-col items-center gap-3 text-white/30">
            <span className="text-xs font-medium uppercase tracking-[0.2em]">Découvrir</span>
            <div className="w-6 h-10 rounded-full border border-white/20 flex items-start justify-center p-2">
              <div className="w-1.5 h-3 rounded-full bg-white/40 animate-bounce" />
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}
