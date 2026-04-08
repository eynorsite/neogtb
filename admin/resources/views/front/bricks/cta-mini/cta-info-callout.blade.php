@props(['eyebrow', 'text', 'href' => null, 'linkText' => null])
<div class="bg-accent-50 border border-accent-200 rounded-xl p-6 my-6">
  <div class="text-[11px] uppercase tracking-widest text-accent-700 font-semibold mb-2">{{ $eyebrow }}</div>
  <p class="text-[15px] text-dark-700 leading-relaxed m-0">{{ $text }}</p>
  @if($href && $linkText)
    <div class="flex justify-end mt-4">
      <a href="{{ $href }}" class="group inline-flex items-center gap-1.5 text-[13px] font-medium text-accent-600 hover:text-accent-700 transition-colors">
        <span class="group-hover:underline underline-offset-4 decoration-accent-400">{{ $linkText }}</span>
        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>
  @endif
</div>
