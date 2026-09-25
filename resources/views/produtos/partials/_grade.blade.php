@php
    $referenciaFixa ??= null;
    $skusExistentes ??= [];
    $configGrade = [
        'cores'          => array_values(old('cores', [])),
        'marcados'       => array_map('strval', old('tamanhos', [])),
        'tamanhos'       => $tamanhos->map(fn ($t) => ['id' => (string) $t->id, 'nome' => $t->nome])->values(),
        'referencia'     => $referenciaFixa ?? old('referencia', ''),
        'referenciaFixa' => (bool) $referenciaFixa,
        'existentes'     => array_values($skusExistentes),
    ];
@endphp

<div x-data="gradeProduto(@js($configGrade))"
     @input.window="if (!referenciaFixa && $event.target.name === 'referencia') referencia = $event.target.value"
     class="space-y-5">

    {{-- Cores --}}
    <div>
        <label for="nova-cor" class="block text-sm font-medium text-gray-700">Cores</label>
        <p class="mt-0.5 text-xs text-gray-500">Digite uma cor e pressione Enter.</p>

        <div class="mt-2 flex flex-wrap items-center gap-2 rounded-lg border border-gray-300 px-2 py-2
                    focus-within:border-violet-500 focus-within:ring-1 focus-within:ring-violet-500">
            <template x-for="(cor, i) in cores" :key="cor">
                <span class="inline-flex items-center gap-1 rounded-md bg-violet-50 px-2 py-1 text-sm text-violet-700">
                    <span x-text="cor"></span>
                    <button type="button" @click="removerCor(i)"
                            class="rounded text-violet-400 hover:text-violet-700"
                            aria-label="'Remover ' + cor">&times;</button>
                    <input type="hidden" name="cores[]" value="cor">
                </span>
            </template>

            <input id="nova-cor" type="text" x-model="novaCor" maxlength="50"
                   @keydown.enter.prevent="adicionarCor()"
                   @keydown.comma.prevent="adicionarCor()"
                   @blur="adicionarCor()"
                   placeholder="Ex.: Preto"
                   class="min-w-[8rem] flex-1 border-0 p-1 text-sm focus:outline-none focus:ring-0">
        </div>

        @error('cores') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        @error('cores.*') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Tamanhos --}}
    <fieldset>
        <legend class="block text-sm font-medium text-gray-700">Tamanhos</legend>

        @if ($tamanhos->isEmpty())
            <p class="mt-2 text-sm text-gray-500">
                Nenhum tamanho cadastrado.
                <a href="{{ route('tamanhos.create') }}" class="font-medium text-violet-600 hover:underline">Cadastrar tamanhos</a>
            </p>
        @else
            <div class="mt-2 flex flex-wrap gap-2">
                @foreach ($tamanhos as $tamanho)
                    <label class="cursor-pointer">
                        <input type="checkbox" name="tamanhos[]" value="{{ $tamanho->id }}"
                               x-model="marcados" class="peer sr-only">
                        <span class="inline-flex min-w-[3rem] justify-center rounded-lg border border-gray-300 px-3 py-1.5 text-sm text-gray-700
                                     peer-checked:border-violet-600 peer-checked:bg-violet-600 peer-checked:text-white
                                     peer-focus-visible:ring-2 peer-focus-visible:ring-violet-500 peer-focus-visible:ring-offset-1">
                            {{ $tamanho->nome }}
                        </span>
                    </label>
                @endforeach
            </div>
        @endif

        @error('tamanhos') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        @error('tamanhos.*') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
    </fieldset>

    {{-- Prévia --}}
    <div class="rounded-lg bg-gray-50 px-4 py-3 text-sm" aria-live="polite">
        <template x-if="skus.length === 0">
            <p class="text-gray-500">Escolha ao menos uma cor e um tamanho para ver os SKUs.</p>
        </template>

        <template x-if="skus.length > 0">
            <div>
                <p class="font-medium text-gray-700">
                    <span x-text="novos"></span>
                    <span x-text="novos === 1 ? 'SKU será criado' : 'SKUs serão criados'"></span>
                    <template x-if="skus.length > novos">
                        <span class="font-normal text-gray-500">
                            (<span x-text="skus.length - novos"></span> já existe<span x-show="skus.length - novos > 1">m</span>)
                        </span>
                    </template>
                </p>
                <ul class="mt-2 flex flex-wrap gap-1.5">
                    <template x-for="s in skus.slice(0, 12)" :key="s.sku">
                        <li class="rounded px-1.5 py-0.5 font-mono text-xs"
                            class="s.existe ? 'bg-gray-200 text-gray-400 line-through' : 'bg-white text-gray-700 ring-1 ring-gray-200'"
                            x-text="s.sku"></li>
                    </template>
                    <template x-if="skus.length > 12">
                        <li class="px-1.5 py-0.5 text-xs text-gray-500">e mais <span x-text="skus.length - 12"></span></li>
                    </template>
                </ul>
            </div>
        </template>
    </div>
</div>

@once
    <script>
        function gradeProduto(config) {
            return {
                cores: config.cores,
                marcados: config.marcados,
                tamanhos: config.tamanhos,
                referencia: config.referencia,
                referenciaFixa: config.referenciaFixa,
                existentes: config.existentes,
                novaCor: '',

                adicionarCor() {
                    const cor = this.novaCor.trim().replace(/\s+/g, ' ');
                    const repetida = this.cores.some(c => c.toLowerCase() === cor.toLowerCase());
                    if (cor && !repetida) this.cores.push(cor);
                    this.novaCor = '';
                },

                removerCor(indice) {
                    this.cores.splice(indice, 1);
                },

                normalizar(texto) {
                    return String(texto)
                        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                        .toUpperCase().replace(/[^A-Z0-9]/g, '');
                },

                get skus() {
                    const ref = String(this.referencia).trim().toUpperCase() || 'REF';
                    const tamanhos = this.tamanhos.filter(t => this.marcados.includes(t.id));
                    const lista = [];
                    for (const cor of this.cores) {
                        for (const t of tamanhos) {
                            const sku = `${ref}-${this.normalizar(cor)}-${this.normalizar(t.nome)}`;
                            lista.push({ sku, existe: this.existentes.includes(sku) });
                        }
                    }
                    return lista;
                },

                get novos() {
                    return this.skus.filter(s => !s.existe).length;
                },
            };
        }
    </script>
@endonce
