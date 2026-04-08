"use client"

import { ArrowRight, Play, Shield, Zap, Building2 } from "lucide-react"
import { FloatingParticles } from "@/components/visuals/floating-particles"
import { SmartBuilding } from "@/components/visuals/smart-building"
import { MorphingShapes } from "@/components/visuals/morphing-shapes"

export function HeroSection() {
  return (
    <section className="relative min-h-[100vh] flex items-center overflow-hidden bg-[#fafafa]">
      {/* Animated background elements */}
      <MorphingShapes />
      <FloatingParticles count={35} />

      {/* Grid pattern overlay */}
      <div 
        className="absolute inset-0 opacity-[0.02]"
        style={{
          backgroundImage: `
            linear-gradient(rgba(16, 42, 67, 0.8) 1px, transparent 1px),
            linear-gradient(90deg, rgba(16, 42, 67, 0.8) 1px, transparent 1px)
          `,
          backgroundSize: "80px 80px"
        }}
      />

      <div className="relative z-10 max-w-[1400px] mx-auto px-6 md:px-10 py-20 lg:py-32">
        <div className="grid lg:grid-cols-2 gap-16 lg:gap-24 items-center">
          {/* Content */}
          <div className="space-y-8">
            {/* Premium badge */}
            <div className="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-gradient-to-r from-accent-50 to-accent-100/50 border border-accent-200/60 shadow-sm">
              <span className="relative flex h-2.5 w-2.5">
                <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent-400 opacity-75"></span>
                <span className="relative inline-flex rounded-full h-2.5 w-2.5 bg-accent-500"></span>
              </span>
              <span className="text-xs font-bold tracking-wider text-accent-700 uppercase">
                Expert Indépendant GTB
              </span>
            </div>

            {/* Main headline */}
            <h1 className="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold tracking-[-0.03em] text-dark-900 leading-[1.05]">
              <span className="block">Optimisez votre</span>
              <span className="block mt-3">
                <span className="relative inline-block">
                  <span className="relative z-10 bg-gradient-to-r from-accent-600 via-accent-500 to-accent-400 bg-clip-text text-transparent">
                    performance
                  </span>
                  <svg className="absolute -bottom-1 left-0 w-full h-4 text-accent-300/60" viewBox="0 0 200 12" fill="none" preserveAspectRatio="none">
                    <path d="M2 8C30 4 70 2 100 4C130 6 170 8 198 4" stroke="currentColor" strokeWidth="6" strokeLinecap="round">
                      <animate attributeName="d" dur="3s" repeatCount="indefinite"
                        values="M2 8C30 4 70 2 100 4C130 6 170 8 198 4;M2 4C30 8 70 6 100 8C130 4 170 2 198 6;M2 8C30 4 70 2 100 4C130 6 170 8 198 4"
                      />
                    </path>
                  </svg>
                </span>
              </span>
              <span className="block mt-3">énergétique</span>
            </h1>

            {/* Subheadline */}
            <p className="text-lg sm:text-xl text-dark-500 max-w-xl leading-relaxed">
              Conseil et expertise indépendante en Gestion Technique du Bâtiment. 
              <span className="text-dark-700 font-semibold"> Aucun lien commercial</span> avec les fabricants.
            </p>

            {/* CTA buttons */}
            <div className="flex flex-wrap items-center gap-4 pt-4">
              <a
                href="/contact"
                className="group relative inline-flex items-center gap-3 px-8 py-4 overflow-hidden bg-gradient-to-r from-accent-600 to-accent-500 text-white font-semibold rounded-2xl shadow-lg shadow-accent-500/25 hover:shadow-xl hover:shadow-accent-500/35 hover:-translate-y-1 transition-all duration-300"
              >
                <span className="absolute inset-0 bg-gradient-to-r from-accent-500 to-accent-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                <span className="relative">Diagnostic gratuit</span>
                <ArrowRight className="relative w-5 h-5 group-hover:translate-x-1 transition-transform" />
              </a>
              <button className="group inline-flex items-center gap-3 px-6 py-4 bg-white border-2 border-dark-200 text-dark-700 font-semibold rounded-2xl hover:border-accent-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div className="flex items-center justify-center w-10 h-10 rounded-full bg-dark-100 group-hover:bg-accent-100 group-hover:scale-110 transition-all duration-300">
                  <Play className="w-4 h-4 text-dark-600 group-hover:text-accent-600 transition-colors" fill="currentColor" />
                </div>
                Voir la démo
              </button>
            </div>

            {/* Trust indicators */}
            <div className="flex flex-wrap items-center gap-6 lg:gap-8 pt-8 border-t border-dark-200/60">
              <div className="group flex items-center gap-3 cursor-default">
                <div className="flex items-center justify-center w-12 h-12 rounded-2xl bg-primary-50 group-hover:bg-primary-100 group-hover:scale-105 transition-all duration-300">
                  <Shield className="w-6 h-6 text-primary-600" />
                </div>
                <div>
                  <p className="text-sm font-bold text-dark-900">100% Indépendant</p>
                  <p className="text-xs text-dark-400">Sans conflit d&apos;intérêt</p>
                </div>
              </div>
              <div className="group flex items-center gap-3 cursor-default">
                <div className="flex items-center justify-center w-12 h-12 rounded-2xl bg-accent-50 group-hover:bg-accent-100 group-hover:scale-105 transition-all duration-300">
                  <Zap className="w-6 h-6 text-accent-600" />
                </div>
                <div>
                  <p className="text-sm font-bold text-dark-900">-35% Énergie</p>
                  <p className="text-xs text-dark-400">Économies moyennes</p>
                </div>
              </div>
              <div className="group flex items-center gap-3 cursor-default">
                <div className="flex items-center justify-center w-12 h-12 rounded-2xl bg-gold-50 group-hover:bg-gold-100 group-hover:scale-105 transition-all duration-300">
                  <Building2 className="w-6 h-6 text-gold-600" />
                </div>
                <div>
                  <p className="text-sm font-bold text-dark-900">+200 Bâtiments</p>
                  <p className="text-xs text-dark-400">Accompagnés</p>
                </div>
              </div>
            </div>
          </div>

          {/* Visual - Animated Smart Building */}
          <div className="relative hidden lg:flex items-center justify-center">
            {/* Glow effect behind */}
            <div className="absolute inset-0 bg-gradient-to-br from-accent-500/20 via-transparent to-primary-500/10 rounded-[3rem] blur-3xl" />
            <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-accent-500/10 rounded-full blur-[80px] animate-pulse" style={{ animationDuration: "4s" }} />
            
            <SmartBuilding className="relative z-10 w-full max-w-md" />
          </div>
        </div>
      </div>

      {/* Scroll indicator */}
      <div className="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
        <span className="text-[10px] font-bold text-dark-400 uppercase tracking-[0.2em]">Découvrir</span>
        <div className="w-7 h-11 rounded-full border-2 border-dark-300 flex justify-center pt-2">
          <div className="w-1.5 h-3 rounded-full bg-accent-500 animate-bounce" />
        </div>
      </div>
    </section>
  )
}
