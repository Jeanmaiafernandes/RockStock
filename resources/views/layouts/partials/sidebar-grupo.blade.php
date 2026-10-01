{{--
    Grupo com dropdown no menu lateral.
    Recebe:
      $titulo  texto do grupo
      $icone   o atributo "d" do <path> do ícone (Heroicons, outline)
      $itens   lista de ['rotulo' => ..., 'rota' => ..., 'padrao' => ...]
--}}
@php
    $grupoAtivo = collect($itens)->contains(fn ($item) => request()->routeIs($item['padrao']));
@endphp

<div x-data="{ aberto: @js($grupoAtivo) }">
    <button type="button" @click="aberto = !aberto" :aria-expanded="aberto.toString()"
            class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition
                   {{ $grupoAtivo ? 'text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icone }}"/>
        </svg>
        <span class="flex-1 text-left">{{ $titulo }}</span>
        <svg class="h-4 w-4 transition" :class="aberto && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
        </svg>
    </button>

    <div x-show="aberto" @unless ($grupoAtivo) style="display: none" @endunless
    class="ml-5 mt-1 space-y-1 border-l border-gray-800 pl-3">
        @foreach ($itens as $item)
            @php $ativo = request()->routeIs($item['padrao']); @endphp
            <a href="{{ route($item['rota']) }}" @if ($ativo) aria-current="page" @endif
            class="block rounded-md px-3 py-1.5 text-sm transition
                      {{ $ativo ? 'bg-gray-800 font-medium text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                {{ $item['rotulo'] }}
            </a>
        @endforeach
    </div>
</div>
