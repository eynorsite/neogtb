"use client"

import { useState, useEffect } from "react"
import { Quote, Star, ChevronLeft, ChevronRight } from "lucide-react"

const testimonials = [
  {
    quote: "NeoGTB nous a permis d'identifier des économies de 40% sur notre consommation CVC. Leur indépendance garantit des recommandations objectives.",
    author: "Marie Dubois",
    role: "Directrice Immobilier",
    company: "Groupe Bancaire National",
    image: "/images/testimonial-1.jpg",
    rating: 5,
  },
  {
    quote: "L'accompagnement pour la mise en conformité BACS a été exemplaire. Équipe réactive et expertise technique irréprochable.",
    author: "Jean-Pierre Martin",
    role: "Responsable Technique",
    company: "Centre Commercial Métropole",
    image: "/images/testimonial-2.jpg",
    rating: 5,
  },
  {
    quote: "Grâce à leur audit GTB, nous avons optimisé le pilotage de nos 15 bâtiments tertiaires avec un ROI atteint en moins de 2 ans.",
    author: "Sophie Leroy",
    role: "Facility Manager",
    company: "Assurances Premium",
    image: "/images/testimonial-3.jpg",
    rating: 5,
  },
]

export function TestimonialsSection() {
  const [activeIndex, setActiveIndex] = useState(0)
  const [isAutoPlaying, setIsAutoPlaying] = useState(true)

  useEffect(() => {
    if (!isAutoPlaying) return

    const interval = setInterval(() => {
      setActiveIndex((prev) => (prev + 1) % testimonials.length)
    }, 6000)

    return () => clearInterval(interval)
  }, [isAutoPlaying])

  const goToPrev = () => {
    setIsAutoPlaying(false)
    setActiveIndex((prev) => (prev - 1 + testimonials.length) % testimonials.length)
  }

  const goToNext = () => {
    setIsAutoPlaying(false)
    setActiveIndex((prev) => (prev + 1) % testimonials.length)
  }

  return (
    <section className="relative py-24 lg:py-32 bg-primary-900 overflow-hidden">
      {/* Background elements */}
      <div className="absolute inset-0 bg-[url('/grid.svg')] bg-center opacity-[0.03]" />
      <div className="absolute top-0 left-1/4 w-[600px] h-[600px] bg-accent-500/10 rounded-full blur-[150px]" />
      <div className="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-gold-500/10 rounded-full blur-[120px]" />

      <div className="relative z-10 max-w-[1200px] mx-auto px-6 md:px-10">
        {/* Section header */}
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-6">
            <Quote className="w-4 h-4 text-accent-400" />
            <span className="text-xs font-bold tracking-wider text-white/70 uppercase">Témoignages</span>
          </div>
          <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-white">
            Ils nous font <span className="text-gradient">confiance</span>
          </h2>
        </div>

        {/* Testimonial carousel */}
        <div className="relative">
          {/* Main testimonial card */}
          <div className="relative bg-white/[0.03] backdrop-blur-sm rounded-3xl border border-white/[0.08] p-8 lg:p-12">
            {/* Quote icon */}
            <div className="absolute top-8 right-8 lg:top-12 lg:right-12">
              <Quote className="w-16 h-16 text-accent-500/20" />
            </div>

            {/* Rating */}
            <div className="flex gap-1 mb-6">
              {[...Array(testimonials[activeIndex].rating)].map((_, i) => (
                <Star key={i} className="w-5 h-5 text-gold-400 fill-gold-400" />
              ))}
            </div>

            {/* Quote */}
            <blockquote className="text-xl lg:text-2xl text-white font-medium leading-relaxed mb-8 max-w-3xl">
              &ldquo;{testimonials[activeIndex].quote}&rdquo;
            </blockquote>

            {/* Author info */}
            <div className="flex items-center gap-4">
              <div className="w-14 h-14 rounded-full bg-gradient-to-br from-accent-500 to-accent-600 flex items-center justify-center text-white font-bold text-lg">
                {testimonials[activeIndex].author.split(" ").map(n => n[0]).join("")}
              </div>
              <div>
                <p className="font-semibold text-white">{testimonials[activeIndex].author}</p>
                <p className="text-white/50 text-sm">{testimonials[activeIndex].role}</p>
                <p className="text-accent-400 text-sm font-medium">{testimonials[activeIndex].company}</p>
              </div>
            </div>
          </div>

          {/* Navigation */}
          <div className="flex items-center justify-center gap-4 mt-8">
            <button
              onClick={goToPrev}
              className="p-3 rounded-full bg-white/5 border border-white/10 text-white/60 hover:text-white hover:bg-white/10 transition-all duration-300"
              aria-label="Previous testimonial"
            >
              <ChevronLeft className="w-5 h-5" />
            </button>

            {/* Dots */}
            <div className="flex gap-2">
              {testimonials.map((_, index) => (
                <button
                  key={index}
                  onClick={() => {
                    setIsAutoPlaying(false)
                    setActiveIndex(index)
                  }}
                  className={`w-2.5 h-2.5 rounded-full transition-all duration-300 ${
                    index === activeIndex 
                      ? "bg-accent-500 w-8" 
                      : "bg-white/20 hover:bg-white/40"
                  }`}
                  aria-label={`Go to testimonial ${index + 1}`}
                />
              ))}
            </div>

            <button
              onClick={goToNext}
              className="p-3 rounded-full bg-white/5 border border-white/10 text-white/60 hover:text-white hover:bg-white/10 transition-all duration-300"
              aria-label="Next testimonial"
            >
              <ChevronRight className="w-5 h-5" />
            </button>
          </div>
        </div>

        {/* Logos strip */}
        <div className="mt-20 pt-12 border-t border-white/10">
          <p className="text-center text-sm text-white/40 mb-8 uppercase tracking-wider">
            Ils nous ont fait confiance
          </p>
          <div className="flex flex-wrap items-center justify-center gap-12 opacity-40">
            {["Groupe Bancaire", "Assurances Premium", "Métropole Retail", "Tech Campus", "Hôpital Central"].map((name, i) => (
              <div key={i} className="text-white font-semibold text-lg tracking-tight">
                {name}
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  )
}
