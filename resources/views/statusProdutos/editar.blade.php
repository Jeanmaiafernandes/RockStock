@extends('layouts.app')

@section('titulo', 'Editar status')

@section('conteudo')
    <form method="POST" action="{{ route('statusProdutos.update', $statusProduto) }}" class="card max-w-lg space-y-5">
        @csrf
        @method('PATCH')

        <x-form.input name="nome" label="Nome" :value="$statusProduto->nome" maxlength="50" autofocus />

        <div class="space-y-3 border-t border-gray-100 pt-4">
            <x-form.checkbox name="disponivel" label="Disponível" :checked="$statusProduto->disponivel" />
            <p class="-mt-2 pl-6 text-xs text-gray-500">
                Produtos com este status aparecem como ativos nas listagens.
            </p>

            <x-form.checkbox name="permite_saida" label="Permite saída" :checked="$statusProduto->permite_saida" />
            <p class="-mt-2 pl-6 text-xs text-gray-500">
                Produtos com este status podem ser incluídos em pedidos.
            </p>
        </div>

        @if ($statusProduto->produtos_count ?? 0)
            <p class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs text-amber-800">
                {{ $statusProduto->produtos_count }} produto(s) usam este status. Alterar "permite saída"
                afeta todos eles.
            </p>
        @endif

        <div class="flex gap-2">
            <button class="btn">Salvar alterações</button>
            <a href="{{ route('statusProdutos.index') }}" class="btn-sec">Cancelar</a>
        </div>
    </form>
@endsection
