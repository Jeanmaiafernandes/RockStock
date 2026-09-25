@extends('layouts.app')

@section('titulo', 'Novo produto')

@section('conteudo')

    <x-page-header title="Novo produto" />

    <form method="POST" action="{{ route('produtos.store') }}" class="max-w-3xl space-y-6">
        @csrf

        <section class="card">
            <h2 class="text-base font-semibold text-gray-900">Dados do produto</h2>
            <p class="mb-5 text-sm text-gray-500">Informações que valem para todas as cores e tamanhos.</p>

            @include('produtos.partials._dados')
        </section>

        <section class="card">
            <h2 class="text-base font-semibold text-gray-900">Grade</h2>
            <p class="mb-5 text-sm text-gray-500">Cada combinação de cor e tamanho vira um SKU. Dá para acrescentar outras depois.</p>

            @include('produtos.partials._grade', ['tamanhos' => $tamanhos])
        </section>

        <div class="flex items-center gap-3">
            <x-primary-button>Cadastrar produto</x-primary-button>
            <a href="{{ route('produtos.index') }}" class="btn-sec">Cancelar</a>
        </div>
    </form>

@endsection
