@extends('layouts.app')

@section('titulo', 'Categorias')

@section('conteudo')

    <x-page-header title="Categorias">
        <a href="{{ route('categoriasProduto.create') }}" class="btn">Nova categoria</a>
    </x-page-header>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Nome</th>
                    <th class="px-4 py-3">Situação</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($categorias as $categoria)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <a href="{{ route('categoriasProduto.edit', $categoria) }}"
                               class="font-medium text-gray-900 hover:text-violet-600">{{ $categoria->nome }}</a>
                        </td>
                        <td class="px-4 py-3">
                            <x-status :tone="$categoria->ativo ? 'success' : 'neutral'">
                                {{ $categoria->ativo ? 'Ativa' : 'Inativa' }}
                            </x-status>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-4">
                                <a href="{{ route('categoriasProduto.edit', $categoria) }}"
                                   class="text-sm font-medium text-violet-600 hover:underline">Editar</a>
                                <x-form.delete :action="route('categoriasProduto.destroy', $categoria)" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                            Nenhuma categoria cadastrada.
                            <a href="{{ route('categoriasProduto.create') }}" class="font-medium text-violet-600 hover:underline">Cadastrar a primeira</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $categorias->links() }}</div>

@endsection
