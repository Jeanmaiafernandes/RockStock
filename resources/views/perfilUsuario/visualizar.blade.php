@extends('layouts.app')

@section('titulo', $usuario->nome)

@section('conteudo')
<div class="mx-auto max-w-3xl space-y-6 px-4 py-6">

    <a href="{{ route('perfil.index') }}" class="text-sm text-gray-600 hover:underline">
        Voltar para usuários
    </a>

    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-base font-medium text-gray-900">Dados</h3>

        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-medium text-gray-500">Nome</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $usuario->nome }}</dd>
            </div>

            <div>
                <dt class="text-xs font-medium text-gray-500">E-mail</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $usuario->email }}</dd>
            </div>

            <div>
                <dt class="text-xs font-medium text-gray-500">Cadastrado em</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    {{ $usuario->created_at?->format('d/m/Y H:i') ?? '—' }}
                </dd>
            </div>

            <div>
                <dt class="text-xs font-medium text-gray-500">Pedidos</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $usuario->pedidos->count() }}</dd>
            </div>
        </dl>
    </div>

    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-base font-medium text-gray-900">Últimos pedidos</h3>

        @forelse ($usuario->pedidos as $pedido)
        <div class="flex items-center justify-between border-b border-gray-100 py-2 last:border-0">
            <a href="{{ route('pedidos.show', $pedido) }}" class="text-sm text-gray-900 hover:underline">
                Pedido #{{ $pedido->id }}
            </a>

            <span class="text-sm text-gray-500">
                        {{ $pedido->created_at?->format('d/m/Y') }}
                    </span>
        </div>
        @empty
        <p class="text-sm text-gray-500">Este usuário ainda não abriu pedidos.</p>
        @endforelse
    </div>

</div>
@endsection
