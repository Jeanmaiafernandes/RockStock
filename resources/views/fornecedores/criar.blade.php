@extends('layouts.app')

@section('titulo', 'Novo fornecedor')

@section('conteudo')

    <x-page-header title="Novo fornecedor" />

    <div class="card max-w-2xl">
        <form action="{{ route('fornecedores.store') }}" method="POST" class="space-y-5">
            @csrf

            <x-form.field label="Nome" name="nome">
                <x-form.input name="nome" :value="old('nome')" placeholder="Brechó Estação Rock" />
            </x-form.field>

            <x-form.field label="Contato" name="contato" hint="Telefone, e-mail ou responsável.">
                <x-form.input name="contato" :value="old('contato')" placeholder="(11) 90000-0000" />
            </x-form.field>

            <x-form.field name="ativo">
                <input type="hidden" name="ativo" value="0">
                <x-form.checkbox name="ativo" label="Fornecedor ativo" :checked="old('ativo', true)" />
            </x-form.field>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Salvar fornecedor</x-primary-button>
                <a href="{{ route('fornecedores.index') }}" class="btn-sec">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
