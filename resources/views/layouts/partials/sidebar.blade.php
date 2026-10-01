<div x-show="sidebarOpen"
     x-transition:enter="transition-opacity duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     class="fixed inset-0 z-30 bg-black/50 lg:hidden"
     style="display:none"></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 flex-col bg-gray-900
              transition-transform duration-200 lg:static lg:z-auto lg:translate-x-0">

    {{-- Marca --}}
    <div class="flex h-16 shrink-0 items-center gap-3 px-6">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-violet-600 text-sm font-bold text-white">W</div>
        <span class="text-lg font-semibold tracking-tight text-white">WMS</span>
    </div>

    <nav class="mt-2 flex-1 space-y-1 overflow-y-auto px-3 pb-4">

        <p class="mb-2 px-3 pt-4 text-[11px] font-semibold uppercase tracking-widest text-gray-500">Geral</p>

        <x-sidebar-link :href="route('painel')" :active="request()->routeIs('painel')">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z"/></svg>
            </x-slot:icon>
            Painel
        </x-sidebar-link>

        <p class="mb-2 px-3 pt-6 text-[11px] font-semibold uppercase tracking-widest text-gray-500">Cadastros</p>

        @include('layouts.partials.sidebar-produtos')

        @include('layouts.partials.sidebar-grupo', [
            'titulo' => 'Locais',
            'icone'  => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z',
            'itens'  => [
                ['rotulo' => 'Locais',    'rota' => 'locaisEstoque.index',     'padrao' => 'locaisEstoque.*'],
                ['rotulo' => 'Endereços', 'rota' => 'enderecoDeEstoque.index', 'padrao' => 'enderecoDeEstoque.*'],
            ],
        ])

        <x-sidebar-link :href="route('fornecedores.index')" :active="request()->routeIs('fornecedores.*')">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
            </x-slot:icon>
            Fornecedores
        </x-sidebar-link>

        <p class="mb-2 px-3 pt-6 text-[11px] font-semibold uppercase tracking-widest text-gray-500">Operações</p>

        <x-sidebar-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.*')">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
            </x-slot:icon>
            Pedidos
        </x-sidebar-link>

        <x-sidebar-link :href="route('movimentacoes.index')" :active="request()->routeIs('movimentacoes.*')">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>
            </x-slot:icon>
            Movimentações de estoque
        </x-sidebar-link>
    </nav>

    {{-- Usuário --}}
    @auth
        <div class="shrink-0 border-t border-gray-800 p-4">
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-700 text-xs font-semibold text-gray-300">
                    {{ Str::upper(Str::substr(auth()->user()->nome, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-gray-200">{{ auth()->user()->nome }}</p>
                    <p class="truncate text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <div class="mt-3 flex gap-2">
                <a href="{{ route('perfil') }}"
                   class="flex-1 rounded-md px-3 py-1.5 text-center text-sm
                          {{ request()->routeIs('perfil*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    Perfil
                </a>

                <form method="POST" action="{{ route('sair') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-md px-3 py-1.5 text-sm text-red-400 hover:bg-gray-800 hover:text-red-300">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    @endauth
</aside>
