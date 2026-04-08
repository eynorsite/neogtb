@extends('front.layouts.app')

@section('title', ($page->meta_title ?? $page->name) . ' — NeoGTB')
@section('description', $page->meta_description ?? '')

@section('content')
    @foreach($bricks as $brick)
        @include('front.bricks.' . $brick->brick_type, ['brick' => $brick, 'content' => $brick->content ?? [], 'settings' => $brick->settings ?? []])
    @endforeach

    @if(($page->slug ?? null) === 'accueil')
        <!-- ==================== STICKY CTA MOBILE ==================== -->
        <div class="sticky-cta-mobile"
            x-data="{ show: false }"
            x-init="
                const hero = document.querySelector('.hero-img');
                const sections = document.querySelectorAll('section');
                const ctaFinal = sections[sections.length - 1];
                if (hero) {
                    const observer = new IntersectionObserver(([e]) => { show = !e.isIntersecting }, { threshold: 0 });
                    observer.observe(hero);
                }
                if (ctaFinal) {
                    const observerBottom = new IntersectionObserver(([e]) => { if(e.isIntersecting) show = false }, { threshold: 0.3 });
                    observerBottom.observe(ctaFinal);
                }
            "
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-full opacity-0"
            x-cloak>
            <a href="/audit" class="sticky-cta-btn">
                Pré-diagnostic gratuit
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    @endif
@endsection
