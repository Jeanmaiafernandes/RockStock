<header
class="sticky top-0 z-20 flex h-16 items-center
gap-4 border-b border-gray-200 bg-white px-4 sm:px-6">

<button type="button" @click="sidebarOpen = true"
        class="text-gray-500 hover:text-gray-700 lg:hidden">
    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
    </svg>
</button>

<h1 class="truncate text-lg font-semibold text-gray-800">@yield('titulo', 'Painel')</h1>

@hasSection('acoes')
    <div class="ml-auto flex shrink-0 items-center gap-2">
        @yield('acoes')
    </div>
    @endif
    </header>
