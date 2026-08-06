@extends('layouts.app')

@section('titulo', 'Editar produto')

@section('conteudo')

    @php
        $categorias      = $categorias      ?? \App\Models\ProdutoCategoria::orderBy('nome')->pluck('nome', 'id');
        $statusProdutos  = $statusProdutos  ?? \App\Models\ProdutoStatus::orderBy('nome')->pluck('nome', 'id');
    @endphp

    <form method="POST" action="{{ route('produtos.update', $produto) }}" class="card max-w-3xl space-y-5">
        @csrf
        @method('PATCH')

        <div class="grid gap-4 md:grid-cols-6">
            <x-form.input name="nome" label="Nome" :value="$produto->nome" maxlength="200" autofocus class="md:col-span-6" />

            <x-form.input name="sku" label="SKU" :value="$produto->sku" maxlength="20" class="md:col-span-2" />

            <x-form.input name="ean" label="EAN" :value="$produto->ean" maxlength="13" inputmode="numeric" class="md:col-span-2" />

            <x-form.input name="quantidade" label="Quantidade" type="number" min="0"
                          :value="$produto->quantidade" class="md:col-span-2" />

            <x-form.select name="produto_categoria_id" label="Categoria" :opcoes="$categorias"
                           :selected="$produto->produto_categoria_id" class="md:col-span-3" />

            <x-form.select name="produto_status_id" label="Status" :opcoes="$statusProdutos"
                           :selected="$produto->produto_status_id" class="md:col-span-3" />

            <x-form.textarea name="descricao" label="Descrição" :value="$produto->descricao" :rows="4" class="md:col-span-6" />
        </div>

        <div class="flex items-center justify-between border-t border-gray-100 pt-4">
            <div class="flex gap-2">
                <button class="btn">Salvar alterações</button>
                <a href="{{ route('produtos.index') }}" class="btn-sec">Cancelar</a>
            </div>

            <p class="text-xs text-gray-400">
                Criado em {{ $produto->created_at->format('d/m/Y H:i') }} ·
                atualizado em {{ $produto->updated_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </form>
@endsection
