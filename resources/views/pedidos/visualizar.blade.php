@extends('layouts.app')

@section('titulo', 'Pedido ' . $pedido->codigo)

@section('acoes')
    <div class="flex gap-2">
        <a href="{{ route('pedidos.edit', $pedido) }}" class="btn-sec">Editar</a>
        <a href="{{ route('pedidos.index') }}" class="btn-sec">Voltar</a>
    </div>
@endsection

@section('conteudo')

    @php
        $status = $pedido->statusPedido instanceof \BackedEnum
            ? $pedido->statusPedido->value
            : (string) $pedido->statusPedido;

        $corStatus = match ($status) {
            'confirmado' => 'bg-emerald-100 text-emerald-700',
            'cancelado'  => 'bg-red-100 text-red-700',
            default      => 'bg-gray-100 text-gray-600',
        };
    @endphp

    {{-- Cabeçalho --}}
    <div class="card grid gap-5 text-sm sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Status</p>
            <span class="mt-1 inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $corStatus }}">
                {{ ucfirst($status) }}
            </span>
        </div>

        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Solicitante</p>
            <p class="mt-1 font-medium text-gray-900">{{ $pedido->user->name }}</p>
        </div>

        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Destino</p>
            <p class="mt-1 font-medium text-gray-900">{{ $pedido->destino }}</p>
        </div>

        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Criado em</p>
            <p class="mt-1 font-medium text-gray-900">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
        </div>

        @if ($pedido->observacao)
            <div class="sm:col-span-2 lg:col-span-4">
                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Observação</p>
                <p class="mt-1 text-gray-700">{{ $pedido->observacao }}</p>
            </div>
        @endif
    </div>

    {{-- Itens --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 px-6 py-4">
            <h2 class="text-sm font-semibold text-gray-800">
                Itens ({{ $pedido->itens->count() }})
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Produto</th>
                    <th class="px-4 py-3">Status do produto</th>
                    <th class="px-4 py-3 text-right">Estoque atual</th>
                    <th class="px-4 py-3 text-right">Quantidade</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($pedido->itens as $item)
                    <tr>
                        <td class="px-6 py-3">
                            <p class="font-medium text-gray-900">{{ $item->produto->nome }}</p>
                            <p class="font-mono text-xs text-gray-400">{{ $item->produto->sku }}</p>
                        </td>

                        <td class="px-4 py-3 text-gray-500">{{ $item->produto->status->nome }}</td>

                        <td class="px-4 py-3 text-right {{ $item->produto->quantidade < $item->quantidade ? 'font-semibold text-red-600' : 'text-gray-500' }}">
                            {{ $item->produto->quantidade }}
                        </td>

                        <td class="px-4 py-3 text-right font-medium text-gray-900">{{ $item->quantidade }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Este pedido não tem itens.</td>
                    </tr>
                @endforelse
                </tbody>

                <tfoot class="bg-gray-50 text-sm font-semibold text-gray-700">
                <tr>
                    <td colspan="3" class="px-6 py-3 text-right">Total de peças</td>
                    <td class="px-4 py-3 text-right">{{ $pedido->itens->sum('quantidade') }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <form method="POST" action="{{ route('pedidos.destroy', $pedido) }}"
          onsubmit="return confirm('Excluir este pedido e todos os seus itens?')">
        @csrf
        @method('DELETE')
        <button class="text-sm font-medium text-red-600 hover:underline">Excluir pedido</button>
    </form>
@endsection
