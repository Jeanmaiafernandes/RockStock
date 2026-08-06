@extends('layouts.app')

@section('titulo', 'Editar categoria')

@section('conteudo')
    <form method="POST" action="{{ route('categorias.update', $categoria) }}" class="card max-w-lg space-y-4">
        @csrf
        @method('PATCH')

        <x-form.input name="nome" label="Nome" :value="$categoria->nome" maxlength="50" autofocus />

        <x-form.checkbox name="ativo" label="Categoria ativa" :checked="$categoria->ativo" />

        <div class="flex gap-2">
            <button class="btn">Salvar alterações</button>
            <a href="{{ route('categorias.index') }}" class="btn-sec">Cancelar</a>
        </div>
    </form>
@endsection
