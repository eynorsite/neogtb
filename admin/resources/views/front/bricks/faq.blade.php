<section class="py-12 lg:py-28">
    <div class="mx-auto max-w-3xl px-5 lg:px-10">
        @if(!empty($content['titre']))
            <div class="text-center mb-14 animate-fade-in-up">
                <h2 class="text-[28px] lg:text-[44px] font-heading font-extrabold text-dark-900">{{ $content['titre'] }}</h2>
                <div class="mt-4 mx-auto h-1 w-16 rounded-full bg-gradient-to-r from-primary-500 to-accent-500"></div>
            </div>
        @endif

        <div class="space-y-4" x-data="{ open: null }">
            @foreach($content['questions'] ?? [] as $i => $q)
                <div class="rounded-2xl border border-dark-100 bg-white lg:shadow-sm overflow-hidden transition-all duration-300 animate-fade-in-up"
                     style="animation-delay: {{ $i * 80 }}ms"
                     :class="open === {{ $i }} ? 'border-l-4 border-l-accent-500 shadow-md' : ''">

                    <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                            class="flex w-full cursor-pointer items-center justify-between px-6 py-5 text-left transition-colors duration-200"
                            :class="open === {{ $i }} ? 'bg-primary-50/50' : 'hover:bg-dark-50'">
                        <span class="text-base font-heading font-bold text-dark-900 pr-4">{{ $q['question'] ?? '' }}</span>
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
                         class="px-6 pb-6">
                        <div class="pt-1 text-sm leading-relaxed text-dark-600 border-t border-dark-100 pt-4">
                            {{ $q['reponse'] ?? '' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
