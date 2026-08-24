@extends('layouts.app')

@section('titulo', 'Produto')

@section('conteudo')

    {{-- controller: view('produtos.visualizar', compact('produto')) --}}
    <x-page-header :title="$produto->nome">
        <a href="{{ route('produtos.edit', $produto) }}" class="btn">Editar</a>
        <a href="{{ route('produtos.index') }}" class="btn-sec">Voltar</a>
    </x-page-header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="card">
                <dl class="grid grid-cols-1 gap-x-8 gap-y-5 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">SKU</dt>
                        <dd class="mt-1 font-mono text-sm text-gray-900">{{ $produto->sku }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">Tamanho</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $produto->tamanho ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">Categoria</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $produto->categoria->nome ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">Status</dt>
                        <dd class="mt-1">
                            <x-status :tone="optional($produto->status)->disponivel ? 'success' : 'neutral'">
                                {{ $produto->status->nome ?? '—' }}
                            </x-status>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">Fornecedor</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $produto->fornecedor->nome ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">Endereço de estoque</dt>
                        <dd class="mt-1 font-mono text-sm text-gray-900">{{ $produto->enderecoDeEstoque->codigo ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">Quantidade em estoque</dt>
                        <dd class="mt-1 text-sm {{ $produto->quantidade === 0 ? 'font-semibold text-amber-600' : 'text-gray-900' }}">
                            {{ $produto->quantidade }}
                        </dd>
                    </div>
                </dl>

                @if (! empty($produto->descricao))
                    <div class="mt-6 border-t border-gray-100 pt-5">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">Descrição</dt>
                        <dd class="mt-1.5 text-sm leading-relaxed text-gray-600">{{ $produto->descricao }}</dd>
                    </div>
                @endif
            </div>
        </div>

        <aside>
            <div class="card">
                <h2 class="text-sm font-semibold text-gray-800">Ações</h2>
                <div class="mt-4 flex flex-col gap-3">
                    <a href="{{ route('produtos.edit', $produto) }}" class="btn">Editar produto</a>
                    <a href="{{ route('produtos.index') }}" class="btn-sec">Voltar à lista</a>
                    <div class="pt-1">
                        <x-form.delete :action="route('produtos.destroy', $produto)">Excluir produto</x-form.delete>
                    </div>
                </div>
            </div>
        </aside>
    </div>

@endsection
