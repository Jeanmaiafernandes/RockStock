@props(['ver' => null, 'editar' => null, 'excluir' => null])

<div x-data="{ aberto: false }" class="relative inline-block text-left">

    <button type="button"
            x-on:click="aberto = !aberto"
            x-on:keydown.escape.window="aberto = false"
            class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600"
            aria-haspopup="true" :aria-expanded="aberto">
        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 6.75a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm0 6.75a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm0 6.75a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Z"/>
        </svg>
    </button>

    <div x-show="aberto"
         x-on:click.outside="aberto = false"
         x-transition.opacity.duration.150ms
         class="absolute right-0 z-30 mt-1 w-44 overflow-hidden rounded-lg border border-gray-200 bg-white py-1 text-left shadow-lg"
         style="display:none">

        @if ($ver)
            <a href="{{ $ver }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Visualizar</a>
        @endif

        @if ($editar)
            <a href="{{ $editar }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Editar</a>
        @endif

        @if ($excluir)
            <form method="POST" action="{{ $excluir }}"
                  onsubmit="return confirm('Confirma a exclusão? Esta ação não pode ser desfeita.')">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="block w-full border-t border-gray-100 px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">
                    Excluir
                </button>
            </form>
        @endif
    </div>
</div>
