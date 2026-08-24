@props([
    'label' => null,
    'name'  => null,
    'hint'  => null,
])

{{--
    Envelope de um campo de formulário: rótulo + campo (slot) + erro de validação.
    Usa os componentes Breeze x-input-label e x-input-error.
    Uso:
        <x-form.field label="Nome" name="nome">
            <x-form.input name="nome" :value="old('nome', $produto->nome)" />
        </x-form.field>
--}}
<div>
    @if ($label)
        <x-input-label :for="$name" :value="$label" />
    @endif

    <div class="mt-1">{{ $slot }}</div>

    @if ($hint)
        <p class="mt-1 text-xs text-gray-400">{{ $hint }}</p>
    @endif

    @if ($name)
        <x-input-error :messages="$errors->get($name)" class="mt-1" />
    @endif
</div>
