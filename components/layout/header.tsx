"use client"

import { useState, useEffect } from "react"
import { Menu, X, ChevronDown, ArrowRight } from "lucide-react"

const navigation = [
  { 
    name: "Expertises", 
    href: "#",
    children: [
      { name: "Audit GTB", href: "/audit" },
      { name: "Assistance MOA", href: "/moa" },
      { name: "Conseil stratégique", href: "/conseil" },
      { name: "Formation", href: "/formation" },
    ]
  },
  { name: "Solutions", href: "/solutions" },
  { name: "Ressources", href: "/blog" },
  { name: "À propos", href: "/a-propos" },
]

export function Header() {
  const [isScrolled, setIsScrolled] = useState(false)
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false)
  const [openDropdown, setOpenDropdown] = useState<string | null>(null)

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 20)
    }

    window.addEventListener("scroll", handleScroll)
    return () => window.removeEventListener("scroll", handleScroll)
  }, [])

  return (
    <header 
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        isScrolled 
          ? "bg-white/90 backdrop-blur-xl shadow-sm border-b border-dark-100" 
          : "bg-transparent"
      }`}
    >
      <div className="max-w-[1400px] mx-auto px-6 md:px-10">
        <div className="flex items-center justify-between h-20">
          {/* Logo */}
          <a href="/" className="relative z-10 flex items-center gap-3">
            <div className="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-accent-500 to-accent-600 shadow-lg shadow-accent-500/25">
              <span className="text-white font-bold text-lg">N</span>
            </div>
            <span className={`text-xl font-bold tracking-tight ${isScrolled ? "text-dark-900" : "text-dark-900"}`}>
              Neo<span className="text-accent-600">GTB</span>
            </span>
          </a>

          {/* Desktop Navigation */}
          <nav className="hidden lg:flex items-center gap-1">
            {navigation.map((item) => (
              <div 
                key={item.name}
                className="relative"
                onMouseEnter={() => item.children && setOpenDropdown(item.name)}
                onMouseLeave={() => setOpenDropdown(null)}
              >
                <a 
                  href={item.href}
                  className={`flex items-center gap-1 px-4 py-2 text-sm font-medium rounded-lg transition-colors ${
                    isScrolled 
                      ? "text-dark-600 hover:text-dark-900 hover:bg-dark-50" 
                      : "text-dark-600 hover:text-dark-900 hover:bg-dark-100/50"
                  }`}
                >
                  {item.name}
                  {item.children && <ChevronDown className="w-4 h-4" />}
                </a>

                {/* Dropdown */}
                {item.children && openDropdown === item.name && (
                  <div className="absolute top-full left-0 pt-2">
                    <div className="bg-white rounded-2xl shadow-xl border border-dark-100 p-2 min-w-[200px]">
                      {item.children.map((child) => (
                        <a
                          key={child.name}
                          href={child.href}
                          className="block px-4 py-2.5 text-sm text-dark-600 hover:text-dark-900 hover:bg-dark-50 rounded-lg transition-colors"
                        >
                          {child.name}
                        </a>
                      ))}
                    </div>
                  </div>
                )}
              </div>
            ))}
          </nav>

          {/* CTA + Mobile menu button */}
          <div className="flex items-center gap-4">
            <a
              href="/contact"
              className="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-accent-600 to-accent-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-accent-500/25 hover:shadow-xl hover:shadow-accent-500/30 hover:-translate-y-0.5 transition-all duration-300"
            >
              Contact
              <ArrowRight className="w-4 h-4" />
            </a>

            <button
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
              className="lg:hidden p-2 rounded-lg hover:bg-dark-100 transition-colors"
              aria-label="Toggle menu"
            >
              {isMobileMenuOpen ? (
                <X className="w-6 h-6 text-dark-700" />
              ) : (
                <Menu className="w-6 h-6 text-dark-700" />
              )}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile menu */}
      {isMobileMenuOpen && (
        <div className="lg:hidden fixed inset-0 top-20 bg-white z-40">
          <nav className="p-6 space-y-2">
            {navigation.map((item) => (
              <div key={item.name}>
                <a 
                  href={item.href}
                  className="block px-4 py-3 text-lg font-medium text-dark-900 hover:bg-dark-50 rounded-xl transition-colors"
                >
                  {item.name}
                </a>
                {item.children && (
                  <div className="ml-4 mt-1 space-y-1">
                    {item.children.map((child) => (
                      <a
                        key={child.name}
                        href={child.href}
                        className="block px-4 py-2 text-dark-500 hover:text-dark-900 transition-colors"
                      >
                        {child.name}
                      </a>
                    ))}
                  </div>
                )}
              </div>
            ))}
            <div className="pt-4">
              <a
                href="/contact"
                className="flex items-center justify-center gap-2 w-full px-6 py-4 bg-gradient-to-r from-accent-600 to-accent-500 text-white font-semibold rounded-xl"
              >
                Demander un diagnostic
                <ArrowRight className="w-5 h-5" />
              </a>
            </div>
          </nav>
        </div>
      )}
    </header>
  )
}
