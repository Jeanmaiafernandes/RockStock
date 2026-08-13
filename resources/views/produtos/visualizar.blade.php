@extends('layouts.app')

@section('titulo', $produto->nome)

@section('acoes')
    <a href="{{ route('produtos.edit', $produto) }}" class="btn">Editar</a>
    <a href="{{ route('produtos.index') }}" class="btn-sec">Voltar</a>
@endsection

@section('conteudo')

    @php
        $nomeStatus = $produto->status->nome ?? 'Sem status';

        $corStatus = fn (string $s) => match (\Illuminate\Support\Str::slug($s)) {
            'ativo', 'disponivel'   => 'bg-emerald-100 text-emerald-700',
            'inativo', 'esgotado'   => 'bg-red-100 text-red-700',
            'pendente', 'reservado' => 'bg-amber-100 text-amber-700',
            default                 => 'bg-gray-100 text-gray-600',
        };

        $campos = [
            'SKU'       => $produto->sku,
            'EAN'       => $produto->ean,
            'Categoria' => $produto->categoria->nome ?? null,
            'Criado em' => $produto->created_at?->format('d/m/Y H:i'),
            'Atualizado' => $produto->updated_at?->format('d/m/Y H:i'),
        ];
    @endphp

    <div class="grid gap-5 lg:grid-cols-3">

        {{-- Coluna principal --}}
        <div class="space-y-5 lg:col-span-2">

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $produto->nome }}</h2>
                        <p class="mt-1 font-mono text-xs text-gray-500">{{ $produto->sku ?: '—' }}</p>
                    </div>

                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $corStatus($nomeStatus) }}">
                        {{ ucfirst($nomeStatus) }}
                    </span>
                </div>

                <dl class="mt-6 grid gap-x-6 gap-y-4 sm:grid-cols-2">
                    @foreach ($campos as $rotulo => $valor)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $rotulo }}</dt>
                            <dd class="mt-0.5 text-sm text-gray-800">{{ $valor ?: '—' }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500">Descrição</h3>
                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-700">
                    {{ $produto->descricao ?: 'Nenhuma descrição cadastrada.' }}
                </p>
            </div>
        </div>

        {{-- Coluna lateral --}}
        <div class="space-y-5">

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500">Estoque</h3>

                <p class="mt-2 text-3xl font-semibold {{ $produto->quantidade > 0 ? 'text-gray-900' : 'text-red-600' }}">
                    {{ $produto->quantidade }}
                    <span class="text-sm font-normal text-gray-500">un.</span>
                </p>

                @if ($produto->quantidade <= 10)
                    <p class="mt-2 inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-700">
                        Estoque baixo
                    </p>
                @endif
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500">Ações</h3>

                <div class="mt-3 flex flex-col gap-2">
                    <a href="{{ route('produtos.edit', $produto) }}" class="btn text-center">Editar produto</a>

                    <form method="POST" action="{{ route('produtos.destroy', $produto) }}"
                          onsubmit="return confirm('Excluir este produto?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn-sec w-full text-red-600 hover:bg-red-50">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
