@extends('front.layouts.app')


@section('content')

<section class="py-12 lg:py-24">
    <div class="max-w-[680px] mx-auto px-4 sm:px-6">

        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">{{ $site->label('legal.cookies.eyebrow', 'Transparence & vie privée') }}</p>
        <h1 class="font-heading font-medium text-dark-900 mb-2 text-[26px] tracking-tight">{{ $site->label('legal.cookies.title', 'Politique cookies') }}</h1>

        @if($content = $site->legalText('cookies'))
            <div class="prose prose-sm prose-dark max-w-none mt-8">{!! $content !!}</div>
        @else
            <p class="text-sm text-dark-400 mt-8">Contenu en cours de rédaction.</p>
        @endif

    </div>
</section>

@endsection
