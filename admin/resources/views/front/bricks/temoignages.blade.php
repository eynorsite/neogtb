{{-- Premium Testimonials — Social proof élégant --}}
@php $style = $settings['style'] ?? 'grid'; @endphp

<section class="py-24 lg:py-32 bg-dark-50/30 relative overflow-hidden">
    {{-- Subtle background --}}
    <div class="absolute inset-0 bg-gradient-radial opacity-20"></div>
    <div class="absolute inset-0 bg-dots-pattern opacity-30"></div>
    
    <div class="relative z-10 mx-auto max-w-[1280px] px-6 md:px-10">
        {{-- Section Header --}}
        @if(!empty($content['titre']))
            <div class="text-center mb-16 lg:mb-20 max-w-3xl mx-auto">
                @if(!empty($content['eyebrow']))
                    <div class="badge-premium mb-6 animate-fade-in-up">
                        {{ $content['eyebrow'] }}
                    </div>
                @endif
                <h2 class="heading-premium text-3xl sm:text-4xl lg:text-5xl text-dark-900 animate-fade-in-up" style="animation-delay: 0.1s;">
                    {{ $content['titre'] }}
                </h2>
                @if(!empty($content['sous_titre']))
                    <p class="subheading-premium mt-6 text-lg text-dark-500 animate-fade-in-up" style="animation-delay: 0.2s;">
                        {{ $content['sous_titre'] }}
                    </p>
                @endif
            </div>
        @endif

        {{-- Testimonials Grid --}}
        <div class="grid grid-cols-1 gap-6 lg:gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($content['avis'] ?? [] as $i => $avis)
                <div class="card-premium p-8 lg:p-10 relative animate-fade-in-up" style="animation-delay: {{ $i * 100 }}ms;">
                    
                    {{-- Quote mark --}}
                    <div class="absolute -top-4 left-8">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-accent-500 to-accent-600 shadow-lg shadow-accent-500/20">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Rating --}}
                    @if(!empty($avis['note']))
                        <div class="mb-6 flex gap-1 mt-4">
                            @for($j = 0; $j < 5; $j++)
                                <svg class="h-5 w-5 {{ $j < (int)$avis['note'] ? 'text-gold-400' : 'text-dark-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    @endif

                    {{-- Testimonial text --}}
                    <blockquote class="text-[15px] leading-relaxed text-dark-600 mb-8">
                        "{{ $avis['texte'] ?? '' }}"
                    </blockquote>

                    {{-- Author --}}
                    <div class="flex items-center gap-4 pt-6 border-t border-dark-100">
                        {{-- Avatar with initials --}}
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-primary-600 text-white text-sm font-bold shadow-lg shadow-primary-500/20">
                            {{ strtoupper(substr($avis['nom'] ?? 'A', 0, 1)) }}{{ strtoupper(substr(explode(' ', $avis['nom'] ?? '')[1] ?? '', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold text-dark-900 text-[15px]">{{ $avis['nom'] ?? '' }}</div>
                            @if(!empty($avis['poste']))
                                <div class="text-sm text-dark-400">{{ $avis['poste'] }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Trust badge --}}
        @if(!empty($content['trust_badge']))
            <div class="text-center mt-16 animate-fade-in-up" style="animation-delay: 0.5s;">
                <p class="text-sm text-dark-400">{{ $content['trust_badge'] }}</p>
            </div>
        @endif
    </div>
</section>
