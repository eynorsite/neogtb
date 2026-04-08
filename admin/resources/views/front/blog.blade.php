@extends('front.layouts.app')
@section('title', 'Perspectives — Analyses & veille technique GTB | NeoGTB')
@section('description', 'Analyses, veille technique et guides pratiques sur la Gestion Technique du Bâtiment (GTB) : décret BACS, protocoles, tendances smart building.')

@section('content')

{{-- ══════════════════════════════════════════════════════════════
     HERO
     ══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden pt-24 pb-20" style="background: #edf5f7;">
    <img src="/images/hero-blog.png" alt="Veille technique GTB — bâtiment intelligent" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center;" loading="eager" fetchpriority="high" />
    <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(237,245,247,0.3) 0%, rgba(237,245,247,0.92) 100%);"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block text-xs font-semibold tracking-widest uppercase text-accent-600 mb-4">Perspectives</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-heading font-extrabold text-dark-900 tracking-tight leading-tight">
            Analyses & veille <span class="text-accent-600">technique</span>
        </h1>
        <p class="mt-5 text-base sm:text-lg text-dark-500 max-w-2xl mx-auto leading-relaxed">
            Décryptages, retours terrain et points de vue sur la GTB, la GTC et le bâtiment intelligent.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     FILTER + GRID
     ══════════════════════════════════════════════════════════════ --}}
<section class="py-16 lg:py-24 bg-dark-50" x-data="{ active: 'all' }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Search bar --}}
        <div x-data="{ q: '' }" class="mb-6 flex justify-center">
            <input
                type="search"
                x-model="q"
                @input.debounce.200ms="document.querySelectorAll('[data-post-card]').forEach(el => {
                    const txt = el.dataset.searchText || '';
                    el.style.display = txt.includes(q.toLowerCase()) ? '' : 'none';
                })"
                placeholder="Rechercher un article..."
                class="w-full max-w-md px-4 py-3 rounded-xl border border-dark-200 focus:border-accent-500 focus:ring-2 focus:ring-accent-100 outline-none transition"
            />
        </div>

        {{-- Category filter pills --}}
        <div class="flex flex-wrap gap-2 mb-12 justify-center">
            <button
                class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 cursor-pointer"
                :class="active === 'all'
                    ? 'bg-primary-600 text-white shadow-md shadow-primary-600/25'
                    : 'bg-white text-dark-600 hover:bg-dark-100 border border-dark-200'"
                @click="active = 'all'"
            >
                Tous les articles
            </button>
            @foreach($categories as $cat)
                <button
                    class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 cursor-pointer"
                    :class="active === '{{ $cat->slug }}'
                        ? 'bg-primary-600 text-white shadow-md shadow-primary-600/25'
                        : 'bg-white text-dark-600 hover:bg-dark-100 border border-dark-200'"
                    @click="active = '{{ $cat->slug }}'"
                >
                    {{ $cat->name }}
                    <span class="ml-1 text-xs opacity-60">({{ $cat->posts_count }})</span>
                </button>
            @endforeach
        </div>

        {{-- Articles grid --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($posts as $post)
                <a href="/blog/{{ $post->slug }}"
                   class="group card-hover block bg-white rounded-2xl overflow-hidden border border-dark-100"
                   data-post-card
                   data-search-text="{{ \Illuminate\Support\Str::lower($post->title.' '.($post->excerpt ?? '').' '.($post->tags ? $post->tags->pluck('name')->implode(' ') : '')) }}"
                   x-show="active === 'all' || active === '{{ $post->category?->slug }}'"
                   x-transition:enter="transition ease-out duration-200"
                   x-transition:enter-start="opacity-0 scale-95"
                   x-transition:enter-end="opacity-100 scale-100"
                >
                    {{-- Image --}}
                    @php
                        $img = $post->featured_image ?? null;
                        if ($img && str_starts_with($img, '/')) {
                            $imgUrl = $img;
                        } elseif ($img) {
                            $imgUrl = asset('storage/' . $img);
                        } else {
                            $imgUrl = null;
                        }
                    @endphp
                    @if($imgUrl)
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $imgUrl }}"
                                 alt="{{ $post->title }}"
                                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 loading="lazy"
                                 onerror="this.src='/images/blog/default-cover.webp'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                    @else
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-primary-50 via-primary-100 to-accent-50">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-12 h-12 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                            </div>
                            <div class="absolute inset-0" style="background-image: radial-gradient(circle, rgba(27,58,92,0.04) 1px, transparent 1px); background-size: 16px 16px;"></div>
                        </div>
                    @endif

                    {{-- Content --}}
                    <div class="p-6">
                        {{-- Category + Reading time --}}
                        <div class="flex items-center justify-between mb-3">
                            @if($post->category)
                                <span class="inline-block px-2.5 py-1 rounded text-[11px] font-semibold uppercase tracking-wide
                                    @if($post->category->color)
                                        text-white
                                    @else
                                        text-accent-700 bg-accent-50
                                    @endif
                                "
                                @if($post->category->color)
                                    style="background-color: {{ $post->category->color }}"
                                @endif
                                >
                                    {{ $post->category->name }}
                                </span>
                            @endif
                            @if($post->reading_time)
                                <span class="text-xs text-dark-400 font-normal">{{ $post->reading_time }} min</span>
                            @endif
                        </div>

                        {{-- Title --}}
                        <h2 class="text-base font-heading font-bold text-dark-900 leading-snug mb-2 group-hover:text-primary-600 transition-colors duration-200 line-clamp-2" style="letter-spacing: -0.2px;">
                            {{ $post->title }}
                        </h2>

                        {{-- Excerpt --}}
                        <p class="text-sm text-dark-500 leading-relaxed line-clamp-2 mb-4">
                            {{ $post->excerpt }}
                        </p>

                        {{-- Tags --}}
                        @if($post->tags && $post->tags->count())
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($post->tags->take(3) as $tag)
                                    <span class="text-xs px-2 py-1 rounded-full bg-accent-50 text-accent-700">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Footer: date + arrow --}}
                        <div class="flex items-center justify-between pt-3 border-t border-dark-100">
                            <time class="text-xs text-dark-400" datetime="{{ $post->published_at?->toDateString() }}">
                                {{ $post->published_at?->translatedFormat('d F Y') }}
                            </time>
                            <span class="text-primary-500 transition-transform duration-200 group-hover:translate-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Empty state --}}
        <div class="text-center py-20" x-show="false" x-ref="empty">
            <svg class="w-12 h-12 text-dark-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
            <p class="text-dark-400 text-sm">Aucun article dans cette catégorie.</p>
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div class="mt-16 flex justify-center">
                <nav class="flex items-center gap-1" aria-label="Pagination">
                    {{-- Previous --}}
                    @if($posts->onFirstPage())
                        <span class="px-3 py-2 rounded-lg text-sm text-dark-300 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </span>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}" class="px-3 py-2 rounded-lg text-sm text-dark-600 hover:bg-white hover:shadow-sm transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                    @endif

                    {{-- Pages --}}
                    @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if($page == $posts->currentPage())
                            <span class="px-4 py-2 rounded-lg text-sm font-semibold bg-primary-600 text-white shadow-md shadow-primary-600/25">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 rounded-lg text-sm font-medium text-dark-600 hover:bg-white hover:shadow-sm transition-all">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}" class="px-3 py-2 rounded-lg text-sm text-dark-600 hover:bg-white hover:shadow-sm transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span class="px-3 py-2 rounded-lg text-sm text-dark-300 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    @endif
                </nav>
            </div>
        @endif

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     CTA BOTTOM
     ══════════════════════════════════════════════════════════════ --}}
<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl font-heading font-extrabold text-dark-900 tracking-tight">
            Un projet GTB à clarifier ?
        </h2>
        <p class="mt-4 text-base text-dark-500 leading-relaxed max-w-xl mx-auto">
            Pré-diagnostic ISO 52120-1 gratuit en ligne, ou échange de 15 minutes pour cadrer votre besoin.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/audit" class="inline-flex items-center gap-2 px-6 py-3 bg-accent-500 text-white font-semibold rounded-xl hover:bg-accent-600 transition-colors btn-glow">
                Lancer le diagnostic
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            <a href="/contact" class="text-sm font-medium text-dark-500 hover:text-primary-600 transition-colors">
                Me contacter &rarr;
            </a>
        </div>
    </div>
</section>

@endsection
