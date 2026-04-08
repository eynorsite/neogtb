"use client"

import { EnergyFlow } from "@/components/visuals/energy-flow"
import { AnimatedCounter } from "@/components/visuals/animated-counter"
import { Zap, TrendingDown, Leaf, Euro } from "lucide-react"

const benefits = [
  {
    icon: TrendingDown,
    value: 35,
    suffix: "%",
    label: "Réduction conso",
    color: "#10b981",
  },
  {
    icon: Euro,
    value: 45,
    suffix: "K€",
    label: "Économies/an",
    color: "#eab308",
  },
  {
    icon: Leaf,
    value: 120,
    suffix: "T",
    label: "CO2 évité",
    color: "#10b981",
  },
  {
    icon: Zap,
    value: 24,
    suffix: "/7",
    label: "Monitoring",
    color: "#102A43",
  },
]

export function EnergyFlowSection() {
  return (
    <section className="relative py-24 lg:py-32 bg-gradient-to-b from-white to-dark-50 overflow-hidden">
      <div className="max-w-[1400px] mx-auto px-6 md:px-10">
        {/* Section header */}
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-accent-50 border border-accent-200 mb-6">
            <Zap className="w-4 h-4 text-accent-600" />
            <span className="text-xs font-bold tracking-wider text-accent-700 uppercase">Comment ça marche</span>
          </div>
          <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-dark-900">
            Pilotage intelligent <span className="text-gradient">en temps réel</span>
          </h2>
          <p className="mt-4 text-lg text-dark-500 max-w-2xl mx-auto">
            Notre approche GTB transforme vos données en économies concrètes grâce à un pilotage optimisé de vos équipements.
          </p>
        </div>

        {/* Energy flow visualization */}
        <div className="relative bg-white rounded-3xl border border-dark-100 shadow-xl p-8 lg:p-12 mb-16">
          {/* Decorative elements */}
          <div className="absolute top-4 right-4 flex items-center gap-2 px-3 py-1.5 rounded-full bg-accent-50 border border-accent-200">
            <span className="relative flex h-2 w-2">
              <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent-400 opacity-75"></span>
              <span className="relative inline-flex rounded-full h-2 w-2 bg-accent-500"></span>
            </span>
            <span className="text-xs font-semibold text-accent-700">Live</span>
          </div>

          <EnergyFlow className="w-full max-w-4xl mx-auto" />

          {/* Legend */}
          <div className="flex flex-wrap justify-center gap-6 mt-8 pt-8 border-t border-dark-100">
            <div className="flex items-center gap-2">
              <div className="w-3 h-3 rounded-full bg-red-500" />
              <span className="text-sm text-dark-500">Avant optimisation</span>
            </div>
            <div className="flex items-center gap-2">
              <div className="w-3 h-3 rounded-full bg-accent-500" />
              <span className="text-sm text-dark-500">Après GTB NeoGTB</span>
            </div>
            <div className="flex items-center gap-2">
              <div className="w-3 h-3 rounded-full bg-gold-500" />
              <span className="text-sm text-dark-500">Économies réalisées</span>
            </div>
          </div>
        </div>

        {/* Benefits grid */}
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
          {benefits.map((benefit, index) => {
            const Icon = benefit.icon
            return (
              <div 
                key={index}
                className="group relative p-6 bg-white rounded-2xl border border-dark-100 hover:border-accent-200 hover:shadow-lg transition-all duration-300"
              >
                <div 
                  className="inline-flex items-center justify-center w-12 h-12 rounded-xl mb-4 group-hover:scale-110 transition-transform duration-300"
                  style={{ backgroundColor: `${benefit.color}15` }}
                >
                  <Icon className="w-6 h-6" style={{ color: benefit.color }} />
                </div>
                <div 
                  className="text-3xl lg:text-4xl font-bold mb-1"
                  style={{ color: benefit.color }}
                >
                  <AnimatedCounter end={benefit.value} suffix={benefit.suffix} duration={2000} />
                </div>
                <p className="text-sm text-dark-500">{benefit.label}</p>

                {/* Hover accent */}
                <div 
                  className="absolute bottom-0 left-4 right-4 h-1 rounded-t-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                  style={{ backgroundColor: benefit.color }}
                />
              </div>
            )
          })}
        </div>
      </div>
    </section>
  )
}
