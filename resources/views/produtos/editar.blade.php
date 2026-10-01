@extends('layouts.app')

@section('titulo', 'Editar produto')

@section('conteudo')

    <x-page-header title="Editar {{ $produto->referencia }}" />

    <form method="POST" action="{{ route('produtos.atualizar', $produto) }}" class="max-w-3xl space-y-6">
        @csrf
        @method('PATCH')

        <section class="card">
            @include('produtos.partials._dados', ['produto' => $produto])

            <p class="mt-5 text-sm text-gray-500">
                Cores e tamanhos são gerenciados no
                <a href="{{ route('produtos.mostrar', $produto) }}" class="font-medium text-violet-600 hover:underline">detalhe do produto</a>.
            </p>
        </section>

        <div class="flex items-center gap-3">
            <x-primary-button>Salvar alterações</x-primary-button>
            <a href="{{ route('produtos.mostrar', $produto) }}" class="btn-sec">Cancelar</a>
        </div>
    </form>

@endsection
