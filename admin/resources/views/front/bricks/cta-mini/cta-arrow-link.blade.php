@props(['href', 'text', 'align' => 'right', 'size' => 'sm'])
@php $alignClass = ['right'=>'justify-end','center'=>'justify-center','left'=>'justify-start'][$align] ?? 'justify-end'; @endphp
<div class="flex {{ $alignClass }} mt-4">
  <a href="{{ $href }}" class="group inline-flex items-center gap-1.5 text-[13px] font-medium text-accent-600 hover:text-accent-700 transition-colors">
    <span class="group-hover:underline underline-offset-4 decoration-accent-400">{{ $text }}</span>
    <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
  </a>
</div>
