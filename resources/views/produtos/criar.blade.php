@extends('layouts.app')

@section('titulo', 'Novo produto')

@section('conteudo')

    {{-- controller passa: $categorias, $status, $fornecedores, $enderecos_de_estoque ([id => rótulo]) --}}
    <x-page-header title="Novo produto" />

    <div class="card max-w-3xl">
        <form action="{{ route('produtos.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-form.field label="SKU" name="sku">
                    <x-form.input name="sku" :value="old('sku')" placeholder="VN-0248" />
                </x-form.field>

                <x-form.field label="Tamanho" name="tamanho">
                    <x-form.input name="tamanho" :value="old('tamanho')" placeholder="M, 42, único…" />
                </x-form.field>
            </div>

            <x-form.field label="Nome" name="nome">
                <x-form.input name="nome" :value="old('nome')" placeholder="Jaqueta de couro preta" />
            </x-form.field>

            <x-form.field label="Descrição" name="descricao">
                <x-form.textarea name="descricao" :value="old('descricao')" />
            </x-form.field>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-form.field label="Categoria" name="produto_categoria_id">
                    <x-form.select name="produto_categoria_id" :options="$categorias"
                                   :selected="old('produto_categoria_id')" placeholder="Selecione…" />
                </x-form.field>

                <x-form.field label="Status" name="produto_status_id">
                    <x-form.select name="produto_status_id" :options="$status"
                                   :selected="old('produto_status_id')" placeholder="Selecione…" />
                </x-form.field>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-form.field label="Fornecedor" name="fornecedor_id">
                    <x-form.select name="fornecedor_id" :options="$fornecedores"
                                   :selected="old('fornecedor_id')" placeholder="Selecione…" />
                </x-form.field>

                <x-form.field label="Endereço de estoque" name="endereco_de_estoque_id">
                    <x-form.select name="endereco_de_estoque_id" :options="$enderecos_de_estoque"
                                   :selected="old('endereco_de_estoque_id')" placeholder="Selecione…" />
                </x-form.field>
            </div>

            <x-form.field label="Quantidade" name="quantidade">
                <x-form.input name="quantidade" type="number" min="0" :value="old('quantidade', 0)" class="sm:max-w-xs" />
            </x-form.field>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Salvar produto</x-primary-button>
                <a href="{{ route('produtos.index') }}" class="btn-sec">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
