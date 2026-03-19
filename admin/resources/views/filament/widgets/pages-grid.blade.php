<x-filament-widgets::widget>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($this->getPages() as $page)
            @php
                $icons = [
                    'accueil' => '🏠', 'gtb' => '🏢', 'gtc' => '⚙️',
                    'solutions' => '🔧', 'audit' => '📋', 'comparateur' => '📊',
                    'contact' => '📞', 'about' => 'ℹ️',
                ];
            @endphp
            <div class="group relative overflow-hidden rounded-xl border border-gray-200 bg-white p-5 transition-all hover:shadow-lg hover:border-primary-200">
                {{-- Status dot --}}
                <div class="absolute right-3 top-3">
                    @if($page->is_published)
                        <span class="flex h-2.5 w-2.5 rounded-full bg-green-500" title="Publiée"></span>
                    @else
                        <span class="flex h-2.5 w-2.5 rounded-full bg-gray-300" title="Brouillon"></span>
                    @endif
                </div>

                {{-- Icon + Name --}}
                <div class="mb-3 flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-50 text-xl">
                        {{ $icons[$page->slug] ?? '📄' }}
                    </span>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $page->name }}</h3>
                        <p class="text-xs text-gray-400">/{{ $page->slug }}</p>
                    </div>
                </div>

                {{-- Bricks count --}}
                <div class="mb-4 flex items-center gap-2">
                    <span class="rounded-full bg-primary-50 px-2 py-0.5 text-xs font-medium text-primary-700">
                        🧱 {{ $page->bricks_count }} brick(s)
                    </span>
                    <span class="text-xs text-gray-400">
                        Ordre {{ $page->order }}
                    </span>
                </div>

                {{-- Actions --}}
                <div class="flex gap-2">
                    <a href="{{ url('/admin/pages/' . $page->id . '/bricks') }}"
                       class="flex-1 rounded-lg bg-primary-600 px-3 py-2 text-center text-xs font-semibold text-white transition hover:bg-primary-700">
                        🧱 Bricks
                    </a>
                    <a href="{{ route('filament.admin.resources.pages.edit', $page->id) }}"
                       class="flex-1 rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-semibold text-gray-600 transition hover:bg-gray-50">
                        ✏️ Modifier
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</x-filament-widgets::widget>
