@extends('layouts.app')

@section('titulo', 'Locais de estoque')

@section('conteudo')

    <x-page-header title="Locais de estoque" />

    <div class="mb-4 text-right">
        <a href="{{ route('locaisEstoque.criar') }}" class="btn">Novo local</a>
    </div>

    <div class="card overflow-x-auto p-0">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
            <tr>
                <th class="px-6 py-3">Nome</th>
                <th class="px-4 py-3">Tipo</th>
                <th class="px-4 py-3">Endereços</th>
                <th class="px-4 py-3">Situação</th>
                <th class="px-4 py-3"></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($locais as $local)
                <tr class="border-t border-gray-100">
                    <td class="px-6 py-3 font-medium text-gray-900">{{ $local->nome }}</td>
                    <td class="px-4 py-3">{{ $local->tipo->rotulo() }}</td>
                    <td class="px-4 py-3">{{ $local->enderecos_count }}</td>
                    <td class="px-4 py-3">{{ $local->ativo ? 'Ativo' : 'Inativo' }}</td>
                    <td class="px-4 py-3 text-right">
                        <x-menu-acoes
                            :editar="route('locaisEstoque.editar', $local)"
                            :excluir="route('locaisEstoque.excluir', $local)" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">Nenhum local cadastrado.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $locais->links() }}
    </div>

@endsection
