"use client"

import Link from "next/link"

const features = [
  {
    icon: (
      <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
        <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
      </svg>
    ),
    title: "Pré-diagnostic GTB",
    description: "Auto-évaluation ISO 52120-1 en 7 minutes. Identifiez votre niveau actuel et les axes d'amélioration prioritaires.",
    href: "/audit",
    badge: "Gratuit",
  },
  {
    icon: (
      <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
        <path strokeLinecap="round" strokeLinejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
      </svg>
    ),
    title: "Comparateur objectif",
    description: "Plus de 10 fabricants analysés sans biais commercial. Trouvez la solution GTB adaptée à votre bâtiment.",
    href: "/comparateur",
    badge: "Indépendant",
  },
  {
    icon: (
      <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
        <path strokeLinecap="round" strokeLinejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z" />
      </svg>
    ),
    title: "Conformité réglementaire",
    description: "Décret BACS 2027, Décret Tertiaire, RE2020. Restez conforme avec notre veille et nos outils.",
    href: "/reglementation",
    badge: "BACS 2027",
  },
  {
    icon: (
      <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
        <path strokeLinecap="round" strokeLinejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
      </svg>
    ),
    title: "Générateur CEE",
    description: "Estimez votre prime CEE BAT-TH-116 en 3 minutes. Maximisez vos aides financières.",
    href: "/generateur-cee",
    badge: "Estimation",
  },
]

export function Features() {
  return (
    <section className="py-24 lg:py-32 relative overflow-hidden">
      {/* Background */}
      <div className="absolute inset-0 bg-[hsl(var(--background-secondary))]" />
      <div className="absolute inset-0 dot-pattern opacity-50" />
      
      <div className="relative z-10 container-premium">
        {/* Section header */}
        <div className="max-w-3xl mx-auto text-center mb-16">
          <span className="badge-premium mb-6">Nos outils</span>
          <h2 className="font-display text-3xl sm:text-4xl lg:text-5xl text-[hsl(var(--foreground))] tracking-tight text-balance">
            Des outils concrets pour votre{" "}
            <span className="text-gradient">conformité GTB</span>
          </h2>
          <p className="mt-6 text-lg text-[hsl(var(--foreground-muted))] leading-relaxed">
            Indépendance totale, expertise technique, accompagnement personnalisé. 
            Tout ce dont vous avez besoin pour réussir votre projet GTB.
          </p>
        </div>
        
        {/* Cards grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {features.map((feature, index) => (
            <Link
              key={feature.title}
              href={feature.href}
              className="card-elevated p-8 group"
              style={{ animationDelay: `${index * 100}ms` }}
            >
              <div className="flex items-start justify-between mb-6">
                <div className="w-14 h-14 rounded-2xl bg-gradient-to-br from-[hsl(var(--accent)/0.1)] to-[hsl(var(--primary)/0.1)] flex items-center justify-center text-[hsl(var(--accent))] group-hover:scale-110 transition-transform duration-300">
                  {feature.icon}
                </div>
                <span className="badge-outline text-[10px]">{feature.badge}</span>
              </div>
              
              <h3 className="text-xl font-heading text-[hsl(var(--foreground))] group-hover:text-[hsl(var(--accent))] transition-colors">
                {feature.title}
              </h3>
              
              <p className="mt-3 text-[hsl(var(--foreground-muted))] leading-relaxed">
                {feature.description}
              </p>
              
              <div className="mt-6 flex items-center gap-2 text-sm font-semibold text-[hsl(var(--accent))]">
                En savoir plus
                <svg 
                  className="w-4 h-4 transition-transform group-hover:translate-x-1" 
                  fill="none" 
                  viewBox="0 0 24 24" 
                  stroke="currentColor" 
                  strokeWidth={2}
                >
                  <path strokeLinecap="round" strokeLinejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  )
}
