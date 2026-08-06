@extends('layouts.app')

@section('titulo', 'Produtos')

@section('acoes')
    <a href="{{ route('produtos.create') }}" class="btn">Novo produto</a>
@endsection

@section('conteudo')

    @php
        $categorias      = $categorias      ?? \App\Models\ProdutoCategoria::orderBy('nome')->pluck('nome', 'id');
        $statusProdutos  = $statusProdutos  ?? \App\Models\ProdutoStatus::orderBy('nome')->pluck('nome', 'id');
    @endphp

    {{-- Filtros --}}
    <form method="GET" class="card">
        <div class="grid gap-4 md:grid-cols-4">
            <x-form.input name="busca" label="Buscar" placeholder="Nome, SKU ou EAN"
                          :value="request('busca')" class="md:col-span-2" />

            <x-form.select name="categoria" label="Categoria" :opcoes="$categorias"
                           :selected="request('categoria')" placeholder="Todas" />

            <x-form.select name="status" label="Status" :opcoes="$statusProdutos"
                           :selected="request('status')" placeholder="Todos" />
        </div>

        <div class="mt-4 flex items-center gap-3">
            <button class="btn">Filtrar</button>

            @if (request()->hasAny(['busca', 'categoria', 'status']))
                <a href="{{ route('produtos.index') }}" class="text-sm text-gray-500 hover:underline">Limpar filtros</a>
            @endif
        </div>
    </form>

    {{-- Listagem --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Produto</th>
                    <th class="px-4 py-3">Categoria</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Quantidade</th>
                    <th class="px-4 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($produtos as $produto)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <a href="{{ route('produtos.edit', $produto) }}"
                               class="font-medium text-gray-900 hover:text-violet-600">{{ $produto->nome }}</a>

                            <p class="font-mono text-xs text-gray-400">
                                {{ $produto->sku }}@if ($produto->ean) · {{ $produto->ean }}@endif
                            </p>
                        </td>

                        <td class="px-4 py-3 text-gray-500">{{ $produto->categoria->nome }}</td>

                        <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium
                                    {{ $produto->status->disponivel ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $produto->status->nome }}
                                </span>
                        </td>

                        <td class="px-4 py-3 text-right {{ $produto->quantidade === 0 ? 'font-semibold text-amber-600' : 'text-gray-700' }}">
                            {{ $produto->quantidade }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            <x-menu-acoes
                                :ver="route('produtos.show', $produto)"
                                :editar="route('produtos.edit', $produto)"
                                :excluir="route('produtos.destroy', $produto)" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            @if (request()->hasAny(['busca', 'categoria', 'status']))
                                Nenhum produto encontrado com esses filtros.
                                <a href="{{ route('produtos.index') }}" class="font-medium text-violet-600 hover:underline">Limpar</a>
                            @else
                                Nenhum produto cadastrado.
                                <a href="{{ route('produtos.create') }}" class="font-medium text-violet-600 hover:underline">Cadastrar o primeiro</a>
                            @endif
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $produtos->withQueryString()->links() }}
@endsection
