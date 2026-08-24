@props(['tone' => 'neutral'])

{{--
    Selo de status (pílula). Tons: success | danger | warning | neutral.
    Uso:  <x-status tone="success">Confirmado</x-status>
--}}
@php
    $mapa = [
        'success' => 'bg-emerald-100 text-emerald-700',
        'danger'  => 'bg-red-100 text-red-700',
        'warning' => 'bg-amber-100 text-amber-700',
        'neutral' => 'bg-gray-100 text-gray-600',
    ];
    $classe = $mapa[$tone] ?? $mapa['neutral'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium $classe"]) }}>
    {{ $slot }}
</span>
