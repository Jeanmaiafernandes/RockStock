<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo', 'Painel') — {{ config('app.name', 'WMS') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style type="text/tailwindcss">
        @layer components {
            .input {
                @apply w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500;
            }
            .btn {
                @apply inline-flex items-center rounded-lg bg-violet-600 px-4 py-2
                text-sm font-medium text-white hover:bg-violet-700;
            }
            .btn-sec {
                @apply inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2
                text-sm font-medium text-gray-700 hover:bg-gray-50;
            }
            .card { @apply rounded-xl border border-gray-200 bg-white p-6 shadow-sm; }
            .erro { @apply mt-1 text-sm text-red-600; }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100 font-sans text-gray-800 antialiased">

<div class="flex min-h-screen" x-data="{ sidebarOpen: false }">

    @include('layouts.partials.sidebar')

    {{-- min-w-0 é o que impede uma tabela larga de esticar o layout inteiro --}}
    <div class="flex min-w-0 flex-1 flex-col">

        @include('layouts.partials.topbar')

        <main class="flex-1 space-y-4 p-4 sm:p-6 lg:p-8">
            @include('layouts.partials.flash')

            @yield('conteudo')
        </main>
    </div>
</div>

</body>
</html>
