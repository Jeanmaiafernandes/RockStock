@extends('layouts.app')

@section('titulo', 'Editar status')

@section('conteudo')

    {{-- o controller passa $statusProduto (App\Models\ProdutoStatus) --}}
    <x-page-header :title="'Editar: '.$statusProduto->nome" />

    <div class="card max-w-2xl">
        <form action="{{ route('statusProdutos.update', $statusProduto) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            <x-form.field label="Nome" name="nome">
                <x-form.input name="nome" :value="old('nome', $statusProduto->nome)" />
            </x-form.field>

            <x-form.field name="disponivel">
                <input type="hidden" name="disponivel" value="0">
                <x-form.checkbox name="disponivel" label="Disponível para venda" :checked="old('disponivel', $statusProduto->disponivel)" />
            </x-form.field>

            <x-form.field name="permite_saida">
                <input type="hidden" name="permite_saida" value="0">
                <x-form.checkbox name="permite_saida" label="Permite saída de estoque" :checked="old('permite_saida', $statusProduto->permite_saida)" />
            </x-form.field>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Salvar alterações</x-primary-button>
                <a href="{{ route('statusProdutos.index') }}" class="btn-sec">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
