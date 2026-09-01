@extends('layouts.app')

@section('titulo', 'Novo pedido')

@section('conteudo')

    @php
        $statusOpcoes = $statusOpcoes ?? (function () {
            $classe = (new \App\Models\Pedido)->getCasts()['statusPedido'] ?? null;

            if (! $classe || ! enum_exists($classe)) {
                return [];
            }

            $opcoes = [];

            foreach ($classe::cases() as $caso) {
                $opcoes[$caso->value] = method_exists($caso, 'label')
                    ? $caso->label()
                    : (string) \Illuminate\Support\Str::of($caso->value)->replace('_', ' ')->ucfirst();
            }

            return $opcoes;
        })();

        if (empty($statusOpcoes)) {
            $statusOpcoes = ['rascunho' => 'Rascunho', 'confirmado' => 'Confirmado', 'cancelado' => 'Cancelado'];
        }

        $statusPadrao = old('statusPedido', array_key_exists('rascunho', $statusOpcoes)
            ? 'rascunho'
            : array_key_first($statusOpcoes));

        $itensIniciais = array_values(old('itens', []));

        $produtosSelecionaveis = collect($produtos)
            ->map(fn ($nome, $id) => ['id' => (string) $id, 'nome' => (string) $nome, 'disponivel' => true])
            ->sortBy('nome')
            ->values()
            ->all();

        $errosPorLinha = [];

        foreach ($errors->getMessages() as $chave => $mensagens) {
            if (preg_match('/^itens\.(\d+)\.(\w+)$/', $chave, $partes)) {
                $errosPorLinha[(int) $partes[1]][$partes[2]] = $mensagens[0];
            }
        }
    @endphp

    <x-page-header title="Novo pedido" />

    <div class="card max-w-3xl">
        <form action="{{ route('pedidos.store') }}" method="POST" class="space-y-5">
            @csrf

            @if ($errors->any())
                <div class="rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">
                    <p class="font-medium">Não foi possível criar o pedido:</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach (collect($errors->all())->unique() as $mensagem)
                            <li>{{ $mensagem }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="hidden" name="usuario_id" value="{{ old('usuario_id', auth()->id()) }}">

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-form.field label="Status" name="statusPedido">
                    <x-form.select name="statusPedido" :options="$statusOpcoes" :selected="$statusPadrao" required />
                </x-form.field>

                <x-form.field label="Destino" name="destino">
                    <x-form.input name="destino" :value="old('destino')" required maxlength="255" />
                </x-form.field>
            </div>

            <x-form.field label="Observação" name="observacao">
                <textarea
                    name="observacao"
                    id="observacao"
                    rows="2"
                    maxlength="255"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500"
                >{{ old('observacao') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Opcional — até 255 caracteres.</p>
            </x-form.field>

            {{-- ============================================================ --}}
            {{-- Itens do pedido                                              --}}
            {{-- ============================================================ --}}
            <div
                x-data="{
                    uid: 0,
                    itens: [],
                    produtos: @js($produtosSelecionaveis),
                    erros: @js($errosPorLinha),

                    init() {
                        this.itens = @js($itensIniciais).map((item, i) => ({
                            produto_id: item.produto_id ? String(item.produto_id) : '',
                            quantidade: Number(item.quantidade) || 1,
                            _k: this.uid++,
                            _erroOriginal: i,
                        }));

                        if (this.itens.length === 0) {
                            this.adicionar();
                        }
                    },

                    adicionar() {
                        this.itens.push({ produto_id: '', quantidade: 1, _k: this.uid++, _erroOriginal: null });
                    },

                    remover(indice) {
                        this.itens.splice(indice, 1);
                    },

                    erroDe(item, campo) {
                        return item._erroOriginal !== null ? (this.erros?.[item._erroOriginal]?.[campo] ?? null) : null;
                    },

                    limparErro(item) {
                        item._erroOriginal = null;
                    },

                    duplicado(item) {
                        return item.produto_id !== ''
                            && this.itens.filter(outro => outro.produto_id === item.produto_id).length > 1;
                    },

                    get totalUnidades() {
                        return this.itens.reduce((soma, item) => soma + (Number(item.quantidade) || 0), 0);
                    },
                }"
                x-cloak
            >
                <div class="mb-2 flex items-center justify-between">
                    <x-input-label value="Itens do pedido" />
                    <button type="button" @click="adicionar()" class="text-sm font-medium text-violet-600 hover:underline">
                        + Adicionar item
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(item, i) in itens" :key="item._k">
                        <div>
                            <div class="flex items-start gap-3">
                                <div class="min-w-0 flex-1">
                                    <label :for="`item-produto-${item._k}`" class="sr-only">
                                        Produto do item <span x-text="i + 1"></span>
                                    </label>
                                    <select
                                        :id="`item-produto-${item._k}`"
                                        :name="`itens[${i}][produto_id]`"
                                        x-model="item.produto_id"
                                        @change="limparErro(item)"
                                        {{-- As <option> vêm de um x-for aninhado, que o Alpine só
                                             processa DEPOIS de inicializar o x-model do select.
                                             Sem este $nextTick o select nasceria vazio. --}}
                                        x-init="$nextTick(() => $el.value = item.produto_id)"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500"
                                        :class="erroDe(item, 'produto_id') ? 'border-rose-400' : ''"
                                        required
                                    >
                                        <option value="">Selecione o produto…</option>
                                        {{-- Lista passada uma vez ao Alpine: evita renderizar
                                             N produtos × M linhas de <option> no HTML. --}}
                                        <template x-for="produto in produtos" :key="produto.id">
                                            <option :value="produto.id" x-text="produto.nome"></option>
                                        </template>
                                    </select>
                                </div>

                                <div class="w-24 shrink-0">
                                    <label :for="`item-qtd-${item._k}`" class="sr-only">
                                        Quantidade do item <span x-text="i + 1"></span>
                                    </label>
                                    <input
                                        type="number"
                                        min="1"
                                        max="65535"
                                        step="1"
                                        :id="`item-qtd-${item._k}`"
                                        :name="`itens[${i}][quantidade]`"
                                        x-model.number="item.quantidade"
                                        @input="limparErro(item)"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500"
                                        :class="erroDe(item, 'quantidade') ? 'border-rose-400' : ''"
                                        required
                                    >
                                </div>

                                <button
                                    type="button"
                                    @click="remover(i)"
                                    class="shrink-0 rounded-lg px-2 py-2 text-gray-400 hover:bg-rose-50 hover:text-rose-600"
                                    title="Remover item"
                                >
                                    <span class="sr-only">Remover item <span x-text="i + 1"></span></span>
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            {{-- Erro da linha (validação) ou aviso de duplicidade --}}
                            <template x-if="erroDe(item, 'produto_id') || erroDe(item, 'quantidade') || duplicado(item)">
                                <p
                                    class="mt-1 text-sm"
                                    :class="(erroDe(item, 'produto_id') || erroDe(item, 'quantidade')) ? 'text-rose-600' : 'text-amber-600'"
                                    x-text="erroDe(item, 'produto_id')
                                        ?? erroDe(item, 'quantidade')
                                        ?? 'Este produto já está em outra linha — some as quantidades.'"
                                ></p>
                            </template>
                        </div>
                    </template>
                </div>

                <template x-if="itens.length === 0">
                    <div class="rounded-lg border border-dashed border-gray-300 p-6 text-center">
                        <p class="text-sm text-gray-500">Nenhum item no pedido.</p>
                        <button type="button" @click="adicionar()" class="mt-2 text-sm font-medium text-violet-600 hover:underline">
                            Adicionar o primeiro item
                        </button>
                    </div>
                </template>

                <p class="mt-2 text-sm text-gray-500">
                    <span x-text="itens.length"></span>
                    <span x-text="itens.length === 1 ? 'item' : 'itens'"></span>
                    &middot;
                    <span x-text="totalUnidades"></span> unidades
                </p>

                <x-input-error :messages="$errors->get('itens')" class="mt-2" />
            </div>

            {{-- Sem JS o <template x-for> não renderiza nada e o form iria vazio. --}}
            <noscript>
                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                    Este formulário precisa de JavaScript para montar os itens do pedido.
                </div>
            </noscript>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Criar pedido</x-primary-button>
                <a href="{{ route('pedidos.index') }}" class="btn-sec">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
