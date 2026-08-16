@extends('front.layouts.app')

@push('head')
{{-- Schema.org Article JSON-LD (construit en PHP pour des champs conditionnels valides) --}}
@php
    $articleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $post->title,
        'description' => $post->excerpt ?? $post->meta_description,
        'datePublished' => $post->published_at?->toIso8601String(),
        'dateModified' => $post->updated_at?->toIso8601String(),
        'inLanguage' => 'fr-FR',
        'author' => [
            '@type' => 'Person',
            'name' => $post->author?->name ?? 'Ulrich Calmo',
            'url' => url('/about'),
        ],
        // @id identique au nœud Organization émis par SiteConfigService : l'éditeur de
        // l'article et l'entreprise du site sont ainsi la même entité, et non deux
        // organisations homonymes vues séparément par les moteurs. L'ancre se construit
        // sur config('app.url') — et non url('/') — pour rester strictement identique
        // même si la requête arrive par un autre host (proxy, prévisualisation, http).
        // name/logo sont conservés : Google exige ces champs sur le publisher d'un Article.
        'publisher' => [
            '@id' => rtrim(config('app.url'), '/') . '/#organization',
            '@type' => 'Organization',
            'name' => $settings->company_name ?? 'NeoGTB',
            'url' => rtrim(config('app.url'), '/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => url('/images/logo-neogtb.webp'),
            ],
        ],
        'mainEntityOfPage' => route('front.article', $post->slug),
        'image' => $post->featured_image ? asset('storage/' . $post->featured_image) : url('/images/og-neogtb.png'),
    ];

    if (filled($post->category?->name)) {
        $articleSchema['articleSection'] = $post->category->name;
    }
    if ($post->tags?->isNotEmpty()) {
        $articleSchema['keywords'] = $post->tags->pluck('name')->implode(', ');
    }
    // str_word_count() ne connaît que [A-Za-z'-] : chaque mot accentué est scindé en
    // deux (« réglementation » → « r » + « glementation »), ce qui gonflait le wordCount
    // déclaré d'environ 28 % sur du texte français. \p{L} compte les vrais mots UTF-8.
    $__wordCount = preg_match_all('/[\p{L}\p{N}]+/u', strip_tags($post->content ?? ''));
    if ($__wordCount > 0) {
        $articleSchema['wordCount'] = $__wordCount;
    }
@endphp
<script type="application/ld+json" @cspNonce>
{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
</script>
@endpush

@section('content')

@php
    $cta = \App\Helpers\BlogCta::for(
        $post->tags?->pluck('name')->all() ?? [],
        $post->category?->name
    );
@endphp

<article>
    {{-- ══════════════════════════════════════════════════════════════
         ARTICLE HEADER
         ══════════════════════════════════════════════════════════════ --}}
    <div class="pt-8 pb-0">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumbs --}}
            <nav class="flex items-center gap-2 text-sm mb-8" aria-label="Fil d'Ariane">
                <a href="/" class="text-dark-500 hover:text-accent-500 transition-colors font-normal">{{ $site->label('nav.home', 'Accueil') }}</a>
                <span class="w-1 h-1 rounded-full bg-dark-300 flex-shrink-0"></span>
                <a href="/blog" class="text-dark-500 hover:text-accent-500 transition-colors font-normal">
                    {{ $site->label('nav.blog', 'Perspectives') }}
                </a>
                <span class="w-1 h-1 rounded-full bg-dark-300 flex-shrink-0"></span>
                @if($post->category)
                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold uppercase tracking-wide
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
            </nav>

            {{-- Hero image : featured_image (Post) sinon fallback general_settings.blog_default_cover --}}
            @php
                $defaultCover = $site->blogDefaultCover();
                $imgUrl = $site->resolveImagePath($post->featured_image) ?: $defaultCover;
            @endphp
            <div class="relative aspect-[16/9] w-full overflow-hidden rounded-2xl mb-12 bg-white">
                <img src="{{ $imgUrl }}" alt="{{ $post->title }}" class="w-full h-full object-contain" loading="eager" fetchpriority="high" data-img-fallback="{{ $defaultCover }}">
            </div>

            {{-- Title --}}
            <h1 class="text-2xl sm:text-3xl md:text-[2rem] lg:text-[2.25rem] font-heading font-extrabold text-dark-900 leading-tight tracking-tight" style="letter-spacing: -0.5px;">
                {{ $post->title }}
            </h1>

            {{-- Byline --}}
            <div class="flex items-center flex-wrap gap-x-3 gap-y-1 mt-5 text-sm text-dark-500">
                <span class="font-medium text-dark-700">{{ $post->author?->name ?? 'NeoGTB' }}</span>
                <span class="text-dark-300">&middot;</span>
                <time datetime="{{ $post->published_at?->toDateString() }}">
                    {{ $post->published_at?->translatedFormat('d F Y') }}
                </time>
                <span class="text-dark-300">&middot;</span>
                <span>{{ $post->reading_time ?? ceil(str_word_count(strip_tags($post->content ?? '')) / 200) }} {{ $site->label('misc.reading_time', 'min de lecture') }}</span>
                <span class="text-dark-300">&middot;</span>
                <span>{{ number_format($post->views_count) }} {{ $site->label('misc.views', 'vues') }}</span>
            </div>

            {{-- Separator --}}
            <hr class="mt-6 mb-0 border-t border-dark-100">
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ARTICLE BODY
         ══════════════════════════════════════════════════════════════ --}}
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12">

        {{-- Lead / Excerpt --}}
        @if($post->excerpt)
            <p class="text-lg font-medium leading-relaxed text-dark-500 mb-8" style="font-style: normal;">
                {{ $post->excerpt }}
            </p>
        @endif

        {{-- Prose content --}}
        <div class="prose prose-lg max-w-none
            prose-headings:font-heading prose-headings:font-bold prose-headings:text-dark-900 prose-headings:tracking-tight
            prose-h2:text-xl prose-h2:sm:text-2xl prose-h2:md:text-[1.625rem] prose-h2:mt-12 prose-h2:mb-4 prose-h2:leading-tight
            prose-h3:text-lg prose-h3:md:text-xl prose-h3:mt-8 prose-h3:mb-3
            prose-p:text-dark-600 prose-p:leading-relaxed
            prose-a:text-accent-600 prose-a:underline prose-a:underline-offset-2 prose-a:decoration-accent-300 hover:prose-a:decoration-accent-600
            prose-strong:text-dark-800 prose-strong:font-semibold
            prose-ul:text-dark-600 prose-ol:text-dark-600
            prose-li:mb-1
            prose-blockquote:border-l-2 prose-blockquote:border-accent-500 prose-blockquote:bg-transparent prose-blockquote:text-dark-500 prose-blockquote:italic prose-blockquote:pl-6
            prose-code:text-sm prose-code:bg-dark-100 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:border prose-code:border-dark-200
            prose-pre:bg-dark-50 prose-pre:border prose-pre:border-dark-200 prose-pre:rounded-xl
            prose-img:rounded-xl prose-img:border prose-img:border-dark-100
            prose-table:text-sm
            prose-th:text-left prose-th:font-semibold prose-th:text-dark-800
            prose-td:border-b prose-td:border-dark-100
        ">
            {!! clean_html_fast($post->content ?? '') !!}
        </div>

        {{-- Tags --}}
        @if($post->tags->isNotEmpty())
            <div class="flex flex-wrap gap-2 mt-12 pt-6 border-t border-dark-100">
                @foreach($post->tags as $tag)
                    <span class="inline-block px-3 py-1 text-xs font-medium text-dark-500 bg-dark-50 border border-dark-200 rounded-full">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif

        @include('front.bricks.cta-mini.cta-side-callout', ['href' => '/audit', 'eyebrow' => 'Pour aller plus loin', 'text' => 'Évaluez votre bâtiment sur ces critères avec notre pré-diagnostic gratuit ISO 52120-1.', 'linkText' => 'Lancer le pré-diagnostic', 'icon' => 'arrow'])

        {{-- Share / Copy link --}}
        <div class="mt-8 flex items-center gap-4" x-data="copyLink">
            <span class="text-sm text-dark-500">{{ $site->label('misc.share', 'Partager') }} :</span>
            <button
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-dark-600 bg-dark-50 border border-dark-200 rounded-lg hover:bg-dark-100 transition-colors cursor-pointer"
                @click="copy()"
            >
                <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                <svg x-show="copied" x-cloak class="w-4 h-4 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span x-text="copied ? '{{ $site->label('misc.link_copied', 'Lien copié !') }}' : '{{ $site->label('misc.copy_link', 'Copier le lien') }}'"></span>
            </button>
        </div>

        {{-- Back link --}}
        <hr class="my-8 border-t border-dark-100">
        <a href="/blog" class="inline-flex items-center gap-2 text-sm text-dark-500 hover:text-accent-500 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            {{ $site->label('cta.back_to_blog', 'Retour aux Perspectives') }}
        </a>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         RELATED ARTICLES
         ══════════════════════════════════════════════════════════════ --}}
    @if($related->isNotEmpty())
        <section class="border-t border-dark-100 bg-dark-50 py-12 lg:py-20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <span class="text-xs font-semibold tracking-widest uppercase text-dark-500">{{ $site->label('blog.also_read', 'À lire aussi') }}</span>
                    <h2 class="mt-2 text-xl sm:text-2xl font-heading font-extrabold text-dark-900">{{ $site->label('blog.related_articles', 'Articles similaires') }}</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($related as $rel)
                        <a href="/blog/{{ $rel->slug }}" class="group card-hover block bg-white rounded-2xl p-6 border border-dark-100">
                            @if($rel->category)
                                <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold uppercase tracking-wide text-accent-700 bg-accent-50 mb-3">
                                    {{ $rel->category->name }}
                                </span>
                            @endif
                            <h3 class="font-heading font-bold text-dark-900 group-hover:text-primary-600 transition-colors leading-snug mb-2 line-clamp-2">
                                {{ $rel->title }}
                            </h3>
                            <p class="text-sm text-dark-500 line-clamp-2 leading-relaxed mb-3">
                                {{ $rel->excerpt }}
                            </p>
                            <div class="flex items-center justify-between text-xs text-dark-500">
                                <time datetime="{{ $rel->published_at?->toDateString() }}">
                                    {{ $rel->published_at?->translatedFormat('d F Y') }}
                                </time>
                                <span class="text-primary-500 group-hover:translate-x-1 transition-transform">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         CTA
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-12 lg:py-20 bg-white border-t border-dark-100">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-xl sm:text-2xl font-heading font-extrabold text-dark-900 tracking-tight leading-tight">
                {{ $cta['title'] }}
            </h2>
            <p class="mt-3 text-sm sm:text-base text-dark-500 leading-relaxed">
                {{ $cta['description'] }}
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ $cta['link'] }}" class="inline-flex items-center gap-2 px-6 py-3 bg-accent-500 text-white font-semibold rounded-xl hover:bg-accent-600 transition-colors btn-glow">
                    {{ $cta['linkText'] }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="/contact" class="text-sm font-medium text-dark-500 hover:text-primary-600 transition-colors">
                    {{ $site->label('cta.contact_me', 'Me contacter') }} &rarr;
                </a>
            </div>
        </div>
    </section>
</article>

@endsection
