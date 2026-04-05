@extends('front.layouts.app')
@section('title', 'Blog — NeoGTB')

@section('content')
<section class="hero-gradient py-16 text-center text-white">
    <h1 class="text-4xl font-black">Blog NeoGTB</h1>
    <p class="mt-3 text-lg text-blue-200">Articles, guides et actualités GTB/GTC</p>
</section>

<section class="py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($posts as $post)
                <a href="/blog/{{ $post->slug }}" class="group overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition hover:shadow-md">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="" class="h-48 w-full object-cover">
                    @else
                        <div class="flex h-48 items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                            <span class="text-4xl">📰</span>
                        </div>
                    @endif
                    <div class="p-5">
                        @if($post->category)
                            <span class="inline-block rounded-full bg-primary-50 px-2.5 py-0.5 text-xs font-semibold text-primary-700">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        <h2 class="mt-2 text-lg font-bold text-gray-900 group-hover:text-primary-600">{{ $post->title }}</h2>
                        <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $post->excerpt }}</p>
                        <div class="mt-4 text-xs text-gray-400">{{ $post->published_at?->format('d/m/Y') }}</div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>
</section>
@endsection
