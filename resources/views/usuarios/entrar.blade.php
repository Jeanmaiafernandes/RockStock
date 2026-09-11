@extends('usuarios.layout')

@section('titulo', 'Entrar')

@section('conteudo')
    <h1 class="mb-6 text-2xl font-semibold">Entrar</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4 rounded border border-stone-300 bg-white p-6">
        @csrf

        <div>
            <label for="email" class="mb-1 block text-sm font-medium">E-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded border border-stone-300 px-3 py-2">
            {{-- Aqui também aparece o "E-mail ou senha incorretos." vindo do controller --}}
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="senha" class="mb-1 block text-sm font-medium">Senha</label>
            <input id="senha" name="senha" type="password" required autocomplete="current-password"
                   class="w-full rounded border border-stone-300 px-3 py-2">
            @error('senha') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="lembrar" value="1">
            Manter conectado
        </label>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('cadastro') }}" class="text-sm text-stone-600 hover:underline">Criar conta</a>
            <button type="submit" class="rounded bg-stone-900 px-4 py-2 text-sm font-medium text-white hover:bg-stone-700">
                Entrar
            </button>
        </div>
    </form>
@endsection
