<x-guest-layout>
    <form method="POST" action="{{ route('entrar') }}">
        @csrf
        <div>
            <label for="email">E-mail</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email') }}" required autofocus>
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4">
            <label for="password">Senha</label>
            <input id="password" name="password" type="password" required>
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <label class="mt-4 inline-flex items-center">
            <input type="checkbox" name="lembrar"> <span class="ml-2">Lembrar de mim</span>
        </label>

        <button type="submit" class="mt-4">Entrar</button>
    </form>
</x-guest-layout>
