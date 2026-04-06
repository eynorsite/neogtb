<div class="relative overflow-hidden"
     style="background-color: {{ $settings['couleur_fond'] ?? '#0F6BAF' }}; color: {{ $settings['couleur_texte'] ?? '#ffffff' }}">

    {{-- Animated gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>

    <div class="relative py-3.5 px-4 text-center text-sm font-semibold tracking-wide">
        @if(!empty($content['lien']))
            <a href="{{ $content['lien'] }}" class="inline-flex items-center gap-2 hover:opacity-90 transition-opacity duration-200 group">
                <span>{{ $content['texte'] ?? '' }}</span>
                <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        @else
            <span>{{ $content['texte'] ?? '' }}</span>
        @endif
    </div>
</div>
