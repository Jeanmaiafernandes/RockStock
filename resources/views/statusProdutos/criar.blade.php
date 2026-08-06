@extends('layouts.app')

@section('titulo', 'Novo status')

@section('conteudo')
    <form method="POST" action="{{ route('statusProdutos.store') }}" class="card max-w-lg space-y-5">
        @csrf

        <x-form.input name="nome" label="Nome" maxlength="50" autofocus />

        <div class="space-y-3 border-t border-gray-100 pt-4">
            <x-form.checkbox name="disponivel" label="Disponível" :checked="true" />
            <p class="-mt-2 pl-6 text-xs text-gray-500">
                Produtos com este status aparecem como ativos nas listagens.
            </p>

            <x-form.checkbox name="permite_saida" label="Permite saída" :checked="true" />
            <p class="-mt-2 pl-6 text-xs text-gray-500">
                Produtos com este status podem ser incluídos em pedidos.
            </p>
        </div>

        <div class="flex gap-2">
            <button class="btn">Salvar</button>
            <a href="{{ route('statusProdutos.index') }}" class="btn-sec">Cancelar</a>
        </div>
    </form>
@endsection
