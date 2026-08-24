@extends('layouts.app')

@section('titulo', 'Fornecedores')

@section('conteudo')

    <x-page-header title="Fornecedores">
        <a href="{{ route('fornecedores.create') }}" class="btn">Novo fornecedor</a>
    </x-page-header>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Nome</th>
                    <th class="px-4 py-3">Contato</th>
                    <th class="px-4 py-3">Situação</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($fornecedores as $fornecedor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <a href="{{ route('fornecedores.edit', $fornecedor) }}"
                               class="font-medium text-gray-900 hover:text-violet-600">{{ $fornecedor->nome }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $fornecedor->contato ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <x-status :tone="$fornecedor->ativo ? 'success' : 'neutral'">
                                {{ $fornecedor->ativo ? 'Ativo' : 'Inativo' }}
                            </x-status>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-4">
                                <a href="{{ route('fornecedores.edit', $fornecedor) }}"
                                   class="text-sm font-medium text-violet-600 hover:underline">Editar</a>
                                <x-form.delete :action="route('fornecedores.destroy', $fornecedor)" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            Nenhum fornecedor cadastrado.
                            <a href="{{ route('fornecedores.create') }}" class="font-medium text-violet-600 hover:underline">Cadastrar o primeiro</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $fornecedores->links() }}</div>

@endsection
