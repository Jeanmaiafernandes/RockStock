@extends('layouts.app')

@section('titulo', 'Editar endereço de estoque')

@section('conteudo')

    @php
        $tiposOpcoes = collect($tipos ?? $tipo ?? \App\Models\EnderecoDeEstoque::TIPOS)
            ->mapWithKeys(fn ($t) => [$t => \Illuminate\Support\Str::ucfirst($t)])
            ->all();
    @endphp

    <x-page-header :title="'Editar: '.$enderecoDeEstoque->codigo" />

    <div class="card max-w-2xl">
        <form action="{{ route('enderecoDeEstoque.update', $enderecoDeEstoque) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <x-form.field label="Código" name="codigo">
                <x-form.input name="codigo" :value="old('codigo', $enderecoDeEstoque->codigo)" />
            </x-form.field>

            <x-form.field label="Tipo" name="tipo">
                <x-form.select
                    name="tipo"
                    :options="$tiposOpcoes"
                    :selected="old('tipo', $enderecoDeEstoque->tipo)"
                    placeholder="Selecione…"
                    required
                />
            </x-form.field>

            <x-form.field name="bloqueado">
                <input type="hidden" name="bloqueado" value="0">
                <x-form.checkbox name="bloqueado" label="Endereço bloqueado" :checked="old('bloqueado', $enderecoDeEstoque->bloqueado)" />
            </x-form.field>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Salvar alterações</x-primary-button>
                <a href="{{ route('enderecoDeEstoque.index') }}" class="btn-sec">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
