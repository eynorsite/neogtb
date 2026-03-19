<section class="py-16 lg:py-24">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        @if(!empty($content['titre']))
            <h2 class="mb-10 text-center text-3xl font-bold text-gray-900 sm:text-4xl">{{ $content['titre'] }}</h2>
        @endif

        <div class="space-y-3">
            @foreach($content['questions'] ?? [] as $i => $q)
                <details class="group rounded-xl border border-gray-200 bg-white">
                    <summary class="flex cursor-pointer items-center justify-between px-6 py-4 text-base font-semibold text-gray-900">
                        {{ $q['question'] ?? '' }}
                        <svg class="h-5 w-5 shrink-0 text-gray-400 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <div class="px-6 pb-4 text-sm leading-relaxed text-gray-600">
                        {{ $q['reponse'] ?? '' }}
                    </div>
                </details>
            @endforeach
        </div>
    </div>
</section>
