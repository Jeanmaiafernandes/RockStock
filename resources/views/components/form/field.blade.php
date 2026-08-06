@props(['name', 'label' => null, 'livre' => false])

<div {{ $attributes->class([
        'space-y-1 self-start',
        'relative pb-5' => ! $livre,   // reserva 1 linha pro erro: validar não empurra o grid
    ]) }}>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium">{{ $label }}</label>
    @endif

    {{ $slot }}

    @error($name)
    <p class="erro absolute inset-x-0 bottom-0">{{ $message }}</p>
    @enderror
</div>
