@props([
    'name',
    'value' => null,
    'rows'  => 3,
])

{{-- Textarea padrão. Uso: <x-form.textarea name="descricao" :value="old('descricao', $categoria->descricao)" /> --}}
<textarea
    name="{{ $name }}"
    id="{{ $attributes->get('id', $name) }}"
    rows="{{ $rows }}"
    {{ $attributes->except('id')->merge(['class' => 'block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500']) }}
>{{ $value }}</textarea>
