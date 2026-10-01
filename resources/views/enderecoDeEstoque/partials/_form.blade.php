{{--
    Campos do endereço, usados no criar e no editar.
    Espera: $locais ([id => nome]), $tipos (EnderecoDeEstoque::TIPOS) e, no editar, $enderecoDeEstoque.
--}}
@php
    $enderecoDeEstoque ??= null;
    $editando = (bool) $enderecoDeEstoque;
@endphp

<div class="card max-w-2xl">
    <form method="POST"
          action="{{ $editando ? route('enderecoDeEstoque.atualizar', $enderecoDeEstoque) : route('enderecoDeEstoque.salvar') }}"
          class="space-y-5">
        @csrf
        @if ($editando)
            @method('PUT')
        @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <x-form.field label="Local" name="local_estoque_id">
                <x-form.select name="local_estoque_id" :options="$locais"
                               :selected="old('local_estoque_id', $enderecoDeEstoque?->local_estoque_id)" required />
            </x-form.field>

            <x-form.field label="Código" name="codigo">
                <x-form.input name="codigo" :value="old('codigo', $enderecoDeEstoque?->codigo)"
                              placeholder="A-03-02-B" class="font-mono uppercase" maxlength="20" required />
            </x-form.field>

            <x-form.field label="Tipo" name="tipo" class="sm:col-span-2">
                <x-form.select name="tipo" :options="$tipos"
                               :selected="old('tipo', $enderecoDeEstoque?->tipo ?? 'armazenagem')" required />
            </x-form.field>
        </div>

        <p class="text-xs text-gray-500">
            Doca recebe mercadoria antes de guardar. Armazenagem guarda o estoque disponível.
            Bloqueado, avaria e devolução separam peças que não podem ser vendidas.
        </p>

        <x-form.field name="ativo">
            <input type="hidden" name="ativo" value="0">
            <x-form.checkbox name="ativo" value="1" label="Endereço ativo"
                             :checked="(bool) old('ativo', $enderecoDeEstoque?->ativo ?? true)" />
        </x-form.field>

        <div class="flex items-center gap-3 pt-2">
            <x-primary-button>{{ $editando ? 'Salvar alterações' : 'Cadastrar endereço' }}</x-primary-button>
            <a href="{{ route('enderecoDeEstoque.index') }}" class="btn-sec">Cancelar</a>
        </div>
    </form>
</div>
