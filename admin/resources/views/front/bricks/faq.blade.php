{{-- Premium FAQ — Accordion élégant --}}
<section class="py-24 lg:py-32 bg-white relative overflow-hidden">
    {{-- Subtle background --}}
    <div class="absolute inset-0 bg-gradient-radial opacity-20"></div>
    
    <div class="relative z-10 mx-auto max-w-3xl px-6 md:px-10">
        {{-- Section Header --}}
        @if(!empty($content['titre']))
            <div class="text-center mb-16 animate-fade-in-up">
                @if(!empty($content['eyebrow']))
                    <div class="badge-premium mb-6">
                        {{ $content['eyebrow'] }}
                    </div>
                @endif
                <h2 class="heading-premium text-3xl sm:text-4xl lg:text-5xl text-dark-900">
                    {{ $content['titre'] }}
                </h2>
                @if(!empty($content['sous_titre']))
                    <p class="subheading-premium mt-6 text-lg text-dark-500">{{ $content['sous_titre'] }}</p>
                @endif
            </div>
        @endif

        {{-- FAQ Items --}}
        <div class="space-y-4" x-data="{ open: 0 }">
            @foreach($content['questions'] ?? [] as $i => $q)
                <div class="card-premium overflow-hidden animate-fade-in-up"
                     style="animation-delay: {{ $i * 60 }}ms"
                     :class="open === {{ $i }} ? 'ring-2 ring-accent-500/20' : ''">

                    <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                            class="flex w-full cursor-pointer items-center justify-between px-7 py-6 text-left transition-all duration-300"
                            :class="open === {{ $i }} ? 'bg-accent-50/50' : 'hover:bg-dark-50/50'"
                            :aria-expanded="open === {{ $i }}">
                        <span class="text-[16px] font-bold text-dark-900 pr-6 leading-snug">{{ $q['question'] ?? '' }}</span>
                        <span class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-xl transition-all duration-300"
                              :class="open === {{ $i }} ? 'bg-accent-500 text-white rotate-180' : 'bg-dark-100 text-dark-500'">
                            <svg class="h-5 w-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>

                    <div x-show="open === {{ $i }}"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-96"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 max-h-96"
                         x-transition:leave-end="opacity-0 max-h-0"
                         x-cloak
                         class="overflow-hidden">
                        <div class="px-7 pb-7 pt-2">
                            <div class="text-[15px] leading-relaxed text-dark-500 border-t border-dark-100 pt-5">
                                {!! nl2br(e($q['reponse'] ?? '')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Bottom CTA --}}
        @if(!empty($content['cta_texte']))
            <div class="text-center mt-16 animate-fade-in-up" style="animation-delay: 0.4s;">
                <p class="text-dark-500 mb-4">{{ $content['cta_intro'] ?? 'Vous avez d\'autres questions ?' }}</p>
                <a href="{{ $content['cta_lien'] ?? '/contact' }}" class="btn-primary btn-glow">
                    {{ $content['cta_texte'] }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        @endif
    </div>
</section>
