@props(['action', 'texto' => 'Excluir'])

<form method="POST" action="{{ $action }}" class="inline"
      onsubmit="return confirm('Confirma a exclusão?')">
    @csrf
    @method('DELETE')
    <button class="text-red-600 hover:underline">{{ $texto }}</button>
</form>
