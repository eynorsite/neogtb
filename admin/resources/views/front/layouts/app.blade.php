<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'NeoGTB - Tout savoir sur la Gestion Technique du Bâtiment (GTB) et la Gestion Technique Centralisée (GTC)')">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <title>@yield('title', 'NeoGTB — Gestion Technique du Bâtiment')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a',950:'#172554'},
                        accent: {50:'#f0fdf4',100:'#dcfce7',200:'#bbf7d0',300:'#86efac',400:'#4ade80',500:'#22c55e',600:'#16a34a',700:'#15803d',800:'#166534',900:'#14532d'},
                        dark: {50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a',950:'#020617'},
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        /* NeoGTB Design System */
        @keyframes fade-in-up { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.3); } 50% { box-shadow: 0 0 20px 6px rgba(37, 99, 235, 0.15); } }
        .animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1); }
        .card-hover-glow { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover-glow:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -12px rgba(37, 99, 235, 0.15); border-color: #93c5fd; }
        .btn-glow { transition: all 0.3s ease; }
        .btn-glow:hover { transform: translateY(-2px); box-shadow: 0 8px 24px -4px rgba(37, 99, 235, 0.4); }
        .btn-glow:active { transform: translateY(0); }
        .text-gradient { background: linear-gradient(135deg, #3b82f6, #22c55e); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .section-divider { position: relative; }
        .section-divider::before { content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 3px; background: linear-gradient(90deg, #3b82f6, #22c55e); border-radius: 2px; }
        .bg-grid-pattern { background-image: radial-gradient(circle, #e2e8f0 1px, transparent 1px); background-size: 24px 24px; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.2); }
        [x-cloak] { display: none !important; }
    </style>
    @stack('head')
</head>
<body class="min-h-screen bg-white text-dark-900 font-sans antialiased">

    {{-- HEADER (identical to Astro) --}}
    <header class="fixed top-0 w-full bg-white/90 backdrop-blur-md border-b border-dark-100 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <span class="text-2xl font-heading font-extrabold text-primary-600">Neo<span class="text-accent-500">GTB</span></span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="/" class="text-sm font-medium text-dark-600 hover:text-primary-600 transition-colors">Accueil</a>
                <a href="/gtb" class="text-sm font-medium text-dark-600 hover:text-primary-600 transition-colors">GTB</a>
                <a href="/gtc" class="text-sm font-medium text-dark-600 hover:text-primary-600 transition-colors">GTC</a>
                <a href="/solutions" class="text-sm font-medium text-dark-600 hover:text-primary-600 transition-colors">Solutions</a>
                <a href="/comparateur" class="text-sm font-medium text-dark-600 hover:text-primary-600 transition-colors">Comparateur</a>
                <a href="/blog" class="text-sm font-medium text-dark-600 hover:text-primary-600 transition-colors">Blog</a>
                <a href="/audit" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">Diagnostic gratuit</a>
                <a href="/contact" class="text-sm font-medium text-dark-600 hover:text-primary-600 transition-colors">Contact</a>
            </div>

            <div class="md:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="p-2 text-dark-600">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <div x-show="open" x-transition class="absolute top-16 left-0 w-full bg-white border-b border-dark-100 shadow-lg">
                    <div class="flex flex-col p-4 gap-3">
                        <a href="/" class="text-sm font-medium text-dark-600 hover:text-primary-600 py-2">Accueil</a>
                        <a href="/gtb" class="text-sm font-medium text-dark-600 hover:text-primary-600 py-2">GTB</a>
                        <a href="/gtc" class="text-sm font-medium text-dark-600 hover:text-primary-600 py-2">GTC</a>
                        <a href="/solutions" class="text-sm font-medium text-dark-600 hover:text-primary-600 py-2">Solutions</a>
                        <a href="/comparateur" class="text-sm font-medium text-dark-600 hover:text-primary-600 py-2">Comparateur</a>
                        <a href="/blog" class="text-sm font-medium text-dark-600 hover:text-primary-600 py-2">Blog</a>
                        <a href="/audit" class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white text-sm font-semibold rounded-lg">Diagnostic gratuit</a>
                        <a href="/contact" class="text-sm font-medium text-dark-600 hover:text-primary-600 py-2">Contact</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="pt-16">
        @yield('content')
    </main>

    {{-- FOOTER (identical to Astro) --}}
    <footer class="bg-dark-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <span class="text-2xl font-heading font-extrabold">Neo<span class="text-accent-400">GTB</span></span>
                    <p class="mt-3 text-dark-400 text-sm max-w-md">Le tiers de confiance indépendant de la GTB en France. Indépendant de toute marque, nous vous aidons à comprendre, comparer et décider en toute objectivité.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-sm uppercase tracking-wider text-dark-400 mb-4">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="/gtb" class="text-sm text-dark-300 hover:text-white transition-colors">Qu'est-ce que la GTB ?</a></li>
                        <li><a href="/gtc" class="text-sm text-dark-300 hover:text-white transition-colors">Qu'est-ce que la GTC ?</a></li>
                        <li><a href="/solutions" class="text-sm text-dark-300 hover:text-white transition-colors">Solutions</a></li>
                        <li><a href="/comparateur" class="text-sm text-dark-300 hover:text-white transition-colors">Comparateur marques</a></li>
                        <li><a href="/blog" class="text-sm text-dark-300 hover:text-white transition-colors">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-sm uppercase tracking-wider text-dark-400 mb-4">Contact & Légal</h4>
                    <ul class="space-y-2">
                        <li><a href="/audit" class="text-sm text-dark-300 hover:text-white transition-colors">Diagnostic gratuit</a></li>
                        <li><a href="/contact" class="text-sm text-dark-300 hover:text-white transition-colors">Nous contacter</a></li>
                        <li><a href="/mentions-legales" class="text-sm text-dark-300 hover:text-white transition-colors">Mentions légales</a></li>
                        <li><a href="/politique-de-confidentialite" class="text-sm text-dark-300 hover:text-white transition-colors">Politique de confidentialité</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-dark-700 mt-8 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-dark-500">&copy; {{ date('Y') }} NeoGTB. Tous droits réservés.</p>
                <div class="flex items-center gap-4 text-xs text-dark-500">
                    <a href="/mentions-legales" class="hover:text-dark-300 transition-colors">Mentions légales</a>
                    <span>|</span>
                    <a href="/politique-de-confidentialite" class="hover:text-dark-300 transition-colors">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>
