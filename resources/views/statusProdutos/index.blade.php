@extends('layouts.app')

@section('titulo', 'Status de produtos')

@section('acoes')
    <a href="{{ route('statusProdutos.create') }}" class="btn">Novo status</a>
@endsection

@section('conteudo')
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Nome</th>
                    <th class="px-4 py-3">Disponível</th>
                    <th class="px-4 py-3">Permite saída</th>
                    <th class="px-4 py-3">Ações</th>
                    <th class="px-4 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($statusProdutos as $statusProduto)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium text-gray-900">{{ $statusProduto->nome }}</td>

                        <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium
                                    {{ $statusProduto->disponivel ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $statusProduto->disponivel ? 'Sim' : 'Não' }}
                                </span>
                        </td>

                        <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium
                                    {{ $statusProduto->permite_saida ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $statusProduto->permite_saida ? 'Sim' : 'Não' }}
                                </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <x-menu-acoes :editar="route('statusProdutos.edit', $statusProduto)"
                                          :excluir="route('statusProdutos.destroy', $statusProduto)" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Nenhum status cadastrado.
                            <a href="{{ route('statusProdutos.create') }}" class="font-medium text-violet-600 hover:underline">
                                Cadastrar o primeiro
                            </a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $statusProdutos->links() }}
@endsection
