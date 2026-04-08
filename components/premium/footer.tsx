"use client"

import Link from "next/link"

const footerLinks = {
  navigation: [
    { label: "GTB", href: "/gtb" },
    { label: "GTC", href: "/gtc" },
    { label: "Solutions", href: "/solutions" },
    { label: "Comparateur", href: "/comparateur" },
    { label: "Réglementation", href: "/reglementation" },
    { label: "Perspectives", href: "/blog" },
  ],
  outils: [
    { label: "Pré-diagnostic GTB", href: "/audit" },
    { label: "Générateur CEE", href: "/generateur-cee" },
    { label: "Tables Modbus", href: "/tables-modbus" },
    { label: "Contact", href: "/contact" },
    { label: "FAQ", href: "/faq" },
  ],
  legal: [
    { label: "Mentions légales", href: "/mentions-legales" },
    { label: "Confidentialité", href: "/politique-de-confidentialite" },
    { label: "Cookies", href: "/cookies" },
    { label: "Vos droits RGPD", href: "/mes-droits-rgpd" },
  ],
}

export function Footer() {
  return (
    <footer className="border-t border-[hsl(var(--border))] bg-[hsl(var(--background))]">
      <div className="container-premium py-16">
        <div className="grid grid-cols-1 md:grid-cols-12 gap-10">
          {/* Brand & Newsletter */}
          <div className="md:col-span-5">
            <Link href="/" className="flex items-center gap-2 group">
              <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-[hsl(var(--accent))] to-[hsl(var(--primary))] flex items-center justify-center">
                <span className="text-white font-bold text-lg">N</span>
              </div>
              <span className="font-display text-xl tracking-tight">
                Neo<span className="text-gradient-accent">GTB</span>
              </span>
            </Link>
            
            <p className="mt-5 text-sm text-[hsl(var(--foreground-muted))] max-w-md leading-relaxed">
              Le tiers de confiance indépendant de la Gestion Technique du Bâtiment en France. 
              Aucun lien commercial avec les fabricants.
            </p>
            
            {/* Newsletter */}
            <div className="mt-8">
              <label className="text-xs font-semibold uppercase tracking-wider text-[hsl(var(--foreground-subtle))] mb-3 block">
                Veille GTB mensuelle
              </label>
              <form className="flex gap-2">
                <input
                  type="email"
                  placeholder="votre@email.com"
                  className="flex-1 text-sm px-4 py-2.5 rounded-lg bg-[hsl(var(--muted))] border border-[hsl(var(--border))] text-[hsl(var(--foreground))] placeholder:text-[hsl(var(--foreground-subtle))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--accent))] focus:border-transparent transition-shadow"
                />
                <button 
                  type="submit"
                  className="btn-premium btn-primary-premium text-sm px-5"
                >
                  S&apos;inscrire
                </button>
              </form>
              <p className="mt-2 text-xs text-[hsl(var(--foreground-subtle))]">
                1 email/mois. Désabonnement en 1 clic.
              </p>
            </div>
            
            {/* Badges */}
            <div className="mt-6 flex flex-wrap gap-2">
              {["ISO 52120-1", "Décret BACS", "RE2020", "CEE BAT-TH-116"].map((badge) => (
                <span 
                  key={badge}
                  className="px-3 py-1 rounded-full text-[10px] font-medium border border-[hsl(var(--border))] text-[hsl(var(--foreground-muted))]"
                >
                  {badge}
                </span>
              ))}
            </div>
          </div>
          
          {/* Navigation */}
          <div className="md:col-span-2 md:col-start-7">
            <h4 className="text-xs font-semibold uppercase tracking-wider text-[hsl(var(--foreground-subtle))] mb-4">
              Navigation
            </h4>
            <ul className="space-y-3">
              {footerLinks.navigation.map((link) => (
                <li key={link.href}>
                  <Link 
                    href={link.href}
                    className="text-sm text-[hsl(var(--foreground-muted))] hover:text-[hsl(var(--foreground))] transition-colors"
                  >
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
          
          {/* Outils */}
          <div className="md:col-span-2">
            <h4 className="text-xs font-semibold uppercase tracking-wider text-[hsl(var(--foreground-subtle))] mb-4">
              Outils
            </h4>
            <ul className="space-y-3">
              {footerLinks.outils.map((link) => (
                <li key={link.href}>
                  <Link 
                    href={link.href}
                    className="text-sm text-[hsl(var(--foreground-muted))] hover:text-[hsl(var(--foreground))] transition-colors"
                  >
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
          
          {/* Legal */}
          <div className="md:col-span-2">
            <h4 className="text-xs font-semibold uppercase tracking-wider text-[hsl(var(--foreground-subtle))] mb-4">
              Légal
            </h4>
            <ul className="space-y-3">
              {footerLinks.legal.map((link) => (
                <li key={link.href}>
                  <Link 
                    href={link.href}
                    className="text-sm text-[hsl(var(--foreground-muted))] hover:text-[hsl(var(--foreground))] transition-colors"
                  >
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
        </div>
        
        {/* Bottom bar */}
        <div className="mt-12 pt-8 border-t border-[hsl(var(--border))] flex flex-col sm:flex-row items-center justify-between gap-4">
          <p className="text-sm text-[hsl(var(--foreground-muted))]">
            &copy; {new Date().getFullYear()} NeoGTB. Tous droits réservés.
          </p>
          <div className="flex items-center gap-5">
            <a 
              href="https://www.linkedin.com/in/ulrich-calmo" 
              target="_blank" 
              rel="noopener noreferrer"
              className="text-[hsl(var(--foreground-muted))] hover:text-[hsl(var(--foreground))] transition-colors"
              aria-label="LinkedIn"
            >
              <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </footer>
  )
}
