@extends('layouts.app')

@section('titulo', 'Novo pedido')

@section('conteudo')

    @php
        // controller passa apenas $produtos ([id => nome]). O solicitante/status ficam
        // por conta do PedidoService (ex.: usuário autenticado / status inicial).
        $itensIniciais = old('itens', [['produto_id' => '', 'quantidade' => 1]]);
    @endphp

    <x-page-header title="Novo pedido" />

    <div class="card max-w-3xl">
        <form action="{{ route('pedidos.store') }}" method="POST" class="space-y-5">
            @csrf

            <x-form.field label="Destino" name="destino">
                <x-form.input name="destino" :value="old('destino')" placeholder="Loja Centro, Doca 2…" />
            </x-form.field>

            {{-- Itens do pedido (repeater Alpine) --}}
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
                <x-primary-button>Salvar pedido</x-primary-button>
                <a href="{{ route('pedidos.index') }}" class="btn-sec">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
