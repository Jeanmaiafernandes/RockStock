@extends('layouts.app')

@section('titulo', 'Status de produto')

@section('conteudo')

    <x-page-header title="Status de produto">
        <a href="{{ route('statusProdutos.create') }}" class="btn">Novo status</a>
    </x-page-header>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Nome</th>
                    <th class="px-4 py-3">Disponível</th>
                    <th class="px-4 py-3">Permite saída</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($statusProdutos as $statusProduto)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <a href="{{ route('statusProdutos.edit', $statusProduto) }}"
                               class="font-medium text-gray-900 hover:text-violet-600">{{ $statusProduto->nome }}</a>
                        </td>
                        <td class="px-4 py-3">
                            <x-status :tone="$statusProduto->disponivel ? 'success' : 'neutral'">
                                {{ $statusProduto->disponivel ? 'Sim' : 'Não' }}
                            </x-status>
                        </td>
                        <td class="px-4 py-3">
                            <x-status :tone="$statusProduto->permite_saida ? 'success' : 'neutral'">
                                {{ $statusProduto->permite_saida ? 'Sim' : 'Não' }}
                            </x-status>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-4">
                                <a href="{{ route('statusProdutos.edit', $statusProduto) }}"
                                   class="text-sm font-medium text-violet-600 hover:underline">Editar</a>
                                <x-form.delete :action="route('statusProdutos.destroy', $statusProduto)" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            Nenhum status cadastrado.
                            <a href="{{ route('statusProdutos.create') }}" class="font-medium text-violet-600 hover:underline">Cadastrar o primeiro</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $statusProdutos->links() }}</div>

@endsection
