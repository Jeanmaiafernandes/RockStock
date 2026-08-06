@props(['name', 'label' => null, 'value' => null, 'type' => 'text'])

<x-form.field :name="$name" :label="$label" :class="$attributes->get('class')">
    <input type="{{ $type }}"
           name="{{ $name }}"
           id="{{ $attributes->get('id', $name) }}"
           value="{{ old($name, $value) }}"
        {{ $attributes->except(['class', 'id'])->merge(['class' => 'input']) }}>
</x-form.field>
