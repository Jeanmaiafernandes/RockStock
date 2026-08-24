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

        <x-sidebar-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/></svg>
            </x-slot:icon>
            Categorias
        </x-sidebar-link>

        <x-sidebar-link :href="route('produtos.index')" :active="request()->routeIs('produtos.*')">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25"/></svg>
            </x-slot:icon>
            Produtos
        </x-sidebar-link>

        <x-sidebar-link :href="route('statusProdutos.index')" :active="request()->routeIs('statusProdutos.*')">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </x-slot:icon>
            Status de produtos
        </x-sidebar-link>

        <x-sidebar-link :href="route('enderecoDeEstoque.index')" :active="request()->routeIs('enderecoDeEstoque.*')">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </x-slot:icon>
            Endereço de Estoque
        </x-sidebar-link>

        <x-sidebar-link :href="route('fornecedores.index')" :active="request()->routeIs('statusProdutos.*')">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
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
    </nav>

    {{-- Usuário --}}
    @auth
        <div class="shrink-0 border-t border-gray-800 p-4">
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-700 text-xs font-semibold text-gray-300">
                    {{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-gray-200">{{ auth()->user()->name }}</p>
                    <p class="truncate text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('sair') }}" class="text-red-600">
                @csrf
                <button type="submit" class="...">Sair</button>
            </form>
        </div>
    @endauth
</aside>
