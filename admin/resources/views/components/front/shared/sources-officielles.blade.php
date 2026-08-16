@props([
    // Liste de sources. Chaque item : ['label' => …, 'url' => …, 'note' => … (optionnel)]
    'items' => [],
    'title' => 'Sources officielles',
    // Phrase de contexte affichée sous le titre (optionnelle).
    'lede' => null,
])

@php
    // Aucune page du site ne citait de source externe : sur des contenus réglementaires,
    // c'est le signal de fiabilité qui manque le plus, autant pour l'E-E-A-T de Google que
    // pour les moteurs de réponse, qui reprennent en priorité ce qui est sourcé.
    // Les liens sortent en nofollow-libre (pas de nofollow : ce sont des références
    // volontaires vers des institutions) avec noopener/noreferrer pour la sécurité.
    $sources = collect($items)
        ->map(fn ($s) => [
            'label' => trim((string) ($s['label'] ?? '')),
            'url' => trim((string) ($s['url'] ?? '')),
            'note' => trim((string) ($s['note'] ?? '')),
        ])
        ->filter(fn ($s) => $s['label'] !== '' && str_starts_with($s['url'], 'https://'))
        ->values();
@endphp

@if ($sources->isNotEmpty())
<section aria-labelledby="sources-officielles-title" class="mt-16 rounded-xl p-6 md:p-8" style="border: 0.5px solid var(--color-dark-200); background: var(--color-dark-50);">
    <h2 id="sources-officielles-title" class="text-[13px] font-medium uppercase tracking-wider text-dark-500">
        {{ $title }}
    </h2>

    @if ($lede)
        <p class="mt-3 text-[14px] text-dark-600" style="line-height: 1.7;">{{ $lede }}</p>
    @endif

    <ul class="mt-5 space-y-3">
        @foreach ($sources as $source)
            <li class="text-[14px]" style="line-height: 1.6;">
                <a
                    href="{{ $source['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-accent-600 hover:text-accent-700 underline underline-offset-2 transition-colors duration-200"
                >{{ $source['label'] }}</a><span class="sr-only"> (nouvelle fenêtre)</span>
                @if ($source['note'])
                    <span class="text-dark-500"> — {{ $source['note'] }}</span>
                @endif
            </li>
        @endforeach
    </ul>

    <p class="mt-5 text-[12px] text-dark-500">
        Contenu rédigé à partir des textes publiés par les administrations citées. En cas
        d'écart, le texte officiel fait foi.
    </p>
</section>
@endif
