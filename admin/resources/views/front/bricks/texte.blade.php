<section class="py-12 lg:py-28" style="background-color: {{ $settings['couleur_fond'] ?? '#ffffff' }}">
    <div class="mx-auto max-w-7xl px-5 lg:px-10">
        @if(!empty($content['titre']))
            <div class="mb-10 animate-fade-in-up">
                <h2 class="text-[28px] lg:text-[44px] font-heading font-extrabold text-dark-900">{{ $content['titre'] }}</h2>
                <div class="mt-4 h-1 w-16 rounded-full bg-gradient-to-r from-primary-500 to-accent-500"></div>
            </div>
        @endif

        @php $pos = $settings['position_image'] ?? 'none'; @endphp

        @if($pos !== 'none' && !empty($content['image']))
            <div class="flex flex-col gap-6 lg:gap-16 items-center {{ $pos === 'right' ? 'lg:flex-row' : 'lg:flex-row-reverse' }}">
                <div class="flex-1 prose prose-lg max-w-none text-dark-600 prose-headings:font-heading prose-headings:text-dark-900 prose-a:text-primary-600 prose-a:no-underline hover:prose-a:underline prose-strong:text-dark-800 prose-li:marker:text-primary-500">
                    {!! \Stevebauman\Purify\Facades\Purify::clean($content['contenu'] ?? '') !!}
                </div>
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-gradient-to-br from-primary-100 to-accent-100 rounded-3xl opacity-50 blur-xl"></div>
                        <img src="{{ asset('storage/' . $content['image']) }}" alt="{{ $content['titre'] ?? 'Illustration NeoGTB' }}" class="relative rounded-2xl shadow-xl ring-1 ring-dark-100">
                    </div>
                </div>
            </div>
        @else
            <div class="prose prose-lg mx-auto max-w-4xl text-dark-600 prose-headings:font-heading prose-headings:text-dark-900 prose-a:text-primary-600 prose-a:no-underline hover:prose-a:underline prose-strong:text-dark-800 prose-li:marker:text-primary-500">
                {!! \Stevebauman\Purify\Facades\Purify::clean($content['contenu'] ?? '') !!}
            </div>
        @endif
    </div>
</section>
