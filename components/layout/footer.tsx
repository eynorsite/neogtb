"use client"

import { ArrowRight, Linkedin, Mail, Phone, MapPin } from "lucide-react"

const footerLinks = {
  expertises: [
    { name: "Audit GTB", href: "/audit" },
    { name: "Assistance MOA", href: "/moa" },
    { name: "Conseil stratégique", href: "/conseil" },
    { name: "Formation", href: "/formation" },
    { name: "Conformité BACS", href: "/bacs" },
  ],
  ressources: [
    { name: "Blog", href: "/blog" },
    { name: "Guides pratiques", href: "/guides" },
    { name: "Glossaire GTB", href: "/glossaire" },
    { name: "Réglementation", href: "/reglementation" },
    { name: "FAQ", href: "/faq" },
  ],
  legal: [
    { name: "Mentions légales", href: "/mentions-legales" },
    { name: "Confidentialité", href: "/confidentialite" },
    { name: "Cookies", href: "/cookies" },
  ],
}

const certifications = ["ISO 52120-1", "Décret BACS", "RE2020", "CEE BAT-TH-116"]

export function Footer() {
  return (
    <footer className="relative bg-dark-900 overflow-hidden">
      {/* Top accent line */}
      <div className="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-accent-500 via-gold-500 to-accent-500" />

      {/* Background decoration */}
      <div className="absolute bottom-0 left-0 w-[600px] h-[600px] bg-accent-500/5 rounded-full blur-[150px]" />

      <div className="relative z-10 max-w-[1400px] mx-auto px-6 md:px-10 py-20">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8">
          {/* Brand column */}
          <div className="lg:col-span-4">
            <a href="/" className="inline-flex items-center gap-3 mb-6">
              <div className="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-accent-500 to-accent-600">
                <span className="text-white font-bold text-lg">N</span>
              </div>
              <span className="text-xl font-bold text-white tracking-tight">
                Neo<span className="text-accent-400">GTB</span>
              </span>
            </a>
            <p className="text-white/50 leading-relaxed mb-6 max-w-sm">
              Le tiers de confiance indépendant de la Gestion Technique du Bâtiment en France. Aucun lien commercial avec les fabricants.
            </p>

            {/* Newsletter */}
            <div className="mb-8">
              <p className="text-xs font-bold text-white/40 uppercase tracking-wider mb-3">
                Veille GTB mensuelle
              </p>
              <form className="flex gap-2">
                <input
                  type="email"
                  placeholder="votre@email.com"
                  className="flex-1 px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/30 text-sm focus:outline-none focus:border-accent-500/50 focus:ring-2 focus:ring-accent-500/20 transition-all"
                />
                <button
                  type="submit"
                  className="px-4 py-3 bg-accent-500 hover:bg-accent-400 text-white rounded-xl transition-colors"
                  aria-label="Subscribe"
                >
                  <ArrowRight className="w-5 h-5" />
                </button>
              </form>
            </div>

            {/* Certifications */}
            <div className="flex flex-wrap gap-2">
              {certifications.map((cert) => (
                <span
                  key={cert}
                  className="px-3 py-1.5 text-xs font-medium text-white/50 bg-white/5 border border-white/10 rounded-full"
                >
                  {cert}
                </span>
              ))}
            </div>
          </div>

          {/* Links columns */}
          <div className="lg:col-span-2 lg:col-start-6">
            <h3 className="text-xs font-bold text-white/40 uppercase tracking-wider mb-4">
              Expertises
            </h3>
            <ul className="space-y-3">
              {footerLinks.expertises.map((link) => (
                <li key={link.name}>
                  <a
                    href={link.href}
                    className="text-white/60 hover:text-accent-400 transition-colors"
                  >
                    {link.name}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          <div className="lg:col-span-2">
            <h3 className="text-xs font-bold text-white/40 uppercase tracking-wider mb-4">
              Ressources
            </h3>
            <ul className="space-y-3">
              {footerLinks.ressources.map((link) => (
                <li key={link.name}>
                  <a
                    href={link.href}
                    className="text-white/60 hover:text-accent-400 transition-colors"
                  >
                    {link.name}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          <div className="lg:col-span-3">
            <h3 className="text-xs font-bold text-white/40 uppercase tracking-wider mb-4">
              Contact
            </h3>
            <ul className="space-y-4">
              <li>
                <a
                  href="mailto:contact@neogtb.fr"
                  className="flex items-center gap-3 text-white/60 hover:text-accent-400 transition-colors"
                >
                  <Mail className="w-5 h-5" />
                  contact@neogtb.fr
                </a>
              </li>
              <li>
                <a
                  href="tel:+33123456789"
                  className="flex items-center gap-3 text-white/60 hover:text-accent-400 transition-colors"
                >
                  <Phone className="w-5 h-5" />
                  01 23 45 67 89
                </a>
              </li>
              <li className="flex items-start gap-3 text-white/60">
                <MapPin className="w-5 h-5 flex-shrink-0 mt-0.5" />
                <span>Paris, France</span>
              </li>
            </ul>

            {/* Social */}
            <div className="mt-6">
              <a
                href="https://linkedin.com"
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center justify-center w-10 h-10 bg-white/5 hover:bg-accent-500/20 border border-white/10 hover:border-accent-500/30 rounded-xl text-white/60 hover:text-accent-400 transition-all"
                aria-label="LinkedIn"
              >
                <Linkedin className="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>

        {/* Bottom bar */}
        <div className="mt-16 pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
          <p className="text-sm text-white/40">
            &copy; {new Date().getFullYear()} NeoGTB. Tous droits réservés.
          </p>
          <div className="flex items-center gap-6">
            {footerLinks.legal.map((link) => (
              <a
                key={link.name}
                href={link.href}
                className="text-sm text-white/40 hover:text-white/60 transition-colors"
              >
                {link.name}
              </a>
            ))}
          </div>
        </div>
      </div>
    </footer>
  )
}
