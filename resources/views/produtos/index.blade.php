@extends('layouts.app')

@section('titulo', 'Produtos')

@section('conteudo')

    <x-page-header title="Produtos">
        <a href="{{ route('produtos.create') }}" class="btn">Novo produto</a>
    </x-page-header>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Nome</th>
                    <th class="px-4 py-3">Categoria</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tamanho</th>
                    <th class="px-4 py-3">Endereço</th>
                    <th class="px-4 py-3 text-right">Qtd.</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($produtos as $produto)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <a href="{{ route('produtos.show', $produto) }}"
                               class="font-medium text-gray-900 hover:text-violet-600">{{ $produto->nome }}</a>
                            <p class="font-mono text-xs text-gray-400">{{ $produto->sku }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $produto->categoria->nome ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <x-status :tone="optional($produto->status)->disponivel ? 'success' : 'neutral'">
                                {{ $produto->status->nome ?? '—' }}
                            </x-status>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $produto->tamanho ?? '—' }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $produto->enderecoDeEstoque->codigo ?? '—' }}</td>
                        <td class="px-4 py-3 text-right {{ $produto->quantidade === 0 ? 'font-semibold text-amber-600' : 'text-gray-500' }}">
                            {{ $produto->quantidade }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-4">
                                <a href="{{ route('produtos.show', $produto) }}" class="text-sm font-medium text-violet-600 hover:underline">Ver</a>
                                <a href="{{ route('produtos.edit', $produto) }}" class="text-sm font-medium text-violet-600 hover:underline">Editar</a>
                                <x-form.delete :action="route('produtos.destroy', $produto)" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                            Nenhum produto cadastrado ainda.
                            <a href="{{ route('produtos.create') }}" class="font-medium text-violet-600 hover:underline">Cadastrar o primeiro</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $produtos->links() }}</div>

@endsection
