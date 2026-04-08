"use client"

import { AnimatedCounter } from "@/components/visuals/animated-counter"
import { CircularProgress } from "@/components/visuals/circular-progress"
import { TiltCard } from "@/components/visuals/tilt-card"

const stats = [
  {
    value: 35,
    suffix: "%",
    label: "Économies d'énergie",
    description: "En moyenne sur nos projets",
    color: "#10b981",
  },
  {
    value: 200,
    suffix: "+",
    label: "Bâtiments optimisés",
    description: "En France métropolitaine",
    color: "#eab308",
  },
  {
    value: 15,
    suffix: " ans",
    label: "D'expertise terrain",
    description: "Dans le secteur GTB",
    color: "#102A43",
  },
  {
    value: 100,
    suffix: "%",
    label: "Indépendance garantie",
    description: "Zéro lien fabricant",
    color: "#10b981",
  },
]

export function StatsSection() {
  return (
    <section className="relative py-24 lg:py-32 bg-white overflow-hidden">
      {/* Background decoration */}
      <div className="absolute inset-0 bg-gradient-to-b from-dark-50/50 to-transparent" />
      <div className="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-dark-200 to-transparent" />

      <div className="relative z-10 max-w-[1400px] mx-auto px-6 md:px-10">
        {/* Section header */}
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-accent-50 border border-accent-200 mb-6">
            <span className="w-1.5 h-1.5 rounded-full bg-accent-500" />
            <span className="text-xs font-bold tracking-wider text-accent-700 uppercase">Nos résultats</span>
          </div>
          <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-dark-900">
            Des performances <span className="text-gradient">mesurables</span>
          </h2>
          <p className="mt-4 text-lg text-dark-500 max-w-2xl mx-auto">
            Chaque projet est une opportunité d&apos;optimiser votre consommation énergétique et de réduire vos coûts d&apos;exploitation.
          </p>
        </div>

        {/* Stats grid */}
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
          {stats.map((stat, index) => (
            <TiltCard key={index} className="rounded-3xl">
              <div className="relative p-8 bg-white rounded-3xl border border-dark-100 shadow-sm hover:shadow-xl hover:border-accent-200/50 transition-all duration-500 group">
                {/* Accent line */}
                <div 
                  className="absolute top-0 left-8 right-8 h-1 rounded-b-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                  style={{ background: stat.color }}
                />
                
                {/* Number with animation */}
                <div className="mb-4">
                  <span 
                    className="text-4xl lg:text-5xl font-bold tracking-tight"
                    style={{ color: stat.color }}
                  >
                    <AnimatedCounter end={stat.value} suffix={stat.suffix} duration={2500} />
                  </span>
                </div>
                
                {/* Label */}
                <h3 className="text-lg font-semibold text-dark-900 mb-1">{stat.label}</h3>
                <p className="text-sm text-dark-400">{stat.description}</p>

                {/* Hover effect */}
                <div 
                  className="absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"
                  style={{ 
                    background: `radial-gradient(circle at 50% 0%, ${stat.color}08, transparent 70%)`
                  }}
                />
              </div>
            </TiltCard>
          ))}
        </div>

        {/* Circular progress indicators */}
        <div className="mt-20 flex flex-wrap justify-center items-center gap-12 lg:gap-20">
          <CircularProgress 
            value={92} 
            label="Satisfaction" 
            sublabel="Client" 
            color="#10b981"
            size={140}
          />
          <CircularProgress 
            value={87} 
            label="ROI atteint" 
            sublabel="< 3 ans" 
            color="#eab308"
            size={140}
          />
          <CircularProgress 
            value={100} 
            label="Conformité" 
            sublabel="Décret BACS" 
            color="#102A43"
            size={140}
          />
        </div>
      </div>
    </section>
  )
}
