<x-guest-layout>
    <form method="POST" action="{{ route('registrar') }}">
        @csrf
        <div>
            <label for="nome">Nome</label>
            <input id="name" name="nome" type="text"
                   value="{{ old('nome') }}" required autofocus>
            @error('nome') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4">
            <label for="email">E-mail</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email') }}" required>
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <x-form.field label="Senha" name="senha">
            <x-form.input type="password" name="senha" required />
        </x-form.field>

        <x-form.field label="Confirmar senha" name="senha_confirmation">
            <x-form.input type="password" name="senha_confirmation" required />
        </x-form.field>

        <div class="mt-6 flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:underline">
                Já tenho conta
            </a>
            <button type="submit">Cadastrar</button>
        </div>
    </form>
</x-guest-layout>
