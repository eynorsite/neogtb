<section class="py-12 lg:py-24 bg-dark-50/50">
    <div class="mx-auto max-w-3xl px-5 lg:px-10">
        @if(!empty($content['eyebrow']) || !empty($content['titre']))
            <div class="mx-auto max-w-2xl text-center mb-12 animate-fade-in-up">
                @if(!empty($content['eyebrow']))
                    <p class="text-sm font-semibold uppercase tracking-wider text-accent-600">{{ $content['eyebrow'] }}</p>
                @endif
                @if(!empty($content['titre']))
                    <h2 class="font-display mt-2 text-3xl font-bold md:text-4xl text-dark-900">{{ $content['titre'] }}</h2>
                @endif
            </div>
        @endif

        <div class="glass-card rounded-2xl p-6 md:p-8">
        <div class="space-y-0 divide-y divide-dark-100" x-data="{ open: null }">
            @foreach($content['questions'] ?? [] as $i => $q)
                <div class="overflow-hidden transition-all duration-300 animate-fade-in-up"
                     style="animation-delay: {{ $i * 80 }}ms">

                    <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                            class="flex w-full cursor-pointer items-center justify-between py-4 text-left transition-colors duration-200 hover:text-accent-600">
                        <span class="text-base font-display font-semibold text-dark-900 pr-4">{{ $q['question'] ?? '' }}</span>
                        <span class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full transition-colors duration-200"
                              :class="open === {{ $i }} ? 'bg-primary-100 text-primary-600' : 'bg-dark-100 text-dark-400'">
                            <svg class="h-4 w-4 transition-transform duration-300"
                                 :class="open === {{ $i }} ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>

                    <div x-show="open === {{ $i }}"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         x-cloak
                         class="pb-4">
                        <div class="text-sm leading-relaxed text-dark-500">
                            {{ $q['reponse'] ?? '' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </div>
</section>
