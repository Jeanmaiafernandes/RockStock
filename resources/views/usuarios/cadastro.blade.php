@extends('usuarios.layout')

@section('titulo', 'Criar conta')

@section('conteudo')
    <h1 class="mb-6 text-2xl font-semibold">Criar conta</h1>

    <form method="POST" action="{{ route('cadastro') }}" class="space-y-4 rounded border border-stone-300 bg-white p-6">
        @csrf

        <div>
            <label for="nome" class="mb-1 block text-sm font-medium">Nome</label>
            {{-- old('nome'): se a validação falhar, o campo volta preenchido --}}
            <input id="nome" name="nome" type="text" value="{{ old('nome') }}" required
                   class="w-full rounded border border-stone-300 px-3 py-2">
            @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium">E-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                   class="w-full rounded border border-stone-300 px-3 py-2">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="senha" class="mb-1 block text-sm font-medium">Senha</label>
            <input id="senha" name="senha" type="password" required autocomplete="new-password"
                   class="w-full rounded border border-stone-300 px-3 py-2">
            @error('senha') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            {{-- O nome precisa ser exatamente 'senha_confirmation' por causa da regra 'confirmed' --}}
            <label for="senha_confirmation" class="mb-1 block text-sm font-medium">Confirmar senha</label>
            <input id="senha_confirmation" name="senha_confirmation" type="password" required autocomplete="new-password"
                   class="w-full rounded border border-stone-300 px-3 py-2">
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('login') }}" class="text-sm text-stone-600 hover:underline">Já tenho conta</a>
            <button type="submit" class="rounded bg-stone-900 px-4 py-2 text-sm font-medium text-white hover:bg-stone-700">
                Criar conta
            </button>
        </div>
    </form>
@endsection
