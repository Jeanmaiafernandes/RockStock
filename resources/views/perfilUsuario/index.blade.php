@extends('layouts.app')

@section('titulo', 'Meu perfil')

@section('conteudo')
    <div class="mx-auto max-w-3xl space-y-6 px-4 py-6">

        @include('layouts.partials.flash')

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <div class="mb-4">
                <h3 class="text-base font-medium text-gray-900">Dados da conta</h3>
                <p class="mt-1 text-sm text-gray-600">Nome e e-mail usados para entrar no sistema.</p>
            </div>

            <form method="POST" action="{{ route('perfil.atualizar') }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <x-form.field label="Nome" name="nome">
                    <x-form.input
                        name="nome"
                        :value="old('nome', $usuario->nome)"
                        required
                        autocomplete="name" />
                    @error('nome', 'perfil')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </x-form.field>

                <x-form.field label="E-mail" name="email">
                    <x-form.input
                        type="email"
                        name="email"
                        :value="old('email', $usuario->email)"
                        required
                        autocomplete="username" />
                    @error('email', 'perfil')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </x-form.field>

                <div class="flex justify-end">
                    <button type="submit"
                            class="rounded bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                        Salvar alterações
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <div class="mb-4">
                <h3 class="text-base font-medium text-gray-900">Alterar senha</h3>
                <p class="mt-1 text-sm text-gray-600">Confirme a senha atual para definir uma nova.</p>
            </div>

            <form method="POST" action="{{ route('perfil.senha') }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <x-form.field label="Senha atual" name="senha_atual">
                    <x-form.input
                        type="password"
                        name="senha_atual"
                        required
                        autocomplete="current-password" />
                    @error('senha_atual', 'senha')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </x-form.field>

                <x-form.field label="Nova senha" name="senha">
                    <x-form.input
                        type="password"
                        name="senha"
                        required
                        autocomplete="new-password" />
                    @error('senha', 'senha')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </x-form.field>

                <x-form.field label="Confirmar nova senha" name="senha_confirmation">
                    <x-form.input
                        type="password"
                        name="senha_confirmation"
                        required
                        autocomplete="new-password" />
                </x-form.field>

                <div class="flex justify-end">
                    <button type="submit"
                            class="rounded bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                        Alterar senha
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
