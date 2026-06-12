@extends('front.layouts.app')

@section('title', $cfg['meta_title'])
@section('description', $cfg['meta_description'])

@section('breadcrumbs')
    <li><a href="{{ url('/') }}" style="color: var(--color-dark-400); text-decoration: none;">Accueil</a></li>
    <li aria-hidden="true" style="color: var(--color-dark-300);">/</li>
    <li aria-current="page" style="color: var(--color-dark-600);">{{ $cfg['title'] }}</li>
@endsection

@push('schema')
@if(!empty($cfg['faq']))
@php
    $faqLd = [
        '@context' => 'https://schema.org',
        '@type'    => 'FAQPage',
        'mainEntity' => array_map(function ($item) {
            return [
                '@type' => 'Question',
                'name'  => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $item['answer'],
                ],
            ];
        }, $cfg['faq']),
    ];
@endphp
<script type="application/ld+json" @cspNonce>
{!! json_encode($faqLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
</script>
@endif
@endpush

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden" style="padding: 64px 0 40px; background: #edf5f7;">
    <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(237,245,247,0.3) 0%, rgba(237,245,247,0.92) 100%);"></div>
    <div class="max-w-7xl mx-auto px-5 lg:px-10 relative z-10">
        <div class="max-w-3xl">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">{{ $cfg['eyebrow'] }}</p>
            <h1 class="font-heading text-[30px] lg:text-[44px] font-medium text-dark-900 leading-tight tracking-tight mb-5">
                {{ $cfg['title'] }}
            </h1>
            {{-- Réponse atomique mise en avant --}}
            <p class="text-[17px] lg:text-[19px] text-dark-700 leading-relaxed border-l-4 border-accent-500 pl-5">
                {{ $cfg['lede'] }}
            </p>
        </div>
    </div>
</section>

<!-- BANDEAU DES 2 COLONNES -->
<section class="py-8 lg:py-12 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 lg:gap-5">
            <div class="bg-dark-50 rounded-2xl p-5 lg:p-7 border border-dark-100 text-center">
                <span class="inline-block text-[13px] font-medium text-white bg-dark-600 px-3 py-1 rounded-md">{{ $cfg['a_label'] }}</span>
            </div>
            <div class="bg-accent-50 rounded-2xl p-5 lg:p-7 border border-accent-200 text-center">
                <span class="inline-block text-[13px] font-medium text-white bg-accent-600 px-3 py-1 rounded-md">{{ $cfg['b_label'] }}</span>
            </div>
        </div>
    </div>
</section>

<!-- TABLEAU COMPARATIF -->
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Comparaison point par point</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight">{{ $cfg['a_label'] }} vs {{ $cfg['b_label'] }} : le tableau</h2>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-dark-100 bg-white lg:shadow-sm">
            <table class="w-full text-left border-collapse min-w-[640px]">
                <caption class="sr-only">Tableau comparatif {{ $cfg['a_label'] }} contre {{ $cfg['b_label'] }} : périmètre, fonction et caractéristiques.</caption>
                <thead>
                    <tr class="border-b border-dark-200">
                        <th scope="col" class="text-[13px] font-medium uppercase tracking-wider text-dark-500 px-5 py-4 w-1/4"></th>
                        <th scope="col" class="text-[15px] font-medium text-dark-900 px-5 py-4">
                            <span class="inline-block text-[12px] font-medium text-white bg-dark-600 px-2.5 py-1 rounded-md">{{ $cfg['a_label'] }}</span>
                        </th>
                        <th scope="col" class="text-[15px] font-medium text-dark-900 px-5 py-4">
                            <span class="inline-block text-[12px] font-medium text-white bg-accent-600 px-2.5 py-1 rounded-md">{{ $cfg['b_label'] }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cfg['rows'] as $row)
                    <tr class="@if(!$loop->last) border-b border-dark-100 @endif">
                        <th scope="row" class="text-[14px] font-medium text-dark-900 px-5 py-4 align-top">{{ $row['label'] }}</th>
                        <td class="text-[14px] text-dark-500 leading-relaxed px-5 py-4 align-top">{{ $row['a'] }}</td>
                        <td class="text-[14px] text-dark-500 leading-relaxed px-5 py-4 align-top">{{ $row['b'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- QUAND CHOISIR L'UN / L'AUTRE -->
<section class="py-10 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Aide à la décision</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight">Quand choisir l'un ou l'autre</h2>
        </div>
        @if(!empty($cfg['choose']))
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 lg:gap-5">
            <div class="bg-dark-50 rounded-2xl p-5 lg:p-7 border border-dark-100">
                <span class="inline-block text-[13px] font-medium text-white bg-dark-600 px-2.5 py-1 rounded-md mb-4">{{ $cfg['a_label'] }}</span>
                <h3 class="text-lg font-medium text-dark-900 mb-3">{{ $cfg['choose']['a']['title'] }}</h3>
                <ul class="text-sm text-dark-500 leading-relaxed space-y-2">
                    @foreach($cfg['choose']['a']['items'] as $item)
                    <li class="flex gap-2"><span class="text-accent-600 flex-shrink-0">&rarr;</span><span>{{ $item }}</span></li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-accent-50 rounded-2xl p-5 lg:p-7 border border-accent-200">
                <span class="inline-block text-[13px] font-medium text-white bg-accent-600 px-2.5 py-1 rounded-md mb-4">{{ $cfg['b_label'] }}</span>
                <h3 class="text-lg font-medium text-dark-900 mb-3">{{ $cfg['choose']['b']['title'] }}</h3>
                <ul class="text-sm text-dark-500 leading-relaxed space-y-2">
                    @foreach($cfg['choose']['b']['items'] as $item)
                    <li class="flex gap-2"><span class="text-accent-600 flex-shrink-0">&rarr;</span><span>{{ $item }}</span></li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- FAQ -->
@if(!empty($cfg['faq']))
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-[720px] mx-auto px-5 lg:px-10">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Questions fréquentes</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight">Ce qu'il faut retenir</h2>
        </div>
        @foreach($cfg['faq'] as $index => $item)
        <div x-data="{ open: false }" class="border-t border-dark-200 @if($loop->last) border-b @endif">
            <button type="button" @click="open = !open" :aria-expanded="open ? 'true' : 'false'" aria-controls="cmp-faq-{{ $index }}" class="w-full flex items-center justify-between py-5 min-h-[56px] text-left bg-transparent border-none cursor-pointer">
                <span class="text-[15px] font-medium text-dark-900 pr-4">{{ $item['question'] }}</span>
                <svg :class="open && 'rotate-180'" class="w-4 h-4 text-dark-500 transition-transform duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div id="cmp-faq-{{ $index }}" x-show="open" x-collapse x-cloak>
                <p class="text-sm text-dark-500 leading-relaxed pb-5">{{ $item['answer'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- CTA FINAL -->
<section class="relative overflow-hidden py-10 lg:py-20 bg-dark-100 border-t border-dark-200">
    <img src="/images/hero-gtb-illustration.webp" alt="" aria-hidden="true" width="1200" height="630" loading="lazy" class="absolute right-0 top-0 h-full w-auto object-cover opacity-20" />
    <div class="absolute inset-0 bg-gradient-to-r from-dark-100 via-dark-100/80 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-5 lg:px-10 relative z-10 flex items-center min-h-[200px]">
        <div class="max-w-lg">
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Un doute sur votre situation ?</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">Lancez un pré-diagnostic gratuit pour situer votre bâtiment, ou échangez avec un consultant indépendant, sans démarche commerciale.</p>
            <div class="flex flex-wrap items-center gap-3">
                <a href="/audit" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
                    Pré-diagnostic gratuit
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-dark-900 text-sm font-semibold rounded-lg border border-dark-200 hover:border-dark-300 transition-colors">
                    Poser une question
                </a>
            </div>
        </div>
    </div>
</section>

<!-- MAILLAGE INTERNE : autres comparatifs -->
@if(!empty($others))
<section class="py-12 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-6">Autres comparatifs</p>
        <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
            @foreach($others as $other)
            <a href="{{ url('/comparatif/' . $other['slug']) }}" class="block bg-dark-50 rounded-2xl p-5 lg:p-7 border border-dark-100 card-hover-glow">
                <h3 class="text-[15px] font-medium text-dark-900 mb-2">{{ $other['title'] }}</h3>
                <p class="text-sm text-dark-500 leading-relaxed">{{ \Illuminate\Support\Str::limit($other['lede'], 120) }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- MENTION DE FIABILITÉ -->
<section class="pb-12 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <p class="text-[12px] text-dark-500 leading-relaxed border-t border-dark-100 pt-6">
            Informations à jour (mars 2026), à vérifier sur Légifrance et auprès d'un professionnel.
        </p>
    </div>
</section>

@endsection
