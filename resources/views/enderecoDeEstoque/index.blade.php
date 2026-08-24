@extends('layouts.app')

@section('titulo', 'Endereços de estoque')

@section('conteudo')

    <x-page-header title="Endereços de estoque">
        <a href="{{ route('enderecoDeEstoque.create') }}" class="btn">Novo endereço</a>
    </x-page-header>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Código</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3">Situação</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($enderecoDeEstoque as $endereco)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <a href="{{ route('enderecoDeEstoque.edit', $endereco) }}"
                               class="font-mono font-medium text-gray-900 hover:text-violet-600">{{ $endereco->codigo }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $endereco->tipo ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <x-status :tone="$endereco->bloqueado ? 'danger' : 'success'">
                                {{ $endereco->bloqueado ? 'Bloqueado' : 'Livre' }}
                            </x-status>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-4">
                                <a href="{{ route('enderecoDeEstoque.edit', $endereco) }}"
                                   class="text-sm font-medium text-violet-600 hover:underline">Editar</a>
                                <x-form.delete :action="route('enderecoDeEstoque.delete', $endereco)" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            Nenhum endereço cadastrado.
                            <a href="{{ route('enderecoDeEstoque.create') }}" class="font-medium text-violet-600 hover:underline">Cadastrar o primeiro</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $enderecoDeEstoque->links() }}</div>

@endsection
