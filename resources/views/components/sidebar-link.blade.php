@props(['href', 'active' => false])

<a href="{{ $href }}"
    {{ $attributes->class([
        'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition',
        'bg-violet-600 text-white' => $active,
        'text-gray-400 hover:bg-gray-800 hover:text-white' => ! $active,
    ]) }}>

    @isset($icon)
        <span class="shrink-0">{{ $icon }}</span>
    @endisset

    <span class="truncate">{{ $slot }}</span>
</a>
