"use client"

const testimonials = [
  {
    quote: "NeoGTB nous a permis de comprendre nos besoins réels en GTB sans pression commerciale. Un vrai partenaire de confiance.",
    author: "Marie Dupont",
    role: "Directrice Technique",
    company: "Groupe Immobilier Tertiaire",
    rating: 5,
  },
  {
    quote: "Le pré-diagnostic en 7 minutes nous a fait gagner un temps précieux. Résultat clair et actionnable immédiatement.",
    author: "Thomas Bernard",
    role: "Responsable Énergie",
    company: "CHU Bordeaux",
    rating: 5,
  },
  {
    quote: "Enfin un comparateur objectif ! On a pu choisir notre solution GTB en toute connaissance de cause.",
    author: "Sophie Martin",
    role: "Property Manager",
    company: "Foncière Durable",
    rating: 5,
  },
]

export function Testimonials() {
  return (
    <section className="py-24 lg:py-32 relative overflow-hidden">
      {/* Background */}
      <div className="absolute inset-0 bg-[hsl(var(--background-secondary))]" />
      <div className="absolute inset-0 dot-pattern opacity-50" />
      
      <div className="relative z-10 container-premium">
        {/* Section header */}
        <div className="max-w-3xl mx-auto text-center mb-16">
          <span className="badge-premium mb-6">Témoignages</span>
          <h2 className="font-display text-3xl sm:text-4xl lg:text-5xl text-[hsl(var(--foreground))] tracking-tight text-balance">
            Ils nous font confiance
          </h2>
          <p className="mt-6 text-lg text-[hsl(var(--foreground-muted))]">
            Découvrez les retours de nos clients sur leur expérience avec NeoGTB.
          </p>
        </div>
        
        {/* Testimonials grid */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {testimonials.map((testimonial, index) => (
            <div
              key={testimonial.author}
              className="card-premium p-8 relative animate-fade-up"
              style={{ animationDelay: `${index * 100}ms` }}
            >
              {/* Quote icon */}
              <div className="absolute -top-4 left-8">
                <div className="w-8 h-8 rounded-full bg-gradient-to-br from-[hsl(var(--accent))] to-[hsl(var(--primary))] flex items-center justify-center shadow-lg">
                  <svg className="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/>
                  </svg>
                </div>
              </div>
              
              {/* Rating */}
              <div className="flex gap-1 mb-4 mt-2">
                {[...Array(5)].map((_, i) => (
                  <svg 
                    key={i}
                    className={`w-5 h-5 ${i < testimonial.rating ? 'text-amber-400' : 'text-[hsl(var(--border))]'}`}
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                  </svg>
                ))}
              </div>
              
              {/* Quote */}
              <blockquote className="text-[hsl(var(--foreground))] leading-relaxed mb-6">
                &ldquo;{testimonial.quote}&rdquo;
              </blockquote>
              
              {/* Author */}
              <div className="flex items-center gap-3 pt-6 border-t border-[hsl(var(--border))]">
                <div className="w-10 h-10 rounded-full bg-gradient-to-br from-[hsl(var(--accent))] to-[hsl(var(--primary))] flex items-center justify-center text-white text-sm font-bold">
                  {testimonial.author.split(' ').map(n => n[0]).join('')}
                </div>
                <div>
                  <div className="font-semibold text-sm text-[hsl(var(--foreground))]">
                    {testimonial.author}
                  </div>
                  <div className="text-xs text-[hsl(var(--foreground-muted))]">
                    {testimonial.role} · {testimonial.company}
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
