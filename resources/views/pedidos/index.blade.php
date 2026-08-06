@extends('layouts.app')

@section('titulo', 'Pedidos')

@section('acoes')
    <a href="{{ route('pedidos.create') }}" class="btn">Novo pedido</a>
@endsection

@section('conteudo')

    @php
        $valorStatus = fn ($pedido) => $pedido->statusPedido instanceof \BackedEnum
            ? $pedido->statusPedido->value
            : (string) $pedido->statusPedido;

        $corStatus = fn (string $s) => match ($s) {
            'confirmado' => 'bg-emerald-100 text-emerald-700',
            'cancelado'  => 'bg-red-100 text-red-700',
            default      => 'bg-gray-100 text-gray-600',
        };
    @endphp

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto md:overflow-visible">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Código</th>
                    <th class="px-4 py-3">Destino</th>
                    <th class="px-4 py-3">Solicitante</th>
                    <th class="px-4 py-3 text-right">Itens</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Criado</th>
                    <th class="px-4 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($pedidos as $pedido)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <a href="{{ route('pedidos.show', $pedido) }}"
                               class="font-mono text-xs font-medium text-gray-900 hover:text-violet-600">
                                {{ $pedido->codigo }}
                            </a>
                        </td>

                        <td class="px-4 py-3 text-gray-700">{{ $pedido->destino }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $pedido->user->name }}</td>
                        <td class="px-4 py-3 text-right text-gray-500">{{ $pedido->itens_count }}</td>

                        <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $corStatus($valorStatus($pedido)) }}">
                                    {{ ucfirst($valorStatus($pedido)) }}
                                </span>
                        </td>

                        <td class="px-4 py-3 text-right text-gray-500">{{ $pedido->created_at->format('d/m/Y') }}</td>

                        <td class="px-4 py-3 text-right">
                            <x-menu-acoes :ver="route('pedidos.show', $pedido)"
                                          :editar="route('pedidos.edit', $pedido)"
                                          :excluir="route('pedidos.destroy', $pedido)" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                            Nenhum pedido registrado.
                            <a href="{{ route('pedidos.create') }}" class="font-medium text-violet-600 hover:underline">
                                Criar o primeiro
                            </a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $pedidos->links() }}
@endsection
