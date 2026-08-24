@extends('layouts.app')

@section('titulo', 'Editar pedido')

@section('conteudo')

    @php
        // controller passa: $pedido (com itens), $produtos ([id=>nome]), $users ([id=>name])
        $itensDoPedido = $pedido->itens
            ->map(fn ($i) => ['produto_id' => $i->produto_id, 'quantidade' => $i->quantidade])
            ->values()
            ->all();
        $itensIniciais = old('itens', $itensDoPedido ?: [['produto_id' => '', 'quantidade' => 1]]);

        // status atual e opções montadas a partir do próprio enum do pedido
        $statusAtual = $pedido->statusPedido->value ?? $pedido->statusPedido;

        $statusOpcoes = [];
        if ($pedido->statusPedido instanceof \BackedEnum) {
            foreach ($pedido->statusPedido::cases() as $caso) {
                $statusOpcoes[$caso->value] = \Illuminate\Support\Str::of($caso->value)->replace('_', ' ')->ucfirst();
            }
        }
        // fallback caso statusPedido não seja um enum (ajuste aos valores reais se precisar)
        if (empty($statusOpcoes)) {
            $statusOpcoes = ['pendente' => 'Pendente', 'confirmado' => 'Confirmado', 'cancelado' => 'Cancelado'];
        }
    @endphp

    <x-page-header :title="'Editar pedido '.$pedido->codigo" />

    <div class="card max-w-3xl">
        <form action="{{ route('pedidos.update', $pedido) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-form.field label="Solicitante" name="user_id">
                    <x-form.select name="user_id" :options="$users" :selected="old('user_id', $pedido->user_id)" placeholder="Selecione…" />
                </x-form.field>

                <x-form.field label="Status" name="statusPedido">
                    <x-form.select name="statusPedido" :options="$statusOpcoes" :selected="old('statusPedido', $statusAtual)" />
                </x-form.field>
            </div>

            <x-form.field label="Destino" name="destino">
                <x-form.input name="destino" :value="old('destino', $pedido->destino)" />
            </x-form.field>

            {{-- Itens do pedido (repeater Alpine, pré-populado) --}}
            <div x-data="{ itens: @js($itensIniciais) }">
                <div class="mb-2 flex items-center justify-between">
                    <x-input-label value="Itens do pedido" />
                    <button type="button" @click="itens.push({ produto_id: '', quantidade: 1 })"
                            class="text-sm font-medium text-violet-600 hover:underline">+ Adicionar item</button>
                </div>

                <div class="space-y-3">
                    <template x-for="(item, i) in itens" :key="i">
                        <div class="flex items-start gap-3">
                            <select :name="`itens[${i}][produto_id]`" x-model="item.produto_id"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                                <option value="">Selecione o produto…</option>
                                @foreach ($produtos as $id => $nome)
                                    <option value="{{ $id }}">{{ $nome }}</option>
                                @endforeach
                            </select>
                            <input type="number" min="1" :name="`itens[${i}][quantidade]`" x-model="item.quantidade"
                                   class="w-24 rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                            <button type="button" @click="itens.splice(i, 1)" x-show="itens.length > 1"
                                    class="px-2 py-2 text-gray-400 hover:text-red-600" title="Remover">&times;</button>
                        </div>
                    </template>
                </div>
                <x-input-error :messages="$errors->get('itens')" class="mt-2" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Salvar alterações</x-primary-button>
                <a href="{{ route('pedidos.index') }}" class="btn-sec">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
