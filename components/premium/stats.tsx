"use client"

const stats = [
  {
    value: "100%",
    label: "Indépendant",
    description: "Aucun lien commercial avec les fabricants GTB",
  },
  {
    value: "10+",
    label: "Fabricants",
    description: "Comparés objectivement dans notre analyse",
  },
  {
    value: "7 min",
    label: "Pré-diagnostic",
    description: "Pour évaluer votre conformité ISO 52120-1",
  },
  {
    value: "2027",
    label: "Échéance BACS",
    description: "Préparez-vous dès maintenant",
  },
]

export function Stats() {
  return (
    <section className="py-20 lg:py-24 relative overflow-hidden">
      {/* Background accent line */}
      <div className="absolute left-0 right-0 top-1/2 h-px bg-gradient-to-r from-transparent via-[hsl(var(--border))] to-transparent" />
      
      <div className="container-premium relative">
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
          {stats.map((stat, index) => (
            <div 
              key={stat.label}
              className="text-center group animate-fade-up"
              style={{ animationDelay: `${index * 100}ms` }}
            >
              <div className="relative inline-block">
                <span className="font-display text-4xl sm:text-5xl lg:text-6xl text-gradient tracking-tight">
                  {stat.value}
                </span>
                <div className="absolute -inset-4 bg-[hsl(var(--accent)/0.05)] rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity" />
              </div>
              <h3 className="mt-3 text-sm font-semibold uppercase tracking-wider text-[hsl(var(--foreground))]">
                {stat.label}
              </h3>
              <p className="mt-2 text-sm text-[hsl(var(--foreground-muted))] leading-relaxed">
                {stat.description}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
