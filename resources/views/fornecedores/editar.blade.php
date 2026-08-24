@extends('layouts.app')

@section('titulo', 'Editar fornecedor')

@section('conteudo')

    <x-page-header :title="'Editar: '.$fornecedor->nome" />

    <div class="card max-w-2xl">
        <form action="{{ route('fornecedores.update', $fornecedor) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <x-form.field label="Nome" name="nome">
                <x-form.input name="nome" :value="old('nome', $fornecedor->nome)" />
            </x-form.field>

            <x-form.field label="Contato" name="contato" hint="Telefone, e-mail ou responsável.">
                <x-form.input name="contato" :value="old('contato', $fornecedor->contato)" />
            </x-form.field>

            <x-form.field name="ativo">
                <input type="hidden" name="ativo" value="0">
                <x-form.checkbox name="ativo" label="Fornecedor ativo" :checked="old('ativo', $fornecedor->ativo)" />
            </x-form.field>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Salvar alterações</x-primary-button>
                <a href="{{ route('fornecedores.index') }}" class="btn-sec">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
