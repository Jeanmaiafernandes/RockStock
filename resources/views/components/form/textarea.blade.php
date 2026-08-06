{{-- form/textarea.blade.php --}}
@props(['name', 'label' => null, 'value' => null, 'rows' => 4])

<x-form.field :name="$name" :label="$label" livre :class="$attributes->get('class')">
    <textarea name="{{ $name }}" id="{{ $attributes->get('id', $name) }}" rows="{{ $rows }}"
              {{ $attributes->except(['class', 'id'])->merge(['class' => 'input']) }}>{{ old($name, $value) }}</textarea>
</x-form.field>
