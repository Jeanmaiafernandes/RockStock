@extends('layouts.app')

@section('titulo', 'Meu perfil')

@section('conteudo')
    <h1 class="mb-6 text-2xl font-semibold">Meu perfil</h1>

    <form method="POST" action="{{ route('perfil.atualizar') }}" class="mb-8 space-y-4 rounded border border-stone-300 bg-white p-6">
        @csrf
        @method('PATCH')

        <h2 class="text-lg font-medium">Dados da conta</h2>

        <div>
            <label for="nome" class="mb-1 block text-sm font-medium">Nome</label>
            <input id="nome" name="nome" type="text" value="{{ old('nome', $usuario->nome) }}" required
                   class="w-full rounded border border-stone-300 px-3 py-2">
            @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium">E-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email', $usuario->email) }}" required
                   class="w-full rounded border border-stone-300 px-3 py-2">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="rounded bg-stone-900 px-4 py-2 text-sm font-medium text-white hover:bg-stone-700">
                Salvar dados
            </button>
        </div>
    </form>

    <form method="POST" action="{{ route('perfil.senha') }}" class="space-y-4 rounded border border-stone-300 bg-white p-6">
        @csrf
        @method('PATCH')

        <h2 class="text-lg font-medium">Alterar senha</h2>

        <div>
            <label for="senha_atual" class="mb-1 block text-sm font-medium">Senha atual</label>
            <input id="senha_atual" name="senha_atual" type="password" required autocomplete="current-password"
                   class="w-full rounded border border-stone-300 px-3 py-2">
            @error('senha_atual', 'senha') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="senha" class="mb-1 block text-sm font-medium">Nova senha</label>
            <input id="senha" name="senha" type="password" required autocomplete="new-password"
                   class="w-full rounded border border-stone-300 px-3 py-2">
            @error('senha', 'senha') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="senha_confirmation" class="mb-1 block text-sm font-medium">Confirmar nova senha</label>
            <input id="senha_confirmation" name="senha_confirmation" type="password" required autocomplete="new-password"
                   class="w-full rounded border border-stone-300 px-3 py-2">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="rounded bg-stone-900 px-4 py-2 text-sm font-medium text-white hover:bg-stone-700">
                Alterar senha
            </button>
        </div>
    </form>
@endsection
