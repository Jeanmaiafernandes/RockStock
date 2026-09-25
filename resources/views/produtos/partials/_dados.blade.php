@php
    $produto ??= null;
    $editando = (bool) $produto;
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <x-form.field label="Referência" name="referencia">
        @if ($editando)
            <x-form.input name="referencia" :value="$produto->referencia"
                          class="bg-gray-50 font-mono text-gray-500" readonly disabled />
        @else
            <x-form.input name="referencia" :value="old('referencia')"
                          placeholder="Ex.: CAM-0142" class="font-mono uppercase"
                          maxlength="30" required />
        @endif
    </x-form.field>

    <x-form.field label="Coleção" name="colecao">
        <x-form.input name="colecao" :value="old('colecao', $produto?->colecao)"
                      placeholder="Ex.: Verão 2027" maxlength="50" />
    </x-form.field>

    <x-form.field label="Nome" name="nome" class="sm:col-span-2">
        <x-form.input name="nome" :value="old('nome', $produto?->nome)"
                      placeholder="Ex.: Camiseta Ramones logo" maxlength="200" required />
    </x-form.field>

    <x-form.field label="Fornecedor" name="fornecedor_id">
        <x-form.select name="fornecedor_id" :options="$fornecedores"
                       :selected="old('fornecedor_id', $produto?->fornecedor_id)" required />
    </x-form.field>

    <x-form.field label="Categoria" name="produto_categoria_id">
        <x-form.select name="produto_categoria_id" :options="$categorias"
                       :selected="old('produto_categoria_id', $produto?->produto_categoria_id)" required />
    </x-form.field>

    <x-form.field label="Status" name="produto_status_id">
        <x-form.select name="produto_status_id" :options="$status"
                       :selected="old('produto_status_id', $produto?->produto_status_id)" required />
    </x-form.field>

    <x-form.field label="Descrição" name="descricao" class="sm:col-span-2">
        <x-form.textarea name="descricao" rows="3"
                         :value="old('descricao', $produto?->descricao)"
                         placeholder="Composição, estampa, observações" />
    </x-form.field>
</div>
