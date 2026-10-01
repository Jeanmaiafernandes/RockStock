@extends('layouts.app')

@section('titulo', 'Nova categoria')

@section('conteudo')

    <x-page-header title="Nova categoria" />

    <div class="card max-w-2xl">
        <form action="{{ route('categoriasProduto.salvar') }}" method="POST" class="space-y-5">
            @csrf

            <x-form.field label="Nome" name="nome">
                <x-form.input name="nome" :value="old('nome')" maxlength="50" placeholder="Couro e jaquetas" />
            </x-form.field>

            <x-form.field name="ativo">
                <input type="hidden" name="ativo" value="0">
                <x-form.checkbox name="ativo" label="Categoria ativa" :checked="old('ativo', true)" />
            </x-form.field>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Salvar categoria</x-primary-button>
                <a href="{{ route('categoriasProduto.index') }}" class="btn-sec">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
