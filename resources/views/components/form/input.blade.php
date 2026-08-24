@props([
    'name',
    'value' => null,
    'type'  => 'text',
])

{{-- Input de texto padrão (tema claro). Uso: <x-form.input name="nome" :value="old('nome')" /> --}}
<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $attributes->get('id', $name) }}"
    value="{{ $value }}"
    {{ $attributes->except('id')->merge(['class' => 'block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500']) }}
>
