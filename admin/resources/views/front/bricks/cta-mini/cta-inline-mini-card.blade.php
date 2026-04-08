@props(['href', 'eyebrow' => null, 'text', 'linkText'])
<a href="{{ $href }}" class="group block border border-dark-200 rounded-xl bg-white p-5 my-6 hover:border-accent-300 hover:bg-accent-50/30 transition-colors">
  @if($eyebrow)
    <div class="text-[11px] uppercase tracking-widest text-accent-600 font-semibold mb-1">{{ $eyebrow }}</div>
  @endif
  <div class="flex items-center justify-between gap-4">
    <p class="text-[14px] text-dark-700 m-0 flex-1 leading-relaxed">{{ $text }}</p>
    <span class="inline-flex items-center gap-1 text-[13px] font-medium text-accent-600 group-hover:text-accent-700 whitespace-nowrap">
      {{ $linkText }}
      <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </span>
  </div>
</a>
