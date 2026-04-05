<div class="py-3 text-center text-sm font-medium"
     style="background-color: {{ $settings['couleur_fond'] ?? '#0F6BAF' }}; color: {{ $settings['couleur_texte'] ?? '#ffffff' }}">
    @if(!empty($content['lien']))
        <a href="{{ $content['lien'] }}" class="hover:underline">{{ $content['texte'] ?? '' }} →</a>
    @else
        {{ $content['texte'] ?? '' }}
    @endif
</div>
