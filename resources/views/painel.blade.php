@extends('layouts.app')

@section('titulo', 'Painel')

@section('conteudo')

    @php
        $ultimosProdutos = $ultimosProdutos ?? \App\Models\Produto::with(['categoria', 'status'])
            ->latest()
            ->take(5)
            ->get();

        $ultimosPedidos = $ultimosPedidos ?? \App\Models\Pedido::with('usuario')
            ->withCount('itens')
            ->latest()
            ->take(5)
            ->get();
    @endphp

    {{-- Ações rápidas --}}
    <div class="card">
        <h2 class="text-sm font-semibold text-gray-800">Ações rápidas</h2>

        <div class="mt-4 flex flex-wrap gap-3">
            <a href="{{ route('pedidos.create') }}" class="btn">Novo pedido</a>
            <a href="{{ route('produtos.create') }}" class="btn-sec">Novo produto</a>
            <a href="{{ route('categorias.create') }}" class="btn-sec">Nova categoria</a>
            <a href="{{ route('statusProdutos.create') }}" class="btn-sec">Novo status</a>
        </div>
    </div>

    {{-- Últimos produtos --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <h2 class="text-sm font-semibold text-gray-800">Últimos produtos cadastrados</h2>
            <a href="{{ route('produtos.index') }}" class="text-sm font-medium text-violet-600 hover:underline">Ver todos</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Nome</th>
                    <th class="px-4 py-3">Categoria</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Qtd.</th>
                    <th class="px-4 py-3 text-right">Cadastrado</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($ultimosProdutos as $produto)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <a href="{{ route('produtos.edit', $produto) }}"
                               class="font-medium text-gray-900 hover:text-violet-600">{{ $produto->nome }}</a>
                            <p class="font-mono text-xs text-gray-400">{{ $produto->sku }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $produto->categoria->nome }}</td>
                        <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium
                                    {{ $produto->status->disponivel
                                        ? 'bg-emerald-100 text-emerald-700'
                                        : 'bg-gray-100 text-gray-600' }}">
                                    {{ $produto->status->nome }}
                                </span>
                        </td>
                        <td class="px-4 py-3 text-right {{ $produto->quantidade === 0 ? 'font-semibold text-amber-600' : 'text-gray-500' }}">
                            {{ $produto->quantidade }}
                        </td>
                        <td class="px-4 py-3 text-right text-gray-500">{{ $produto->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Nenhum produto cadastrado ainda.
                            <a href="{{ route('produtos.create') }}" class="font-medium text-violet-600 hover:underline">Cadastrar o primeiro</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Últimos pedidos --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <h2 class="text-sm font-semibold text-gray-800">Pedidos recentes</h2>
            <a href="{{ route('pedidos.index') }}" class="text-sm font-medium text-violet-600 hover:underline">Ver todos</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-6 py-3">Código</th>
                    <th class="px-4 py-3">Destino</th>
                    <th class="px-4 py-3">Solicitante</th>
                    <th class="px-4 py-3 text-right">Itens</th>
                    <th class="px-4 py-3 text-right">Status</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse ($ultimosPedidos as $pedido)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <a href="{{ route('pedidos.show', $pedido) }}"
                               class="font-mono text-xs font-medium text-gray-900 hover:text-violet-600">{{ $pedido->codigo }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $pedido->destino }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $pedido->usuario->nome }}</td>
                        <td class="px-4 py-3 text-right text-gray-500">{{ $pedido->itens_count }}</td>
                        <td class="px-4 py-3 text-right">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium
                                    {{ match ((string) ($pedido->statusPedido->value ?? $pedido->statusPedido)) {
                                        'confirmado' => 'bg-emerald-100 text-emerald-700',
                                        'cancelado'  => 'bg-red-100 text-red-700',
                                        default      => 'bg-gray-100 text-gray-600',
                                    } }}">
                                    {{ ucfirst($pedido->statusPedido->value ?? $pedido->statusPedido) }}
                                </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">Nenhum pedido registrado.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
