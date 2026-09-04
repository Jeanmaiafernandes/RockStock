@props([
    'name',
    'options'     => [],
    'selected'    => null,
    'placeholder' => null,
])

{{-- Select padrão. Uso: <x-form.select
name="categoria_id"
 :options="$categorias"
  :selected="old('categoria_id')"
   placeholder="Selecione…" /> --}}

<select
    name="{{ $name }}"
    id="{{ $attributes->get('id', $name) }}"
    {{ $attributes->except('id')->merge(['class' =>
 'block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500']) }}
>
    @if (! is_null($placeholder))
        <option value="">{{ $placeholder }}</option>
    @endif

    @foreach ($options as $valor => $rotulo)
        <option value="{{ $valor }}" @selected((string) $selected === (string) $valor)>{{ $rotulo }}</option>
    @endforeach
</select>
