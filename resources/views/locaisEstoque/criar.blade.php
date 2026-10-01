@extends('layouts.app')

@section('titulo', 'Novo local de estoque')

@section('conteudo')

    <x-page-header title="Novo local de estoque" />

    <form method="POST" action="{{ route('locaisEstoque.salvar') }}" class="card max-w-2xl space-y-5">
        @csrf

        <x-form.field label="Nome" name="nome">
            <x-form.input name="nome" :value="old('nome')" maxlength="100" required />
        </x-form.field>

        <x-form.field label="Tipo" name="tipo">
            <x-form.select name="tipo" :options="$tipos" :selected="old('tipo')" required />
        </x-form.field>

        <x-form.field name="ativo">
            <input type="hidden" name="ativo" value="0">
            <x-form.checkbox name="ativo" value="1" label="Local ativo" :checked="(bool) old('ativo', true)" />
        </x-form.field>

        <div class="flex gap-3">
            <x-primary-button>Cadastrar</x-primary-button>
            <a href="{{ route('locaisEstoque.index') }}" class="btn-sec">Cancelar</a>
        </div>
    </form>

@endsection
