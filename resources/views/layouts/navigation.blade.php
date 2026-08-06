@props(['active' => false])

@php
    $classes = $active
        ? 'flex items-center gap-3 rounded-lg bg-gray-800 px-3 py-2.5 text-sm font-medium text-white'
        : 'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-400 hover:bg-gray-800 hover:text-gray-200 transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @isset($icon)
        <span class="flex-shrink-0">{{ $icon }}</span>
    @endisset
    {{ $slot }}
</a>
