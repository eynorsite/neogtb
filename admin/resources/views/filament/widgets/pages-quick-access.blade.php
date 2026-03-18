<x-filament-widgets::widget>
    <x-filament::section heading="Pages du site" icon="heroicon-o-document-text" description="Accès rapide à l'éditeur de bricks">
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($this->getPages() as $page)
                <a href="{{ url('/admin/pages/' . $page->id . '/bricks') }}"
                   class="group flex flex-col items-center gap-2 rounded-xl border border-gray-200 bg-white p-4 text-center transition hover:border-primary-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-primary-500">
                    <span class="text-2xl">
                        @switch($page->slug)
                            @case('accueil') 🏠 @break
                            @case('gtb') 🏢 @break
                            @case('gtc') ⚙️ @break
                            @case('solutions') 🔧 @break
                            @case('audit') 📋 @break
                            @case('comparateur') 📊 @break
                            @case('contact') 📞 @break
                            @case('about') ℹ️ @break
                            @default 📄
                        @endswitch
                    </span>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-600 dark:text-gray-300">
                        {{ $page->name }}
                    </span>
                    <span class="rounded-full bg-primary-50 px-2 py-0.5 text-xs font-medium text-primary-700 dark:bg-primary-900/30 dark:text-primary-300">
                        {{ $page->bricks_count }} brick(s)
                    </span>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
