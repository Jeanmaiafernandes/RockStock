@extends('layouts.app')

@section('titulo', 'Nova categoria')

@section('conteudo')
    <form method="POST" action="{{ route('categorias.store') }}" class="card max-w-lg space-y-4">
        @csrf

        <x-form.input name="nome" label="Nome" maxlength="50" autofocus />

        <x-form.checkbox name="ativo" label="Categoria ativa" :checked="true" />

        <div class="flex gap-2">
            <button class="btn">Salvar</button>
            <a href="{{ route('categorias.index') }}" class="btn-sec">Cancelar</a>
        </div>
    </form>
@endsection
