@extends('layouts.app')

@section('titulo', $produto->referencia)

@section('conteudo')

    @php
        $variacoes = $produto->variacoes;

        // Colunas: só os tamanhos usados pelo produto, na ordem cadastrada
        $colunas = $variacoes->pluck('tamanho')->unique('id')->sortBy('ordem')->values();
        // Linhas: as cores, na ordem em que foram criadas
        $linhas = $variacoes->pluck('cor')->unique()->values();
        // Acesso rápido à célula: "cor|tamanho_id" => variação
        $celulas = $variacoes->keyBy(fn ($v) => $v->cor . '|' . $v->tamanho_id);

        $ativas = $variacoes->where('ativo', true)->count();

        $dadosModal = fn ($v) => [
            'id'      => $v->id,
            'url'     => route('variacoes.update', $v),
            'sku'     => $v->sku,
            'cor'     => $v->cor,
            'tamanho' => $v->tamanho->nome,
            'ean'     => $v->ean,
            'ativo'   => (bool) $v->ativo,
        ];

        // Reabre o modal com os valores digitados se a validação falhou
        $modalInicial = null;
        if (old('variacao_id') && ($comErro = $variacoes->firstWhere('id', (int) old('variacao_id')))) {
            $modalInicial = array_merge($dadosModal($comErro), [
                'ean'   => old('ean'),
                'ativo' => (bool) old('ativo'),
            ]);
        }

        $gradeComErro = $errors->hasAny(['cores', 'cores.*', 'tamanhos', 'tamanhos.*']);
    @endphp

    <div x-data="{ modal: @js($modalInicial) }">

        <x-page-header :title="$produto->nome" />

        <div class="mb-6 flex flex-wrap items-center gap-3">
            <a href="{{ route('produtos.editar', $produto) }}" class="btn">Editar dados</a>
            <a href="{{ route('produtos.index') }}" class="btn-sec">Voltar</a>
        </div>

        {{-- Dados --}}
        <section class="card mb-6">
            <dl class="grid gap-x-6 gap-y-4 text-sm sm:grid-cols-3">
                <div>
                    <dt class="text-gray-500">Referência</dt>
                    <dd class="font-mono font-medium text-gray-900">{{ $produto->referencia }}</dd>
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
                    <dt class="text-gray-500">Coleção</dt>
                    <dd class="text-gray-900">{{ $produto->colecao ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Categoria</dt>
                    <dd class="text-gray-900">{{ $produto->categoria?->nome }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Fornecedor</dt>
                    <dd class="text-gray-900">{{ $produto->fornecedor?->nome }}</dd>
                </div>
                @if ($produto->descricao)
                    <div class="sm:col-span-3">
                        <dt class="text-gray-500">Descrição</dt>
                        <dd class="whitespace-pre-line text-gray-900">{{ $produto->descricao }}</dd>
                    </div>
                @endif
            </dl>
        </section>

        {{-- Matriz da grade --}}
        <section class="card mb-6">
            <div class="mb-4 flex flex-wrap items-baseline justify-between gap-2">
                <h2 class="text-base font-semibold text-gray-900">Grade</h2>
                <p class="text-sm text-gray-500">
                    {{ $variacoes->count() }} SKU(s), {{ $ativas }} ativo(s). Clique numa célula para editar.
                </p>
            </div>

            @if ($variacoes->isEmpty())
                <p class="py-6 text-center text-sm text-gray-500">Este produto ainda não tem variações. Adicione cores e tamanhos abaixo.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate border-spacing-1 text-sm">
                        <thead>
                        <tr>
                            <th class="px-2 py-1 text-left text-xs font-medium text-gray-500">Cor</th>
                            @foreach ($colunas as $tamanho)
                                <th class="px-2 py-1 text-center text-xs font-medium text-gray-500">{{ $tamanho->nome }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($linhas as $cor)
                            <tr>
                                <th class="whitespace-nowrap px-2 py-1 text-left font-medium text-gray-900">{{ $cor }}</th>
                                @foreach ($colunas as $tamanho)
                                    @php $v = $celulas->get($cor . '|' . $tamanho->id); @endphp
                                    <td class="p-0">
                                        @if ($v)
                                            <button type="button" @click="modal = @js($dadosModal($v))"
                                                    class="w-full min-w-[7rem] rounded-lg border px-2 py-2 text-left transition
                                                           focus:outline-none focus-visible:ring-2 focus-visible:ring-violet-500
                                                           {{ $v->ativo ? 'border-gray-200 bg-white hover:border-violet-400' : 'border-dashed border-gray-300 bg-gray-50 hover:border-gray-400' }}">
                                                <span class="block truncate font-mono text-xs {{ $v->ativo ? 'text-gray-700' : 'text-gray-400 line-through' }}">{{ $v->sku }}</span>
                                                <span class="block text-xs {{ $v->ean ? 'text-gray-500' : 'text-amber-600' }}">
                                                    {{ $v->ativo ? ($v->ean ?? 'Sem EAN') : 'Inativo' }}
                                                </span>
                                            </button>
                                        @else
                                            <span class="block rounded-lg px-2 py-2 text-center text-gray-300" aria-label="Combinação não existe">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        {{-- Adicionar à grade --}}
        <section class="card" x-data="{ aberto: @js($gradeComErro || $variacoes->isEmpty()) }">
            <button type="button" @click="aberto = !aberto" :aria-expanded="aberto.toString()"
                    class="flex w-full items-center justify-between text-left">
                <span>
                    <span class="block text-base font-semibold text-gray-900">Adicionar à grade</span>
                    <span class="block text-sm text-gray-500">Combinações que já existem são ignoradas.</span>
                </span>
                <svg class="h-5 w-5 text-gray-400 transition" :class="aberto && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>

            <form x-show="aberto" @unless ($gradeComErro || $variacoes->isEmpty()) style="display: none" @endunless
            method="POST" action="{{ route('grade.store', $produto) }}" class="mt-5 space-y-5">
                @csrf

                @include('produtos.partials._grade', [
                    'tamanhos'       => $tamanhos,
                    'referenciaFixa' => $produto->referencia,
                    'skusExistentes' => $variacoes->pluck('sku')->all(),
                ])

                <x-primary-button>Adicionar SKUs</x-primary-button>
            </form>
        </section>

        {{-- Modal de edição da variação --}}
        <div x-show="modal" style="display: none"
             class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4"
             @keydown.escape.window="modal = null"
             role="dialog" aria-modal="true" aria-labelledby="titulo-variacao">
            <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl" @click.outside="modal = null">
                <template x-if="modal">
                    <form method="POST" :action="modal.url" class="space-y-5">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="variacao_id" :value="modal.id">

                        <div>
                            <h3 id="titulo-variacao" class="text-base font-semibold text-gray-900">Editar variação</h3>
                            <p class="font-mono text-sm text-gray-500" x-text="modal.sku"></p>
                        </div>

                        <dl class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <dt class="text-gray-500">Cor</dt>
                                <dd class="text-gray-900" x-text="modal.cor"></dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Tamanho</dt>
                                <dd class="text-gray-900" x-text="modal.tamanho"></dd>
                            </div>
                        </dl>

                        <div>
                            <label for="ean" class="block text-sm font-medium text-gray-700">EAN (código de barras)</label>
                            <input id="ean" type="text" name="ean" :value="modal.ean" inputmode="numeric" maxlength="14"
                                   class="mt-1.5 w-full rounded-lg border border-gray-300 px-3 py-2 font-mono text-sm
                                          focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                            @error('ean') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <label class="flex items-start gap-2 text-sm text-gray-700">
                            <input type="hidden" name="ativo" value="0">
                            <input type="checkbox" name="ativo" value="1" :checked="modal.ativo"
                                   class="mt-0.5 rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                            <span>
                                Variação ativa
                                <span class="block text-xs text-gray-500">Desative para parar de usar este SKU sem perder o histórico.</span>
                            </span>
                        </label>

                        <p class="text-xs text-gray-500">
                            Para trocar cor ou tamanho, desative esta variação e adicione a combinação nova à grade.
                        </p>

                        <div class="flex items-center gap-3">
                            <x-primary-button>Salvar</x-primary-button>
                            <button type="button" @click="modal = null" class="btn-sec">Cancelar</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>

@endsection
