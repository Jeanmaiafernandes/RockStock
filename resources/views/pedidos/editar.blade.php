@extends('layouts.app')

@section('titulo', 'Editar pedido')

@section('conteudo')

    @php
        /*
         | Controller passa: $pedido (com ->load('itens.produto')),
         | $produtos ([id => nome])
         |
         | O solicitante é preservado num hidden; para permitir trocá-lo, passe
         | $users ([id => name]) — ver comentário no formulário.
         */

        // ---------------------------------------------------------------
        // Itens: old() > banco > uma linha em branco
        // ---------------------------------------------------------------
        // O `id` de cada item vai num hidden para o controller fazer upsert em
        // vez de delete + create — assim não se perde created_at, colunas
        // extras (preço no momento do pedido, etc.) nem FKs que apontem pro item.
        $itensDoBanco = $pedido->itens
            ->map(fn ($item) => [
                'id' => $item->id,
                'produto_id' => (string) $item->produto_id,
                'quantidade' => $item->quantidade,
            ])
            ->values()
            ->all();

        $itensIniciais = array_values(old('itens', $itensDoBanco));

        // ---------------------------------------------------------------
        // Produtos selecionáveis
        // ---------------------------------------------------------------
        // Um produto já usado no pedido precisa continuar na lista mesmo que
        // tenha saído do catálogo (inativo / soft delete). Sem isso o <select>
        // cai em "" e o item some silenciosamente ao salvar.
        $produtosSelecionaveis = collect($produtos)
            ->map(fn ($nome, $id) => ['id' => (string) $id, 'nome' => (string) $nome, 'disponivel' => true])
            ->keyBy('id');

        foreach ($pedido->itens as $item) {
            $produtoId = (string) $item->produto_id;

            if (! $produtosSelecionaveis->has($produtoId)) {
                $produtosSelecionaveis->put($produtoId, [
                    'id' => $produtoId,
                    'nome' => $item->produto?->nome ?? "Produto #{$produtoId}",
                    'disponivel' => false,
                ]);
            }
        }

        $produtosSelecionaveis = $produtosSelecionaveis->sortBy('nome')->values()->all();

        /*
         | Erros aninhados (itens.0.produto_id) agrupados por linha.
         | $errors->get('itens') NÃO devolve isso — é por causa disso que as
         | mensagens dos itens nunca apareciam na tela.
         */
        $errosPorLinha = [];

        foreach ($errors->getMessages() as $chave => $mensagens) {
            if (preg_match('/^itens\.(\d+)\.(\w+)$/', $chave, $partes)) {
                $errosPorLinha[(int) $partes[1]][$partes[2]] = $mensagens[0];
            }
        }

        // ---------------------------------------------------------------
        // Status
        // ---------------------------------------------------------------
        $enumStatus = $pedido->statusPedido instanceof \BackedEnum ? $pedido->statusPedido : null;
        $statusAtual = $enumStatus?->value ?? (string) $pedido->statusPedido;

        $statusOpcoes = [];

        foreach ($enumStatus ? $enumStatus::cases() : [] as $caso) {
            $statusOpcoes[$caso->value] = method_exists($caso, 'label')
                ? $caso->label()
                : (string) \Illuminate\Support\Str::of($caso->value)->replace('_', ' ')->ucfirst();
        }

        // Fallback = exatamente os valores aceitos pelo PedidosUpdateRequest
        // ('in:rascunho,confirmado,cancelado'). Se mudar lá, mude aqui.
        if (empty($statusOpcoes)) {
            $statusOpcoes = ['rascunho' => 'Rascunho', 'confirmado' => 'Confirmado', 'cancelado' => 'Cancelado'];
        }

        /*
         | Trocar o status é uma decisão de fluxo, não um campo livre de
         | formulário. Se existir PedidoPolicy::alterarStatus, ela manda; se
         | ainda não existir, o campo continua editável (comportamento atual).
         | Lembre de repetir a checagem no controller/FormRequest — esconder o
         | <select> aqui é só interface, não é segurança.
         */
        $policy = app(\Illuminate\Contracts\Auth\Access\Gate::class)->getPolicyFor($pedido);

        $podeAlterarStatus = (! $policy || ! method_exists($policy, 'alterarStatus'))
            || (bool) auth()->user()?->can('alterarStatus', $pedido);
    @endphp

    <x-page-header :title="'Editar pedido '.$pedido->codigo" />

    <div class="card max-w-3xl">
        <form action="{{ route('pedidos.update', $pedido) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            {{-- Lock otimista: se outra pessoa salvou o pedido enquanto esta tela
                 estava aberta, o controller recusa em vez de sobrescrever o
                 trabalho dela em silêncio. Comparar assim no update():
                   $request->date('updated_at')->utc()->format('Y-m-d H:i:s')
                   === $pedido->updated_at->copy()->utc()->format('Y-m-d H:i:s') --}}
            <input type="hidden" name="updated_at" value="{{ $pedido->updated_at?->toJSON() }}">

            {{-- Resumo de erros: o usuário precisa perceber a falha mesmo que o
                 campo problemático esteja fora da viewport. --}}
            @if ($errors->any())
                <div class="rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">
                    <p class="font-medium">Não foi possível salvar o pedido:</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach (collect($errors->all())->unique() as $mensagem)
                            <li>{{ $mensagem }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Solicitante: mantido como está enquanto $users não vem do
                 controller. Para voltar a permitir a troca, passe $users
                 ([id => name]) e substitua este hidden por:

                 <x-form.field label="Solicitante" name="user_id">
                     <x-form.select name="user_id" :options="$users"
                                    :selected="old('user_id', $pedido->user_id)"
                                    placeholder="Selecione…" required />
                 </x-form.field>
            --}}
            <input type="hidden" name="user_id" value="{{ old('user_id', $pedido->user_id) }}">

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-form.field label="Status" name="statusPedido">
                    @if ($podeAlterarStatus)
                        <x-form.select
                            name="statusPedido"
                            :options="$statusOpcoes"
                            :selected="old('statusPedido', $statusAtual)"
                            required
                        />
                    @else
                        {{-- Sem permissão: exibe o valor, mas não envia o campo. --}}
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800">
                            {{ $statusOpcoes[$statusAtual] ?? $statusAtual }}
                        </span>
                    @endif
                </x-form.field>

                <x-form.field label="Destino" name="destino">
                    <x-form.input name="destino" :value="old('destino', $pedido->destino)" required maxlength="255" />
                </x-form.field>
            </div>

            <x-form.field label="Observação" name="observacao">
                <textarea
                    name="observacao"
                    id="observacao"
                    rows="2"
                    maxlength="255"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500"
                >{{ old('observacao', $pedido->observacao) }}</textarea>
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
                            id: item.id ?? null,
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
                        this.itens.push({ id: null, produto_id: '', quantidade: 1, _k: this.uid++, _erroOriginal: null });
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

                    indisponivel(item) {
                        const produto = this.produtos.find(p => p.id === item.produto_id);
                        return produto ? ! produto.disponivel : false;
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
                    {{-- :key estável (_k). Com :key="i" o Alpine reaproveita o DOM
                         errado ao remover uma linha do meio. --}}
                    <template x-for="(item, i) in itens" :key="item._k">
                        <div>
                            {{-- Preserva o ID do item existente para o upsert --}}
                            <template x-if="item.id">
                                <input type="hidden" :name="`itens[${i}][id]`" :value="item.id">
                            </template>

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
                                             Sem este $nextTick o select nasceria vazio na edição. --}}
                                        x-init="$nextTick(() => $el.value = item.produto_id)"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500"
                                        :class="erroDe(item, 'produto_id') ? 'border-rose-400' : ''"
                                        required
                                    >
                                        <option value="">Selecione o produto…</option>
                                        {{-- Lista passada uma vez ao Alpine: evita renderizar
                                             N produtos × M linhas de <option> no HTML. --}}
                                        <template x-for="produto in produtos" :key="produto.id">
                                            <option
                                                :value="produto.id"
                                                :disabled="! produto.disponivel && item.produto_id !== produto.id"
                                                x-text="produto.disponivel ? produto.nome : produto.nome + ' (indisponível)'"
                                            ></option>
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

                            {{-- Erro da linha, ou aviso de duplicidade / produto fora do catálogo --}}
                            <template x-if="erroDe(item, 'produto_id') || erroDe(item, 'quantidade') || duplicado(item) || indisponivel(item)">
                                <p
                                    class="mt-1 text-sm"
                                    :class="(erroDe(item, 'produto_id') || erroDe(item, 'quantidade')) ? 'text-rose-600' : 'text-amber-600'"
                                    x-text="erroDe(item, 'produto_id')
                                        ?? erroDe(item, 'quantidade')
                                        ?? (duplicado(item)
                                            ? 'Este produto já está em outra linha — some as quantidades.'
                                            : 'Este produto não está mais disponível no catálogo.')"
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

            {{-- Sem JS o <template x-for> não renderiza nada e o form iria vazio,
                 o que zeraria os itens do pedido sem o usuário perceber. --}}
            <noscript>
                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                    Este formulário precisa de JavaScript para editar os itens do pedido.
                </div>
            </noscript>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Salvar alterações</x-primary-button>
                <a href="{{ route('pedidos.index') }}" class="btn-sec">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
