@props([
    'name',
    'label'   => null,
    'checked' => false,
    'value'   => 1,
])

{{-- Checkbox com rótulo. Uso: <x-form.checkbox name="disponivel" label="Disponível" :checked="old('disponivel', $status->disponivel)" /> --}}
<label class="inline-flex items-center gap-2">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $attributes->get('id', $name) }}"
        value="{{ $value }}"
        @checked($checked)
        {{ $attributes->except('id')->merge(['class' => 'rounded border-gray-300 text-violet-600 shadow-sm focus:ring-violet-500']) }}
    >
    @if ($label)
        <span class="text-sm text-gray-700">{{ $label }}</span>
    @endif
</label>
