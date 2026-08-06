@php
    $mensagens = [
        'sucesso' => ['bg' => 'border-emerald-200 bg-emerald-50 text-emerald-800'],
        'erro'    => ['bg' => 'border-red-200 bg-red-50 text-red-800'],
        'aviso'   => ['bg' => 'border-amber-200 bg-amber-50 text-amber-800'],
        'status'  => ['bg' => 'border-blue-200 bg-blue-50 text-blue-800'],
    ];
@endphp

@foreach ($mensagens as $chave => $estilo)
    @if (session($chave))
        <div x-data="{ visivel: true }" x-show="visivel"
             class="flex items-start gap-3 rounded-lg border px-4 py-3 text-sm {{ $estilo['bg'] }}">
            <p class="flex-1">{{ session($chave) }}</p>

            <button type="button" x-on:click="visivel = false" class="shrink-0 opacity-60 hover:opacity-100">
                &times;
            </button>
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        <p class="font-medium">
            {{ $errors->count() === 1 ? 'Corrija o erro abaixo:' : 'Corrija os erros abaixo:' }}
        </p>

        <ul class="mt-1 list-inside list-disc">
            @foreach ($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif
