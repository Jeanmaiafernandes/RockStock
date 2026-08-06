@extends('layouts.app')

@section('titulo', 'Editar pedido ' . $pedido->codigo)

@section('conteudo')
    <form method="POST" action="{{ route('pedidos.update', $pedido) }}" class="card max-w-4xl space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid gap-4 md:grid-cols-3">
            <x-form.input name="destino" label="Destino" :value="$pedido->destino" maxlength="255" autofocus />

            <x-form.select name="statusPedido" label="Status"
                           :opcoes="['rascunho' => 'Rascunho', 'confirmado' => 'Confirmado', 'cancelado' => 'Cancelado']"
                           :selected="$pedido->statusPedido instanceof \BackedEnum ? $pedido->statusPedido->value : $pedido->statusPedido"
                           :placeholder="null" />

            <x-form.input name="observacao" label="Observação" :value="$pedido->observacao" maxlength="255" />
        </div>

        {{-- Itens --}}
        <div class="border-t border-gray-100 pt-5"
             x-data="{
                itens: @js(old('itens', $pedido->itens->map(fn ($i) => [
                    'produto_id' => $i->produto_id,
                    'quantidade' => $i->quantidade,
                ])->values())),
                add() { this.itens.push({ produto_id: '', quantidade: 1 }) },
                remove(i) { if (this.itens.length > 1) this.itens.splice(i, 1) },
                get total() { return this.itens.reduce((s, i) => s + (parseInt(i.quantidade) || 0), 0) },
             }">

            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-800">Itens do pedido</h2>
                <p class="text-xs text-gray-500">
                    <span x-text="itens.length"></span> linha(s) · <span x-text="total"></span> peça(s)
                </p>
            </div>

            <div class="mt-3 space-y-2">
                <template x-for="(item, i) in itens" :key="i">
                    <div class="flex items-start gap-2">
                        <select :name="`itens[${i}][produto_id]`" x-model="item.produto_id" class="input flex-1">
                            <option value="">Selecione o produto</option>
                            @foreach ($produtos as $id => $nome)
                                <option value="{{ $id }}">{{ $nome }}</option>
                            @endforeach
                        </select>

                        <input type="number" min="1" x-model="item.quantidade"
                               :name="`itens[${i}][quantidade]`" class="input w-24">

                        <button type="button" x-on:click="remove(i)"
                                class="shrink-0 rounded-lg px-3 py-2 text-sm text-red-600 hover:bg-red-50">
                            Remover
                        </button>
                    </div>
                </template>
            </div>

            <button type="button" x-on:click="add()" class="btn-sec mt-3">+ Adicionar item</button>
        </div>

        <div class="flex gap-2 border-t border-gray-100 pt-4">
            <button class="btn">Salvar alterações</button>
            <a href="{{ route('pedidos.show', $pedido) }}" class="btn-sec">Cancelar</a>
        </div>
    </form>
@endsection
