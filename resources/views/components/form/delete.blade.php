@props([
    'action',
    'confirm' => 'Tem certeza que deseja excluir?',
])

{{--
    Botão de excluir: form inline com @method('DELETE') + confirmação.
    Uso:  <x-form.delete :action="route('produtos.destroy', $produto)" />
--}}
<form action="{{ $action }}" method="POST" class="inline" onsubmit="return confirm('{{ $confirm }}')">
    @csrf
    @method('DELETE')
    <button type="submit" {{ $attributes->merge(['class' => 'text-sm font-medium text-red-600 hover:text-red-700']) }}>
        {{ $slot->isEmpty() ? 'Excluir' : $slot }}
    </button>
</form>
