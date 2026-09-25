<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') — WMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-stone-100 text-stone-900">

<header class="border-b border-stone-300 bg-white">
    <div class="mx-auto flex max-w-xl items-center justify-between px-4 py-3">
        <span class="font-semibold">WMS</span>

        @auth
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('perfil') }}" class="hover:underline">{{ auth()->user()->nome }}</a>
                <form method="POST" action="{{ route('sair') }}">
                    @csrf
                    <button type="submit" class="text-stone-600 hover:underline">Sair</button>
                </form>
            </div>
        @endauth

        @guest
            <div class="flex gap-4 text-sm">
                <a href="{{ route('login') }}" class="hover:underline">Entrar</a>
                <a href="{{ route('cadastro') }}" class="hover:underline">Criar conta</a>
            </div>
        @endguest
    </div>
</header>

<main class="mx-auto max-w-xl px-4 py-8">
    @if (session('sucesso'))
        <p class="mb-6 rounded border border-green-300 bg-green-50 px-4 py-2 text-sm text-green-800">
            {{ session('sucesso') }}
        </p>
    @endif

    @yield('conteudo')
</main>

</body>
</html>
