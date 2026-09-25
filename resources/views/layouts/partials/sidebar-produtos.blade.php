{{--
    Grupo "Produtos" do menu lateral, com os cadastros do catálogo.
    No sidebar.blade.php, troque os links de Categorias, Produtos e
    Status de produtos por:  @include('layouts.partials.sidebar-produtos')
--}}
@php
    $itensProduto = [
        ['rotulo' => 'Produtos',   'rota' => 'produtos.index',          'padrao' => 'produtos.*'],
        ['rotulo' => 'Categorias', 'rota' => 'categoriasProduto.index', 'padrao' => 'categoriasProduto.*'],
        ['rotulo' => 'Status',     'rota' => 'statusProduto.index',     'padrao' => 'statusProduto.*'],
        ['rotulo' => 'Tamanhos',   'rota' => 'tamanhos.index',          'padrao' => 'tamanhos.*'],
    ];

    $grupoAtivo = collect($itensProduto)->contains(fn ($item) => request()->routeIs($item['padrao']));
@endphp

<div x-data="{ aberto: @js($grupoAtivo) }">
    <button type="button" @click="aberto = !aberto" :aria-expanded="aberto.toString()"
            class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition
                   {{ $grupoAtivo ? 'text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25"/>
        </svg>
        <span class="flex-1 text-left">Produtos</span>
        <svg class="h-4 w-4 transition" :class="aberto && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
        </svg>
    </button>

    <div x-show="aberto" @unless ($grupoAtivo) style="display: none" @endunless
    class="ml-5 mt-1 space-y-1 border-l border-gray-800 pl-3">
        @foreach ($itensProduto as $item)
            @php $ativo = request()->routeIs($item['padrao']); @endphp
            <a href="{{ route($item['rota']) }}" @if ($ativo) aria-current="page" @endif
            class="block rounded-md px-3 py-1.5 text-sm transition
                      {{ $ativo ? 'bg-gray-800 font-medium text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                {{ $item['rotulo'] }}
            </a>
        @endforeach
    </div>
</div>
