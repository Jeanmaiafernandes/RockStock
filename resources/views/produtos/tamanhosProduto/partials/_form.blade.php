@php
    $tamanho ??= null;
    $editando = (bool) $tamanho;
@endphp

<div class="card max-w-2xl">
    <form method="POST"
          action="{{ $editando ? route('tamanhos.update', $tamanho) : route('tamanhos.store') }}"
          class="space-y-5">
        @csrf
        @if ($editando)
            @method('PUT')
        @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <x-form.field label="Tamanho" name="nome">
                <x-form.input name="nome"
                              :value="old('nome', $tamanho?->nome)"
                              placeholder="Ex.: GG, 42, U"
                              maxlength="10" required />
            </x-form.field>

            <x-form.field label="Ordem" name="ordem">
                <x-form.input type="number" name="ordem" min="0"
                              :value="old('ordem', $tamanho?->ordem ?? ($proximaOrdem ?? ''))"
                              required />
            </x-form.field>
        </div>

        <p class="text-xs text-gray-500">
            Tamanhos com ordem menor aparecem primeiro. Usar intervalos (10, 20, 30) facilita encaixar um tamanho novo depois.
        </p>

        @if ($editando && ($tamanho->variacoes_count ?? 0) > 0)
            <p class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                Este tamanho é usado por {{ $tamanho->variacoes_count }} SKU(s). Mudar o nome não altera os SKUs já gerados.
            </p>
        @endif

        <div class="flex items-center gap-3 pt-2">
            <x-primary-button>{{ $editando ? 'Salvar alterações' : 'Cadastrar tamanho' }}</x-primary-button>
            <a href="{{ route('tamanhos.index') }}" class="btn-sec">Cancelar</a>
        </div>
    </form>
</div>
