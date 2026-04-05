@extends('front.layouts.app')
@section('title', $post->meta_title ?? $post->title . ' — NeoGTB')
@section('description', $post->meta_description ?? $post->excerpt)

@section('content')
<article>
    <header class="hero-gradient py-16 text-center text-white">
        @if($post->category)
            <span class="inline-block rounded-full bg-white/20 px-3 py-1 text-sm font-medium">{{ $post->category->name }}</span>
        @endif
        <h1 class="mx-auto mt-4 max-w-4xl text-3xl font-black sm:text-4xl lg:text-5xl">{{ $post->title }}</h1>
        <div class="mt-4 text-sm text-blue-200">
            Par {{ $post->author?->name ?? 'NeoGTB' }} · {{ $post->published_at?->format('d/m/Y') }} · {{ $post->views }} vues
        </div>
    </header>

    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6">
        @if($post->excerpt)
            <p class="mb-8 text-xl font-medium leading-relaxed text-gray-600 italic">{{ $post->excerpt }}</p>
        @endif

        <div class="prose prose-lg max-w-none prose-headings:font-bold prose-a:text-primary-600">
            {!! $post->content !!}
        </div>
    </div>

    @if($related->isNotEmpty())
        <section class="border-t bg-gray-50 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-8 text-2xl font-bold">Articles similaires</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    @foreach($related as $rel)
                        <a href="/blog/{{ $rel->slug }}" class="rounded-xl border bg-white p-5 transition hover:shadow-md">
                            <h3 class="font-bold text-gray-900">{{ $rel->title }}</h3>
                            <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $rel->excerpt }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</article>
@endsection
