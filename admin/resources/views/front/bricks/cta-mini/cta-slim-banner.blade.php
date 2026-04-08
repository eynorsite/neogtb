@props(['href', 'text', 'linkText', 'storageKey'])
<div x-data="{ show: !localStorage.getItem('cta_dismiss_{{ $storageKey }}') }" x-show="show" x-cloak x-transition.opacity.duration.200ms class="my-6 py-3 px-5 border-l-4 border-accent-500 bg-accent-50/60 rounded-lg flex items-center justify-between gap-4">
  <p class="text-sm text-dark-700 m-0 flex-1">{{ $text }}</p>
  <a href="{{ $href }}" class="text-sm font-medium text-accent-600 hover:text-accent-700 inline-flex items-center gap-1 whitespace-nowrap">
    {{ $linkText }}
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
  </a>
  <button @click="show=false; localStorage.setItem('cta_dismiss_{{ $storageKey }}','1')" aria-label="Fermer" class="text-dark-400 hover:text-dark-700 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
  </button>
</div>
