@extends('layouts.app')

@section('titulo', 'Produtos')

@section('conteudo')

    <x-page-header title="Produtos" />

    @php
        $campo = 'rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500';
        $filtrando = collect(request()->only(['busca', 'categoria', 'fornecedor', 'status']))->filter()->isNotEmpty();
    @endphp

    <div class="mb-4 flex flex-wrap items-end justify-between gap-4">
        <form method="GET" action="{{ route('produtos.index') }}" class="flex flex-wrap items-end gap-2">
            <input type="search" name="busca" value="{{ request('busca') }}"
                   placeholder="Referência ou nome" aria-label="Buscar por referência ou nome"
                   class="{{ $campo }} w-56">

            <select name="categoria" aria-label="Categoria" class="{{ $campo }}">
                <option value="">Todas as categorias</option>
                @foreach ($categorias as $id => $nome)
                    <option value="{{ $id }}" @selected((string) request('categoria') === (string) $id)>{{ $nome }}</option>
                @endforeach
            </select>

            <select name="fornecedor" aria-label="Fornecedor" class="{{ $campo }}">
                <option value="">Todos os fornecedores</option>
                @foreach ($fornecedores as $id => $nome)
                    <option value="{{ $id }}" @selected((string) request('fornecedor') === (string) $id)>{{ $nome }}</option>
                @endforeach
            </select>

            <select name="status" aria-label="Status" class="{{ $campo }}">
                <option value="">Todos os status</option>
                @foreach ($status as $id => $nome)
                    <option value="{{ $id }}" @selected((string) request('status') === (string) $id)>{{ $nome }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-sec">Filtrar</button>

            @if ($filtrando)
                <a href="{{ route('produtos.index') }}" class="text-sm text-gray-500 hover:underline">Limpar</a>
            @endif
        </form>

        <a href="{{ route('produtos.criar') }}" class="btn">Novo produto</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Referência</th>
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-4 py-3">Categoria</th>
                    <th class="px-4 py-3">Fornecedor</th>
                    <th class="px-4 py-3">Coleção</th>
                    <th class="px-4 py-3 text-right">SKUs</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($produtos as $produto)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <a href="{{ route('produtos.mostrar', $produto) }}"
                               class="font-mono font-medium text-gray-900 hover:text-violet-600">{{ $produto->referencia }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-900">{{ $produto->nome }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $produto->categoria?->nome }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $produto->fornecedor?->nome }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $produto->colecao ?? '—' }}</td>
                        <td class="px-4 py-3 text-right text-gray-700">{{ $produto->variacoes_count }}</td>
                        <td class="px-4 py-3">
                            <x-status :tone="optional($produto->status)->disponivel ? 'success' : 'neutral'">
                                {{ $produto->status->nome ?? '—' }}
                            </x-status>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <x-menu-acoes
                                :ver="route('produtos.mostrar', $produto)"
                                :editar="route('produtos.editar', $produto)" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                            @if ($filtrando)
                                Nenhum produto encontrado com esses filtros.
                                <a href="{{ route('produtos.index') }}" class="font-medium text-violet-600 hover:underline">Limpar filtros</a>
                            @else
                                Nenhum produto cadastrado.
                                <a href="{{ route('produtos.criar') }}" class="font-medium text-violet-600 hover:underline">Cadastrar o primeiro</a>
                            @endif
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $produtos->links() }}
    </div>

@endsection
