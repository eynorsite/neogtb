@props(['beforeText'=>'', 'linkText', 'href', 'afterText'=>''])
@php $needsSpace = $afterText && !in_array(substr($afterText, 0, 1), ['.', ',', ';', ':', '!', '?']); @endphp
<p class="text-sm text-dark-500 italic mt-4 leading-relaxed">
  {{ $beforeText }}
  <a href="{{ $href }}" class="text-accent-600 underline underline-offset-4 decoration-accent-300 decoration-2 hover:decoration-accent-600 not-italic font-medium transition-colors">{{ $linkText }}</a>{{ $afterText ? ($needsSpace ? ' '.$afterText : $afterText) : '' }}
</p>
