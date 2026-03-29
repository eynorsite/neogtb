<x-filament-panels::page>

    {{-- HERO SECTION --}}
    <div class="neogtb-hero">
        <div class="neogtb-hero-bg"></div>
        <div class="neogtb-hero-content">
            <div class="neogtb-hero-left">
                <p class="neogtb-hero-greeting">
                    @php
                        $hour = now()->hour;
                        $greeting = $hour < 12 ? 'Bonjour' : ($hour < 18 ? 'Bon après-midi' : 'Bonsoir');
                    @endphp
                    {{ $greeting }}, <span class="neogtb-hero-name">{{ auth()->guard('admin')->user()->name }}</span>
                </p>
                <h1 class="neogtb-hero-title">Que souhaitez-vous faire ?</h1>
                <p class="neogtb-hero-subtitle">
                    {{ now()->translatedFormat('l j F Y') }}
                </p>
            </div>
            <div class="neogtb-hero-actions">
                <a href="{{ url('/') }}" target="_blank" class="neogtb-hero-btn neogtb-hero-btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" class="neogtb-hero-btn-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    Voir mon site
                </a>
            </div>
        </div>
    </div>

    {{-- RACCOURCIS RAPIDES --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <a href="{{ url('/admin/homepage') }}" class="neogtb-shortcut">
            <div class="neogtb-shortcut-icon" style="background: #EFF6FF; color: #2563EB;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
            </div>
            <div>
                <p class="neogtb-shortcut-title">Modifier la page d'accueil</p>
                <p class="neogtb-shortcut-desc">Titre, texte d'accroche, boutons, image de fond</p>
            </div>
        </a>

        <a href="{{ url('/admin/pages') }}" class="neogtb-shortcut">
            <div class="neogtb-shortcut-icon" style="background: #F0FDF4; color: #16A34A;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
            </div>
            <div>
                <p class="neogtb-shortcut-title">Modifier les pages du site</p>
                <p class="neogtb-shortcut-desc">GTB, GTC, Solutions, À propos, FAQ...</p>
            </div>
        </a>

        <a href="{{ \App\Filament\Resources\PostResource::getUrl('create') }}" class="neogtb-shortcut">
            <div class="neogtb-shortcut-icon" style="background: #FEF3C7; color: #D97706;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            </div>
            <div>
                <p class="neogtb-shortcut-title">Écrire un nouvel article</p>
                <p class="neogtb-shortcut-desc">Publier sur le blog NeoGTB</p>
            </div>
        </a>

        <a href="{{ url('/admin/navigation-menus') }}" class="neogtb-shortcut">
            <div class="neogtb-shortcut-icon" style="background: #F5F3FF; color: #7C3AED;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </div>
            <div>
                <p class="neogtb-shortcut-title">Gérer les menus</p>
                <p class="neogtb-shortcut-desc">Ajouter ou réorganiser les liens de navigation</p>
            </div>
        </a>

        <a href="{{ url('/admin/media-library') }}" class="neogtb-shortcut">
            <div class="neogtb-shortcut-icon" style="background: #FFF1F2; color: #E11D48;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v13.5a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V9.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
            </div>
            <div>
                <p class="neogtb-shortcut-title">Médiathèque</p>
                <p class="neogtb-shortcut-desc">Gérer les images et fichiers du site</p>
            </div>
        </a>

        <a href="{{ url('/admin/site-settings') }}" class="neogtb-shortcut">
            <div class="neogtb-shortcut-icon" style="background: #F1F5F9; color: #475569;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
            </div>
            <div>
                <p class="neogtb-shortcut-title">Paramètres généraux</p>
                <p class="neogtb-shortcut-desc">Coordonnées, réseaux sociaux, référencement...</p>
            </div>
        </a>
    </div>

    {{-- WIDGETS --}}
    @livewire(\App\Filament\Widgets\StatsOverview::class)

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div>
            @livewire(\App\Filament\Widgets\RecentMessages::class)
        </div>
        <div>
            @livewire(\App\Filament\Widgets\RecentActivity::class)
        </div>
    </div>

    <style>
        .neogtb-hero {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .neogtb-hero-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #1B3A5C 0%, #2D5F8A 50%, #1a6b4a 100%);
        }

        .neogtb-hero-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(45, 139, 78, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(90, 148, 196, 0.25) 0%, transparent 50%);
        }

        .neogtb-hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .neogtb-hero-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2rem 2rem;
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .neogtb-hero-content {
                flex-direction: column;
                align-items: flex-start;
                padding: 1.5rem 1.25rem;
            }
        }

        .neogtb-hero-greeting {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.35rem;
            font-weight: 400;
        }

        .neogtb-hero-name {
            color: #ffffff;
            font-weight: 600;
        }

        .neogtb-hero-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin: 0;
        }

        .neogtb-hero-subtitle {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.55);
            margin-top: 0.35rem;
            font-weight: 400;
        }

        .neogtb-hero-actions {
            display: flex;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        .neogtb-hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.1rem;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .neogtb-hero-btn-icon {
            width: 1rem;
            height: 1rem;
        }

        .neogtb-hero-btn-ghost {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .neogtb-hero-btn-ghost:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        /* RACCOURCIS */
        .neogtb-shortcut {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            background: white;
            border: 1px solid #e2e8f0;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .dark .neogtb-shortcut {
            background: rgb(17 24 39);
            border-color: rgb(55 65 81);
        }

        .neogtb-shortcut:hover {
            border-color: #93c5fd;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.08);
            transform: translateY(-1px);
        }

        .dark .neogtb-shortcut:hover {
            border-color: rgb(59 130 246);
        }

        .neogtb-shortcut-icon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .neogtb-shortcut-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.3;
            margin: 0;
        }

        .dark .neogtb-shortcut-title {
            color: #e2e8f0;
        }

        .neogtb-shortcut-desc {
            font-size: 0.75rem;
            color: #64748b;
            line-height: 1.3;
            margin: 0.15rem 0 0;
        }

        .dark .neogtb-shortcut-desc {
            color: #94a3b8;
        }
    </style>

</x-filament-panels::page>
