@extends('layouts.app')

@section('titulo', 'Categorias')

@section('acoes')
    <a href="{{ route('categorias.create') }}" class="btn">Nova categoria</a>
@endsection

@section('conteudo')
    <div class="overflow-x-auto rounded border bg-white">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-2 font-medium">Nome</th>
                <th class="px-4 py-2 font-medium">Situação</th>
                <th class="px-4 py-2"></th>
            </tr>
            </thead>
            <tbody class="divide-y">
            @forelse ($categorias as $categoria)
                <tr>
                    <td class="px-4 py-2">{{ $categoria->nome }}</td>
                    <td class="px-4 py-2">
                            <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium
                                {{ $categoria->ativo ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $categoria->ativo ? 'Ativa' : 'Inativa' }}
                            </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <x-menu-acoes :editar="route('categorias.edit', $categoria)"
                                      :excluir="route('categorias.destroy', $categoria)" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                        Nenhuma categoria cadastrada.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $categorias->links() }}
@endsection
