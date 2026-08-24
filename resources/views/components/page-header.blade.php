@props(['title' => ''])

{{--
    Cabeçalho de página. Título à esquerda; o slot vai à direita (botões de ação).
    Uso:
        <x-page-header title="Produtos">
            <a href="{{ route('produtos.create') }}" class="btn">Novo produto</a>
        </x-page-header>
--}}
<div {{ $attributes->merge(['class' => 'mb-6 flex flex-wrap items-center justify-between gap-4']) }}>
    <h1 class="text-xl font-semibold text-gray-800">{{ $title }}</h1>

    @if (! $slot->isEmpty())
        <div class="flex items-center gap-3">{{ $slot }}</div>
    @endif
</div>
