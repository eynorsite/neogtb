@props(['href', 'eyebrow' => null, 'text', 'linkText', 'icon' => 'info'])
@php
  $icons = [
    'info' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    'arrow' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>',
    'checkmark' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
  ];
  $iconSvg = $icons[$icon] ?? $icons['info'];
@endphp
<div class="bg-accent-50 border border-accent-200 rounded-xl p-5 my-6">
  <div class="flex items-start gap-3 mb-2">
    <svg class="w-5 h-5 text-accent-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $iconSvg !!}</svg>
    <div class="flex-1">
      @if($eyebrow)
        <div class="text-[11px] uppercase tracking-widest text-accent-700 font-semibold mb-2">{{ $eyebrow }}</div>
      @endif
      <p class="text-sm text-dark-700 leading-relaxed mb-3 m-0">{{ $text }}</p>
      <a href="{{ $href }}" class="group inline-flex items-center gap-1.5 text-[13px] font-medium text-accent-600 hover:text-accent-700 transition-colors">
        <span class="group-hover:underline underline-offset-4 decoration-accent-400">{{ $linkText }}</span>
        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</div>
