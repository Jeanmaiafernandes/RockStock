<x-guest-layout>
    <form method="POST" action="{{ route('registrar') }}">
        @csrf
        <div>
            <label for="name">Nome</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name') }}" required autofocus>
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4">
            <label for="email">E-mail</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email') }}" required>
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4">
            <label for="password">Senha</label>
            <input id="password" name="password" type="password" required>
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4">
            <label for="password_confirmation">Confirmar senha</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required>
            {{-- o erro de confirmação aparece no campo 'password', pela regra 'confirmed' --}}
        </div>

        <div class="mt-6 flex items-center justify-between">
            <a href="{{ route('entrar') }}" class="text-sm text-gray-600 hover:underline">
                Já tenho conta
            </a>
            <button type="submit">Cadastrar</button>
        </div>
    </form>
</x-guest-layout>
