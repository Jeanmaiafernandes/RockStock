@extends('layouts.app')

@section('titulo', 'Editar local de estoque')

@section('conteudo')

    <x-page-header title="Editar local de estoque" />

    <form method="POST" action="{{ route('locaisEstoque.atualizar', $localEstoque) }}" class="card max-w-2xl space-y-5">
        @csrf
        @method('PUT')

        <x-form.field label="Nome" name="nome">
            <x-form.input name="nome" :value="old('nome', $localEstoque->nome)" maxlength="100" required />
        </x-form.field>

        <x-form.field label="Tipo" name="tipo">
            <x-form.select name="tipo" :options="$tipos" :selected="old('tipo', $localEstoque->tipo->value)" required />
        </x-form.field>

        <x-form.field name="ativo">
            <input type="hidden" name="ativo" value="0">
            <x-form.checkbox name="ativo" value="1" label="Local ativo" :checked="(bool) old('ativo', $localEstoque->ativo)" />
        </x-form.field>

        <div class="flex gap-3">
            <x-primary-button>Salvar</x-primary-button>
            <a href="{{ route('locaisEstoque.index') }}" class="btn-sec">Cancelar</a>
        </div>
    </form>

@endsection
