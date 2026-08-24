@extends('layouts.app')

@section('titulo', 'Pedido')

@section('conteudo')

    @php
        $valorStatus = $pedido->statusPedido->value ?? $pedido->statusPedido;
        $tone = match ((string) $valorStatus) {
            'confirmado' => 'success',
            'cancelado'  => 'danger',
            default      => 'neutral',
        };
    @endphp

    <x-page-header :title="'Pedido '.$pedido->codigo">
        <a href="{{ route('pedidos.edit', $pedido) }}" class="btn">Editar</a>
        <a href="{{ route('pedidos.index') }}" class="btn-sec">Voltar</a>
    </x-page-header>

    {{-- Resumo --}}
    <div class="card mb-6">
        <dl class="grid grid-cols-2 gap-x-8 gap-y-5 sm:grid-cols-4">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">Código</dt>
                <dd class="mt-1 font-mono text-sm text-gray-900">{{ $pedido->codigo }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">Destino</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $pedido->destino }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">Solicitante</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $pedido->user->name ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">Status</dt>
                <dd class="mt-1"><x-status :tone="$tone">{{ ucfirst($valorStatus) }}</x-status></dd>
            </div>
        </dl>
    </div>

    {{-- Itens --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 px-6 py-4">
            <h2 class="text-sm font-semibold text-gray-800">Itens do pedido</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Produto</th>
                    <th class="px-4 py-3 text-right">Quantidade</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($pedido->itens as $item)
                    <tr>
                        <td class="px-6 py-3 text-gray-900">
                            {{ $item->produto->nome ?? '—' }}
                            <span class="font-mono text-xs text-gray-400">{{ $item->produto->sku ?? '' }}</span>
                        </td>
                        <td class="px-4 py-3 text-right text-gray-500">{{ $item->quantidade }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-10 text-center text-gray-500">Este pedido não tem itens.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
