<x-filament-panels::page>
    @php
        $totalSize = \App\Models\Media::sum('size');
        $totalFiles = \App\Models\Media::count();
        $sizeHuman = $totalSize > 0 ? round($totalSize / 1024 / 1024, 1) . ' Mo' : '0 Mo';
    @endphp

    <div class="mb-4 flex gap-4">
        <x-filament::badge color="info">
            {{ $totalFiles }} fichier(s)
        </x-filament::badge>
        <x-filament::badge color="warning">
            {{ $sizeHuman }} utilisés
        </x-filament::badge>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
