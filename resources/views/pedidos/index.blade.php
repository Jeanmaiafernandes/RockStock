@extends('layouts.app')

@section('titulo', 'Pedidos')

@section('conteudo')

    @php
        $tonePorStatus = fn ($valor) => match ((string) $valor) {
            'confirmado' => 'success',
            'cancelado'  => 'danger',
            default      => 'neutral',
        };
    @endphp

    <x-page-header title="Pedidos">
        <a href="{{ route('pedidos.create') }}" class="btn">Novo pedido</a>
    </x-page-header>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Código</th>
                    <th class="px-4 py-3">Destino</th>
                    <th class="px-4 py-3">Solicitante</th>
                    <th class="px-4 py-3 text-right">Itens</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($pedidos as $pedido)
                    @php $valorStatus = $pedido->statusPedido->value ?? $pedido->statusPedido; @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <a href="{{ route('pedidos.show', $pedido) }}"
                               class="font-mono text-xs font-medium text-gray-900 hover:text-violet-600">{{ $pedido->codigo }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $pedido->destino }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $pedido->usuario->nome ?? '—' }}</td>
                        <td class="px-4 py-3 text-right text-gray-500">{{ $pedido->itens_count }}</td>
                        <td class="px-4 py-3">
                            <x-status :tone="$tonePorStatus($valorStatus)">{{ ucfirst($valorStatus) }}</x-status>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-4">
                                <a href="{{ route('pedidos.show', $pedido) }}" class="text-sm font-medium text-violet-600 hover:underline">Ver</a>
                                <a href="{{ route('pedidos.edit', $pedido) }}" class="text-sm font-medium text-violet-600 hover:underline">Editar</a>
                                <x-form.delete :action="route('pedidos.destroy', $pedido)" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">Nenhum pedido registrado.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $pedidos->links() }}</div>

@endsection
