<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="email">E-mail</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email') }}" required autofocus>
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4">
            <label for="senha">Senha</label>
            <input id="senha" name="senha" type="password" required>
            @error('senha') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <label class="mt-4 inline-flex items-center">
            <input type="checkbox" name="lembrar"> <span class="ml-2">Lembrar de mim</span>
        </label>

        <div class="mt-6 flex items-center justify-between">

            <button type="submit" class="mt-4">Entrar</button>

            <a href="{{ route('registrar') }}" class="text-sm text-gray-600 hover:underline">
                Criar conta
            </a>
        </div>
    </form>
</x-guest-layout>
