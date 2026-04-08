"use client"

import { useState } from "react"
import { 
  BarChart3, 
  Shield, 
  Lightbulb, 
  Settings, 
  TrendingUp, 
  FileCheck,
  ArrowRight,
  Check
} from "lucide-react"
import { TiltCard } from "@/components/visuals/tilt-card"
import { AnimatedGrid } from "@/components/visuals/animated-grid"

const services = [
  {
    icon: BarChart3,
    title: "Audit GTB",
    description: "Analyse complète de votre système GTB existant avec recommandations d'optimisation personnalisées.",
    features: ["Diagnostic EN 15232", "Analyse des données", "Plan d'action"],
    color: "#10b981",
    gradient: "from-accent-500 to-accent-600",
  },
  {
    icon: Shield,
    title: "Assistance MOA",
    description: "Accompagnement maîtrise d'ouvrage pour vos projets GTB de A à Z.",
    features: ["Rédaction CCTP", "Analyse des offres", "Suivi travaux"],
    color: "#102A43",
    gradient: "from-primary-500 to-primary-600",
  },
  {
    icon: Lightbulb,
    title: "Conseil Stratégique",
    description: "Définition de votre stratégie GTB alignée avec vos objectifs de performance énergétique.",
    features: ["Schéma directeur", "Roadmap projet", "Business case"],
    color: "#eab308",
    gradient: "from-gold-500 to-gold-600",
  },
  {
    icon: Settings,
    title: "Optimisation",
    description: "Amélioration continue de vos systèmes GTB pour maximiser les économies d'énergie.",
    features: ["Paramétrage fin", "Scénarios CVC", "Suivi temps réel"],
    color: "#10b981",
    gradient: "from-accent-500 to-accent-600",
  },
  {
    icon: TrendingUp,
    title: "Formation",
    description: "Montée en compétence de vos équipes sur les technologies GTB.",
    features: ["Sessions pratiques", "Documentation", "Support continu"],
    color: "#102A43",
    gradient: "from-primary-500 to-primary-600",
  },
  {
    icon: FileCheck,
    title: "Conformité BACS",
    description: "Mise en conformité avec le décret BACS et accompagnement réglementaire.",
    features: ["Diagnostic initial", "Plan de mise à niveau", "Certification"],
    color: "#eab308",
    gradient: "from-gold-500 to-gold-600",
  },
]

export function FeaturesSection() {
  const [hoveredIndex, setHoveredIndex] = useState<number | null>(null)

  return (
    <section className="relative py-24 lg:py-32 bg-dark-900 overflow-hidden">
      {/* Animated background */}
      <AnimatedGrid />

      {/* Gradient overlays */}
      <div className="absolute top-0 left-0 w-1/2 h-full bg-gradient-to-r from-accent-500/5 to-transparent pointer-events-none" />
      <div className="absolute bottom-0 right-0 w-1/3 h-1/2 bg-gradient-to-tl from-primary-500/10 to-transparent pointer-events-none" />

      <div className="relative z-10 max-w-[1400px] mx-auto px-6 md:px-10">
        {/* Section header */}
        <div className="text-center mb-16 lg:mb-20">
          <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-6">
            <span className="w-1.5 h-1.5 rounded-full bg-accent-400 animate-pulse" />
            <span className="text-xs font-bold tracking-wider text-white/70 uppercase">Nos expertises</span>
          </div>
          <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-white">
            Une expertise <span className="text-gradient">complète</span>
          </h2>
          <p className="mt-4 text-lg text-white/50 max-w-2xl mx-auto">
            De l&apos;audit initial à l&apos;optimisation continue, nous vous accompagnons à chaque étape de votre projet GTB.
          </p>
        </div>

        {/* Services grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
          {services.map((service, index) => {
            const Icon = service.icon
            const isHovered = hoveredIndex === index

            return (
              <TiltCard key={index} className="rounded-3xl h-full" glareEnabled={false}>
                <div 
                  className="group relative h-full p-8 bg-white/[0.03] backdrop-blur-sm rounded-3xl border border-white/[0.06] hover:bg-white/[0.06] hover:border-white/[0.12] transition-all duration-500"
                  onMouseEnter={() => setHoveredIndex(index)}
                  onMouseLeave={() => setHoveredIndex(null)}
                >
                  {/* Icon */}
                  <div 
                    className={`inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br ${service.gradient} shadow-lg mb-6 group-hover:scale-110 transition-transform duration-300`}
                  >
                    <Icon className="w-7 h-7 text-white" />
                  </div>

                  {/* Content */}
                  <h3 className="text-xl font-bold text-white mb-3">{service.title}</h3>
                  <p className="text-white/50 mb-6 leading-relaxed">{service.description}</p>

                  {/* Features list */}
                  <ul className="space-y-2 mb-6">
                    {service.features.map((feature, i) => (
                      <li key={i} className="flex items-center gap-2 text-sm text-white/60">
                        <Check className="w-4 h-4 text-accent-400" />
                        {feature}
                      </li>
                    ))}
                  </ul>

                  {/* CTA */}
                  <a 
                    href="#" 
                    className="inline-flex items-center gap-2 text-sm font-semibold text-accent-400 hover:text-accent-300 transition-colors group/link"
                  >
                    En savoir plus
                    <ArrowRight className="w-4 h-4 group-hover/link:translate-x-1 transition-transform" />
                  </a>

                  {/* Hover glow effect */}
                  <div 
                    className="absolute inset-0 rounded-3xl pointer-events-none transition-opacity duration-500"
                    style={{ 
                      opacity: isHovered ? 0.1 : 0,
                      background: `radial-gradient(circle at 50% 0%, ${service.color}, transparent 70%)`
                    }}
                  />
                </div>
              </TiltCard>
            )
          })}
        </div>
      </div>
    </section>
  )
}
