"use client"

import { useState, useEffect } from "react"
import Link from "next/link"
import { cn } from "@/lib/utils"

const navigation = [
  {
    label: "Explorer",
    items: [
      {
        group: "Comprendre",
        links: [
          { href: "/gtb", title: "Qu'est-ce que la GTB ?", desc: "Fondamentaux, normes EN 15232" },
          { href: "/gtc", title: "Qu'est-ce que la GTC ?", desc: "Supervision technique, différences" },
          { href: "/solutions", title: "Solutions & technologies", desc: "BACnet, KNX, Modbus, LON" },
        ],
      },
      {
        group: "Se conformer",
        links: [
          { href: "/reglementation", title: "Réglementation", desc: "Décret BACS, calendrier 2026-2035" },
          { href: "/positionnement", title: "Pourquoi NeoGTB ?", desc: "Tiers de confiance indépendant" },
        ],
      },
      {
        group: "Agir",
        links: [
          { href: "/audit", title: "Pré-diagnostic GTB", desc: "Auto-évaluation ISO 52120-1" },
          { href: "/comparateur", title: "Comparateur objectif", desc: "10+ fabricants sans biais" },
        ],
      },
    ],
  },
  { label: "Perspectives", href: "/blog" },
  { label: "À propos", href: "/about" },
  { label: "FAQ", href: "/faq" },
  { label: "Contact", href: "/contact" },
]

export function Header() {
  const [scrolled, setScrolled] = useState(false)
  const [mobileOpen, setMobileOpen] = useState(false)
  const [explorerOpen, setExplorerOpen] = useState(false)

  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 20)
    window.addEventListener("scroll", handleScroll, { passive: true })
    return () => window.removeEventListener("scroll", handleScroll)
  }, [])

  return (
    <header
      className={cn(
        "fixed top-0 left-0 right-0 z-50 transition-all duration-300",
        scrolled
          ? "bg-[hsl(var(--background)/0.8)] backdrop-blur-xl border-b border-[hsl(var(--border))]"
          : "bg-transparent"
      )}
    >
      <nav className="container-premium">
        <div className="flex items-center justify-between h-16 lg:h-20">
          {/* Logo */}
          <Link href="/" className="flex items-center gap-2 group">
            <div className="relative w-10 h-10 rounded-xl bg-gradient-to-br from-[hsl(var(--accent))] to-[hsl(var(--primary))] flex items-center justify-center shadow-lg">
              <span className="text-white font-bold text-lg">N</span>
              <div className="absolute inset-0 rounded-xl bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity" />
            </div>
            <span className="font-display text-xl tracking-tight">
              Neo<span className="text-gradient-accent">GTB</span>
            </span>
          </Link>

          {/* Desktop Navigation */}
          <div className="hidden lg:flex items-center gap-1">
            {navigation.map((item) =>
              item.href ? (
                <Link
                  key={item.label}
                  href={item.href}
                  className="px-4 py-2 text-sm font-medium text-[hsl(var(--foreground-muted))] hover:text-[hsl(var(--foreground))] hover:bg-[hsl(var(--muted))] rounded-lg transition-colors"
                >
                  {item.label}
                </Link>
              ) : (
                <div key={item.label} className="relative">
                  <button
                    onClick={() => setExplorerOpen(!explorerOpen)}
                    onMouseEnter={() => setExplorerOpen(true)}
                    className={cn(
                      "px-4 py-2 text-sm font-medium rounded-lg transition-colors flex items-center gap-1.5",
                      explorerOpen
                        ? "text-[hsl(var(--foreground))] bg-[hsl(var(--muted))]"
                        : "text-[hsl(var(--foreground-muted))] hover:text-[hsl(var(--foreground))] hover:bg-[hsl(var(--muted))]"
                    )}
                  >
                    {item.label}
                    <svg
                      className={cn("w-3.5 h-3.5 transition-transform", explorerOpen && "rotate-180")}
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      strokeWidth={2}
                    >
                      <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                  </button>

                  {/* Mega Menu */}
                  {explorerOpen && (
                    <div
                      className="absolute top-full left-1/2 -translate-x-1/2 pt-2"
                      onMouseLeave={() => setExplorerOpen(false)}
                    >
                      <div className="card-glass rounded-2xl p-6 shadow-xl min-w-[600px] animate-fade-up">
                        <div className="grid grid-cols-3 gap-6">
                          {item.items?.map((group) => (
                            <div key={group.group}>
                              <h4 className="text-[10px] font-semibold uppercase tracking-widest text-[hsl(var(--foreground-subtle))] mb-3">
                                {group.group}
                              </h4>
                              <ul className="space-y-1">
                                {group.links.map((link) => (
                                  <li key={link.href}>
                                    <Link
                                      href={link.href}
                                      className="block p-2 -mx-2 rounded-lg hover:bg-[hsl(var(--muted))] transition-colors group/link"
                                    >
                                      <span className="block text-sm font-medium text-[hsl(var(--foreground))] group-hover/link:text-[hsl(var(--accent))] transition-colors">
                                        {link.title}
                                      </span>
                                      <span className="block text-xs text-[hsl(var(--foreground-subtle))] mt-0.5">
                                        {link.desc}
                                      </span>
                                    </Link>
                                  </li>
                                ))}
                              </ul>
                            </div>
                          ))}
                        </div>
                        <div className="mt-6 pt-4 border-t border-[hsl(var(--border))] flex items-center justify-between">
                          <span className="text-xs text-[hsl(var(--foreground-subtle))]">
                            Besoin d&apos;aide pour choisir ?
                          </span>
                          <Link
                            href="/contact"
                            className="text-xs font-medium text-[hsl(var(--accent))] hover:underline flex items-center gap-1"
                          >
                            Contactez un expert
                            <svg className="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                              <path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                          </Link>
                        </div>
                      </div>
                    </div>
                  )}
                </div>
              )
            )}
          </div>

          {/* CTA & Mobile Toggle */}
          <div className="flex items-center gap-3">
            <Link
              href="/audit"
              className="hidden lg:inline-flex btn-premium btn-primary-premium"
            >
              Pré-diagnostic gratuit
              <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7" />
              </svg>
            </Link>

            <button
              onClick={() => setMobileOpen(!mobileOpen)}
              className="lg:hidden p-2 rounded-lg hover:bg-[hsl(var(--muted))] transition-colors"
              aria-label="Menu"
            >
              <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                {mobileOpen ? (
                  <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                ) : (
                  <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                )}
              </svg>
            </button>
          </div>
        </div>

        {/* Mobile Menu */}
        {mobileOpen && (
          <div className="lg:hidden py-4 border-t border-[hsl(var(--border))] animate-fade-up">
            <div className="space-y-1">
              {navigation.map((item) =>
                item.href ? (
                  <Link
                    key={item.label}
                    href={item.href}
                    className="block px-4 py-3 text-sm font-medium rounded-lg hover:bg-[hsl(var(--muted))]"
                    onClick={() => setMobileOpen(false)}
                  >
                    {item.label}
                  </Link>
                ) : (
                  <div key={item.label} className="py-2">
                    <span className="block px-4 py-2 text-xs font-semibold uppercase tracking-widest text-[hsl(var(--foreground-subtle))]">
                      {item.label}
                    </span>
                    {item.items?.map((group) => (
                      <div key={group.group} className="mt-2">
                        <span className="block px-4 py-1 text-[10px] font-medium uppercase tracking-wider text-[hsl(var(--foreground-subtle))]">
                          {group.group}
                        </span>
                        {group.links.map((link) => (
                          <Link
                            key={link.href}
                            href={link.href}
                            className="block px-4 py-2 text-sm hover:bg-[hsl(var(--muted))] rounded-lg"
                            onClick={() => setMobileOpen(false)}
                          >
                            {link.title}
                          </Link>
                        ))}
                      </div>
                    ))}
                  </div>
                )
              )}
            </div>
            <div className="mt-4 px-4">
              <Link
                href="/audit"
                className="btn-premium btn-primary-premium w-full justify-center"
                onClick={() => setMobileOpen(false)}
              >
                Pré-diagnostic gratuit
              </Link>
            </div>
          </div>
        )}
      </nav>
    </header>
  )
}
