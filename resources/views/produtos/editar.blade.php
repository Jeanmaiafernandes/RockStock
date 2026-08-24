@extends('layouts.app')

@section('titulo', 'Editar produto')

@section('conteudo')

    {{-- controller passa: $produto, $categorias, $status, $fornecedores, $enderecos_de_estoque --}}
    <x-page-header :title="'Editar: '.$produto->nome" />

    <div class="card max-w-3xl">
        <form action="{{ route('produtos.update', $produto) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-form.field label="SKU" name="sku">
                    <x-form.input name="sku" :value="old('sku', $produto->sku)" />
                </x-form.field>

                <x-form.field label="Tamanho" name="tamanho">
                    <x-form.input name="tamanho" :value="old('tamanho', $produto->tamanho)" />
                </x-form.field>
            </div>

            <x-form.field label="Nome" name="nome">
                <x-form.input name="nome" :value="old('nome', $produto->nome)" />
            </x-form.field>

            <x-form.field label="Descrição" name="descricao">
                <x-form.textarea name="descricao" :value="old('descricao', $produto->descricao)" />
            </x-form.field>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-form.field label="Categoria" name="produto_categoria_id">
                    <x-form.select name="produto_categoria_id" :options="$categorias"
                                   :selected="old('produto_categoria_id', $produto->produto_categoria_id)" placeholder="Selecione…" />
                </x-form.field>

                <x-form.field label="Status" name="produto_status_id">
                    <x-form.select name="produto_status_id" :options="$status"
                                   :selected="old('produto_status_id', $produto->produto_status_id)" placeholder="Selecione…" />
                </x-form.field>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-form.field label="Fornecedor" name="fornecedor_id">
                    <x-form.select name="fornecedor_id" :options="$fornecedores"
                                   :selected="old('fornecedor_id', $produto->fornecedor_id)" placeholder="Selecione…" />
                </x-form.field>

                <x-form.field label="Endereço de estoque" name="endereco_de_estoque_id">
                    <x-form.select name="endereco_de_estoque_id" :options="$enderecos_de_estoque"
                                   :selected="old('endereco_de_estoque_id', $produto->endereco_de_estoque_id)" placeholder="Selecione…" />
                </x-form.field>
            </div>

            <x-form.field label="Quantidade" name="quantidade">
                <x-form.input name="quantidade" type="number" min="0" :value="old('quantidade', $produto->quantidade)" class="sm:max-w-xs" />
            </x-form.field>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Salvar alterações</x-primary-button>
                <a href="{{ route('produtos.index') }}" class="btn-sec">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
