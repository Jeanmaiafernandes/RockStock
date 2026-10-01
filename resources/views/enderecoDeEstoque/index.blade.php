@extends('layouts.app')

@section('titulo', 'Endereços de estoque')

@section('conteudo')

    <x-page-header title="Endereços de estoque" />

    @php
        // Cor do selo de cada tipo
        $coresTipo = [
            'doca'        => 'bg-blue-100 text-blue-700',
            'armazenagem' => 'bg-gray-100 text-gray-700',
            'bloqueado'   => 'bg-amber-100 text-amber-800',
            'avaria'      => 'bg-red-100 text-red-700',
            'devolucao'   => 'bg-violet-100 text-violet-700',
        ];
    @endphp

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-gray-500">O tipo do endereço indica a situação do que está guardado nele.</p>
        <a href="{{ route('enderecoDeEstoque.criar') }}" class="btn">Novo endereço</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Código</th>
                    <th class="px-4 py-3">Local</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3">Situação</th>
                    <th class="px-4 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($enderecos as $endereco)
                    <tr class="hover:bg-gray-50 {{ $endereco->ativo ? '' : 'opacity-60' }}">
                        <td class="px-6 py-3">
                            <a href="{{ route('enderecoDeEstoque.editar', $endereco) }}"
                               class="font-mono font-medium text-gray-900 hover:text-violet-600">{{ $endereco->codigo }}</a>
                        </td>

                        <td class="px-4 py-3 text-gray-500">{{ $endereco->local?->nome }}</td>

                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $coresTipo[$endereco->tipo] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $tipos[$endereco->tipo] ?? $endereco->tipo }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium
                                {{ $endereco->ativo ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $endereco->ativo ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-right">
                            <x-menu-acoes
                                :editar="route('enderecoDeEstoque.editar', $endereco)"
                                :excluir="route('enderecoDeEstoque.excluir', $endereco)" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Nenhum endereço cadastrado.
                            <a href="{{ route('enderecoDeEstoque.criar') }}" class="font-medium text-violet-600 hover:underline">Cadastrar o primeiro</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $enderecos->links() }}
    </div>

@endsection
