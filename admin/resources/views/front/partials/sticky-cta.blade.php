@unless(request()->is('audit') || request()->is('admin*') || request()->is('contact'))
<div
    x-data="stickyCta()"
    x-init="init()"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-full opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-full opacity-0"
    class="lg:hidden fixed inset-x-0 bottom-0 z-40 bg-white/95 backdrop-blur-xl border-t border-dark-100"
    style="padding-bottom: calc(12px + env(safe-area-inset-bottom));"
    role="complementary"
    aria-label="{{ $site->label('sticky_cta.aria_label', 'Accès rapide au pré-diagnostic') }}"
>
    <div class="px-4 pt-3 flex items-center gap-3">
        <div class="flex-1 min-w-0">
            <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-accent-600">{{ $site->label('sticky_cta.badge', 'Gratuit · 5 min') }}</p>
            <p class="text-[13px] text-dark-700 font-medium truncate">{{ $site->label('sticky_cta.title', 'Pré-diagnostic GTB ISO 52120-1') }}</p>
        </div>
        <a href="/audit"
           class="inline-flex items-center gap-1.5 bg-dark-900 hover:bg-dark-800 text-white text-[13px] font-semibold px-4 py-2.5 rounded-xl min-h-[44px] flex-shrink-0">
            {{ $site->label('sticky_cta.button', 'Lancer') }}
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        <button @click="dismiss()" aria-label="{{ $site->label('sticky_cta.dismiss', 'Masquer') }}"
                class="w-9 h-9 flex items-center justify-center text-dark-400 hover:text-dark-700 flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>

<script>
function stickyCta() {
    return {
        show: false,
        dismissed: sessionStorage.getItem('neogtb_cta_dismissed') === '1',
        init() {
            if (this.dismissed) return;
            const hero = document.querySelector('[data-hero], main section:first-of-type');
            if (!hero) { this.show = true; return; }
            const heroObs = new IntersectionObserver(([e]) => {
                if (!this.dismissed) this.show = !e.isIntersecting;
            }, { threshold: 0 });
            heroObs.observe(hero);
            const sections = document.querySelectorAll('main section');
            const last = sections[sections.length - 1];
            if (last) {
                const bottomObs = new IntersectionObserver(([e]) => {
                    if (e.isIntersecting) this.show = false;
                }, { threshold: 0.3 });
                bottomObs.observe(last);
            }
        },
        dismiss() {
            this.show = false;
            this.dismissed = true;
            sessionStorage.setItem('neogtb_cta_dismissed', '1');
        }
    }
}
</script>
@endunless
