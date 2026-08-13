@props(['name', 'label' => null, 'value' => null, 'opcoes' => [], 'vazio' => 'Selecione...'])

<x-form.field :name="$name" :label="$label" :class="$attributes->get('class')">
    <select name="{{ $name }}" id="{{ $attributes->get('id', $name) }}"
        {{ $attributes->except(['class', 'id'])->merge(['class' => 'input']) }}>
        @if ($vazio !== false)
            <option value="">{{ $vazio }}</option>
        @endif

        @foreach ($opcoes as $id => $nome)
            <option value="{{ $id }}" @selected((string) old($name, $value) === (string) $id)>{{ $nome }}</option>
        @endforeach
    </select>
</x-form.field>
