"use client"

import { ArrowRight, Phone, Mail, Calendar, Sparkles } from "lucide-react"
import { FloatingParticles } from "@/components/visuals/floating-particles"

export function CTASection() {
  return (
    <section className="relative py-24 lg:py-32 overflow-hidden">
      {/* Background gradient */}
      <div className="absolute inset-0 bg-gradient-to-br from-accent-600 via-accent-500 to-accent-400" />
      
      {/* Animated particles */}
      <FloatingParticles count={25} />

      {/* Pattern overlay */}
      <div 
        className="absolute inset-0 opacity-10"
        style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`
        }}
      />

      {/* Decorative circles */}
      <div className="absolute -top-20 -right-20 w-80 h-80 bg-white/10 rounded-full blur-3xl" />
      <div className="absolute -bottom-20 -left-20 w-60 h-60 bg-white/10 rounded-full blur-3xl" />

      <div className="relative z-10 max-w-[1200px] mx-auto px-6 md:px-10 text-center">
        {/* Badge */}
        <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm mb-8">
          <Sparkles className="w-4 h-4 text-white" />
          <span className="text-sm font-semibold text-white">Diagnostic offert</span>
        </div>

        {/* Headline */}
        <h2 className="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-tight text-white mb-6">
          Prêt à optimiser votre
          <br />
          <span className="relative inline-block mt-2">
            performance énergétique ?
            <svg className="absolute -bottom-2 left-0 w-full h-3" viewBox="0 0 300 12" fill="none" preserveAspectRatio="none">
              <path d="M2 10C50 4 150 2 200 6C250 10 280 4 298 8" stroke="white" strokeOpacity="0.3" strokeWidth="4" strokeLinecap="round"/>
            </svg>
          </span>
        </h2>

        <p className="text-lg lg:text-xl text-white/80 max-w-2xl mx-auto mb-12">
          Bénéficiez d&apos;un pré-diagnostic gratuit de votre système GTB par nos experts indépendants. Sans engagement, sans lien commercial.
        </p>

        {/* CTA Buttons */}
        <div className="flex flex-wrap items-center justify-center gap-4 mb-16">
          <a
            href="/contact"
            className="group inline-flex items-center gap-3 px-8 py-4 bg-white text-accent-600 font-bold rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300"
          >
            Demander mon diagnostic
            <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
          </a>
          <a
            href="tel:+33123456789"
            className="group inline-flex items-center gap-3 px-8 py-4 bg-white/10 border border-white/20 text-white font-semibold rounded-2xl backdrop-blur-sm hover:bg-white/20 hover:-translate-y-1 transition-all duration-300"
          >
            <Phone className="w-5 h-5" />
            01 23 45 67 89
          </a>
        </div>

        {/* Contact options */}
        <div className="flex flex-wrap items-center justify-center gap-8 lg:gap-12 text-white/70">
          <div className="flex items-center gap-3">
            <div className="flex items-center justify-center w-10 h-10 rounded-xl bg-white/10">
              <Mail className="w-5 h-5" />
            </div>
            <span className="text-sm">contact@neogtb.fr</span>
          </div>
          <div className="flex items-center gap-3">
            <div className="flex items-center justify-center w-10 h-10 rounded-xl bg-white/10">
              <Calendar className="w-5 h-5" />
            </div>
            <span className="text-sm">Réponse sous 24h</span>
          </div>
          <div className="flex items-center gap-3">
            <div className="flex items-center justify-center w-10 h-10 rounded-xl bg-white/10">
              <Sparkles className="w-5 h-5" />
            </div>
            <span className="text-sm">100% gratuit</span>
          </div>
        </div>
      </div>
    </section>
  )
}
