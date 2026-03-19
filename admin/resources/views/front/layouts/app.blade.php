<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NeoGTB — Gestion Technique du Bâtiment')</title>
    <meta name="description" content="@yield('description', 'NeoGTB : experts en GTB/GTC. Guides, outils et conseils pour la gestion technique de vos bâtiments.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#e6f0f7',100:'#cce1ef',200:'#99c3df',300:'#66a5cf',400:'#3387bf',500:'#0F6BAF',600:'#0d5f9c',700:'#0a4b7d',800:'#08385e',900:'#05253f' },
                        dark: '#0F172A',
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        .hero-gradient { background: linear-gradient(135deg, #0F172A 0%, #0F6BAF 100%); }
        .section-alt { background: #F8FAFC; }
    </style>
    @stack('head')
</head>
<body class="font-sans text-gray-800 antialiased">

    {{-- HEADER --}}
    <header class="sticky top-0 z-50 border-b border-gray-100 bg-white/95 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="/" class="flex items-center gap-2">
                <span class="text-2xl font-black text-primary-600">Neo<span class="text-dark">GTB</span></span>
            </a>

            <nav class="hidden items-center gap-1 md:flex">
                @php
                    $nav = \App\Models\NavigationMenu::where('location', 'header')->where('is_active', true)->first();
                    $items = $nav ? $nav->items()->where('is_active', true)->orderBy('order')->get() : collect();
                @endphp
                @foreach($items as $item)
                    <a href="{{ $item->url }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-primary-600">
                        {{ $item->label }}
                    </a>
                @endforeach
                <a href="/audit" class="ml-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-primary-700">
                    Audit gratuit
                </a>
            </nav>

            {{-- Mobile hamburger --}}
            <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="rounded-lg p-2 text-gray-600 md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden border-t bg-white px-4 pb-4 md:hidden">
            @foreach($items ?? [] as $item)
                <a href="{{ $item->url }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-gray-600">{{ $item->label }}</a>
            @endforeach
        </div>
    </header>

    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="border-t bg-dark text-gray-400">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <div>
                    <span class="text-xl font-black text-white">Neo<span class="text-primary-400">GTB</span></span>
                    <p class="mt-3 text-sm leading-relaxed">Expert en Gestion Technique du Bâtiment. Guides, outils et conseils pour optimiser vos installations.</p>
                </div>
                <div>
                    <h4 class="mb-3 text-sm font-semibold uppercase tracking-wider text-white">Pages</h4>
                    @php
                        $footer = \App\Models\NavigationMenu::where('location', 'footer')->where('is_active', true)->first();
                        $footerItems = $footer ? $footer->items()->where('is_active', true)->orderBy('order')->get() : collect();
                    @endphp
                    @foreach($footerItems as $item)
                        <a href="{{ $item->url }}" class="block py-1 text-sm transition hover:text-white">{{ $item->label }}</a>
                    @endforeach
                </div>
                <div>
                    <h4 class="mb-3 text-sm font-semibold uppercase tracking-wider text-white">Contact</h4>
                    <p class="text-sm">{{ $settings['contact_email_principal'] ?? 'contact@neogtb.fr' }}</p>
                    @if(!empty($settings['contact_telephone_principal'] ?? ''))
                        <p class="text-sm">{{ $settings['contact_telephone_principal'] }}</p>
                    @endif
                </div>
                <div>
                    <h4 class="mb-3 text-sm font-semibold uppercase tracking-wider text-white">Suivez-nous</h4>
                    @if(!empty($settings['social_linkedin'] ?? ''))
                        <a href="{{ $settings['social_linkedin'] }}" class="block py-1 text-sm transition hover:text-white" target="_blank">LinkedIn</a>
                    @endif
                </div>
            </div>
            <div class="mt-8 border-t border-gray-800 pt-6 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} NeoGTB — Tous droits réservés
            </div>
        </div>
    </footer>

</body>
</html>
