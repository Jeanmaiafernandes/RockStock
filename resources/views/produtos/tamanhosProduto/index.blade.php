@extends('layouts.app')

@section('titulo', 'Tamanhos')

@section('conteudo')

    <x-page-header title="Tamanhos" />

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-gray-500">A ordem define como os tamanhos aparecem na grade dos produtos.</p>
        <a href="{{ route('tamanhos.create') }}" class="btn">Novo tamanho</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Ordem</th>
                    <th class="px-4 py-3">Tamanho</th>
                    <th class="px-4 py-3 text-right">SKUs</th>
                    <th class="px-4 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($tamanhos as $tamanho)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-gray-500">{{ $tamanho->ordem }}</td>

                        <td class="px-4 py-3">
                            <a href="{{ route('tamanhos.edit', $tamanho) }}"
                               class="font-medium text-gray-900 hover:text-violet-600">{{ $tamanho->nome }}</a>
                        </td>

                        <td class="px-4 py-3 text-right text-gray-700">{{ $tamanho->variacoes_count }}</td>

                        <td class="px-4 py-3 text-right">
                            @if ($tamanho->variacoes_count === 0)
                                <x-menu-acoes
                                    :editar="route('tamanhos.edit', $tamanho)"
                                    :excluir="route('tamanhos.destroy', $tamanho)" />
                            @else
                                <x-menu-acoes :editar="route('tamanhos.edit', $tamanho)" />
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            Nenhum tamanho cadastrado.
                            <a href="{{ route('tamanhos.create') }}" class="font-medium text-violet-600 hover:underline">Cadastrar o primeiro</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $tamanhos->links() }}
    </div>

@endsection
