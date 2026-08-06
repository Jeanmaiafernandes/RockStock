@extends('layouts.app')

@section('titulo', 'Novo produto')

@php
    $categorias = $categorias      ?? \App\Models\ProdutoCategoria::orderBy('nome')->pluck('nome', 'id');
    $statusProdutos = $statusProdutos  ?? \App\Models\ProdutoStatus::orderBy('nome')->pluck('nome', 'id');
@endphp

@section('conteudo')
    <form method="POST" action="{{ route('produtos.store') }}" class="card max-w-3xl space-y-5">
        @csrf

        <div class="grid gap-4 md:grid-cols-6">
            <x-form.input name="nome" label="Nome" maxlength="200" autofocus class="md:col-span-6" />

            <x-form.input name="sku" label="SKU" maxlength="20" class="md:col-span-2" />

            <x-form.input name="ean" label="EAN" maxlength="13" inputmode="numeric" class="md:col-span-2" />

            <x-form.input name="quantidade" label="Quantidade" type="number" min="0" :value="0" class="md:col-span-2" />

            <x-form.select name="produto_categoria_id" label="Categoria" :opcoes="$categorias" class="md:col-span-3" />

            <x-form.select name="produto_status_id" label="Status" :opcoes="$statusProdutos" class="md:col-span-3" />

            <x-form.textarea name="descricao" label="Descrição" :rows="4" class="md:col-span-6" />
        </div>

        <div class="flex gap-2 border-t border-gray-100 pt-4">
            <button class="btn">Salvar</button>
            <a href="{{ route('produtos.index') }}" class="btn-sec">Cancelar</a>
        </div>
    </form>
@endsection
