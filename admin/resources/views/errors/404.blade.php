@extends('front.layouts.app')

@section('title', 'Page introuvable — Erreur 404')
@section('description', "La page que vous cherchez n'existe pas ou a été déplacée. Retrouvez nos ressources GTB : audit, blog, guides et contact.")
@section('noindex', true)

@section('content')

<section class="relative overflow-hidden bg-white">
    {{-- Background décoratif --}}
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute -top-32 -left-32 w-[520px] h-[520px] rounded-full bg-accent-50 blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 -right-24 w-[480px] h-[480px] rounded-full bg-dark-50 blur-3xl opacity-70"></div>
        <div class="absolute inset-0 opacity-[0.035]"
             style="background-image: radial-gradient(circle at 1px 1px, #0f172a 1px, transparent 0); background-size: 28px 28px;"></div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-6 md:px-10 py-20 md:py-28">

        {{-- Eyebrow --}}
        <div class="flex justify-center">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-dark-50 border border-dark-100 text-[12px] font-medium text-dark-500 tracking-wide uppercase">
                <span class="w-1.5 h-1.5 rounded-full bg-accent-500"></span>
                Erreur 404
            </span>
        </div>

        {{-- Grand 404 stylisé --}}
        <div class="relative mt-10 flex justify-center">
            <h1 class="select-none font-display font-bold text-center leading-none tracking-tight text-[140px] sm:text-[200px] md:text-[260px] lg:text-[300px]"
                style="background: linear-gradient(135deg, #0f172a 0%, #334155 45%, #14b8a6 100%); -webkit-background-clip: text; background-clip: text; color: transparent;">
                404
            </h1>
            {{-- Petits traits type "signal" en fond du 4 --}}
            <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-[0.08]" viewBox="0 0 600 300" fill="none" aria-hidden="true">
                <path d="M20 220 Q 150 60, 300 220 T 580 220" stroke="#0f172a" stroke-width="2" stroke-dasharray="4 6"/>
                <circle cx="120" cy="160" r="3" fill="#14b8a6"/>
                <circle cx="300" cy="220" r="3" fill="#14b8a6"/>
                <circle cx="480" cy="160" r="3" fill="#14b8a6"/>
            </svg>
        </div>

        {{-- Titre + texte --}}
        <div class="mt-4 md:mt-2 text-center max-w-2xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-semibold text-dark-900 tracking-tight">
                Page introuvable
            </h2>
            <p class="mt-4 text-[16px] md:text-[17px] leading-relaxed text-dark-500">
                La page que vous cherchez n'existe pas ou a été déplacée.
                Pas d'inquiétude — voici quelques points de repère pour retrouver votre chemin.
            </p>
        </div>

        {{-- Champ recherche --}}
        <form action="{{ route('front.blog') }}" method="GET"
              class="mt-10 max-w-xl mx-auto">
            <label for="q" class="sr-only">Rechercher</label>
            <div class="relative flex items-center rounded-xl border border-dark-100 bg-white shadow-sm hover:border-dark-200 focus-within:border-accent-500 focus-within:ring-2 focus-within:ring-accent-100 transition">
                <svg class="absolute left-4 w-5 h-5 text-dark-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                </svg>
                <input type="search" name="q" id="q"
                       placeholder="Rechercher un article, un protocole, un guide…"
                       class="w-full pl-12 pr-32 py-4 bg-transparent text-[15px] text-dark-900 placeholder-dark-300 focus:outline-none rounded-xl"/>
                <button type="submit"
                        class="absolute right-2 inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg bg-dark-900 text-white text-[13px] font-medium hover:bg-dark-800 transition-colors">
                    Rechercher
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </button>
            </div>
        </form>

        {{-- Suggestions : cartes liens --}}
        <div class="mt-14">
            <p class="text-center text-[12px] font-semibold uppercase tracking-wider text-dark-400">
                Suggestions
            </p>
            <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Accueil --}}
                <a href="{{ route('front.home') }}"
                   class="group relative block p-6 rounded-2xl bg-white border border-dark-100 hover:border-accent-400 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-dark-50 border border-dark-100 group-hover:bg-accent-50 group-hover:border-accent-200 transition-colors">
                        <svg class="w-5 h-5 text-dark-500 group-hover:text-accent-600 transition-colors" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l9-9 9 9M4.5 10.5V20a1 1 0 001 1h4v-6h5v6h4a1 1 0 001-1v-9.5"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-[15px] font-semibold text-dark-900">Accueil</h3>
                    <p class="mt-1 text-[13px] text-dark-400 leading-relaxed">Retour à la page principale</p>
                    <span class="mt-3 inline-flex items-center gap-1 text-[12px] font-medium text-accent-600 opacity-0 group-hover:opacity-100 transition-opacity">
                        Y aller
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </a>

                {{-- Audit GTB --}}
                <a href="{{ route('front.audit') }}"
                   class="group relative block p-6 rounded-2xl bg-white border border-dark-100 hover:border-accent-400 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-dark-50 border border-dark-100 group-hover:bg-accent-50 group-hover:border-accent-200 transition-colors">
                        <svg class="w-5 h-5 text-dark-500 group-hover:text-accent-600 transition-colors" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-[15px] font-semibold text-dark-900">Audit GTB</h3>
                    <p class="mt-1 text-[13px] text-dark-400 leading-relaxed">Évaluez votre installation</p>
                    <span class="mt-3 inline-flex items-center gap-1 text-[12px] font-medium text-accent-600 opacity-0 group-hover:opacity-100 transition-opacity">
                        Démarrer
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </a>

                {{-- Blog --}}
                <a href="{{ route('front.blog') }}"
                   class="group relative block p-6 rounded-2xl bg-white border border-dark-100 hover:border-accent-400 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-dark-50 border border-dark-100 group-hover:bg-accent-50 group-hover:border-accent-200 transition-colors">
                        <svg class="w-5 h-5 text-dark-500 group-hover:text-accent-600 transition-colors" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-[15px] font-semibold text-dark-900">Blog</h3>
                    <p class="mt-1 text-[13px] text-dark-400 leading-relaxed">Guides, protocoles, analyses</p>
                    <span class="mt-3 inline-flex items-center gap-1 text-[12px] font-medium text-accent-600 opacity-0 group-hover:opacity-100 transition-opacity">
                        Explorer
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </a>

                {{-- Contact --}}
                <a href="{{ route('front.contact') }}"
                   class="group relative block p-6 rounded-2xl bg-white border border-dark-100 hover:border-accent-400 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-dark-50 border border-dark-100 group-hover:bg-accent-50 group-hover:border-accent-200 transition-colors">
                        <svg class="w-5 h-5 text-dark-500 group-hover:text-accent-600 transition-colors" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-[15px] font-semibold text-dark-900">Contact</h3>
                    <p class="mt-1 text-[13px] text-dark-400 leading-relaxed">Posez-nous votre question</p>
                    <span class="mt-3 inline-flex items-center gap-1 text-[12px] font-medium text-accent-600 opacity-0 group-hover:opacity-100 transition-opacity">
                        Écrire
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </a>

            </div>
        </div>

        {{-- Retour --}}
        <div class="mt-14 flex justify-center">
            <a href="javascript:history.back()"
               class="inline-flex items-center gap-2 text-[13px] font-medium text-dark-500 hover:text-dark-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Revenir à la page précédente
            </a>
        </div>
    </div>
</section>

@endsection
