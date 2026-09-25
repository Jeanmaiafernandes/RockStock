<?php

namespace App\Models;

use Database\Factories\ProdutoFactory;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Table(name: 'produtos')]
#[UseFactory(ProdutoFactory::class)]
class Produto extends Model
{
    protected $table = 'produtos';

    protected $guarded = ['id'];

    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(ProdutoCategoria::class, 'produto_categoria_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ProdutoStatus::class, 'produto_status_id');
    }

    public function variacoes(): HasMany
    {
        return $this->hasMany(ProdutoVariacao::class, 'produto_id');
    }

    public function gerarGrade(array $cores, array $tamanhoIds): int
    {
        $tamanhos = ProdutoTamanho::whereIn('id', $tamanhoIds)->orderBy('ordem')->get();
        $criadas = 0;

        foreach ($cores as $cor) {
            foreach ($tamanhos as $tamanho) {
                $sku = $this->montarSku($cor, $tamanho->nome);

                // Se o SKU já existe, essa combinação foi criada antes
                if (ProdutoVariacao::where('sku', $sku)->exists()) {
                    continue;
                }

                $variacao = new ProdutoVariacao();
                $variacao->produto_id = $this->id;
                $variacao->tamanho_id = $tamanho->id;
                $variacao->cor = $cor;
                $variacao->sku = $sku;
                $variacao->ativo = true;
                $variacao->save();

                $criadas++;
            }
        }

        return $criadas;
    }

    /**
     * Monta o SKU no formato REFERENCIA-COR-TAMANHO.
     * Ex.: CAM-0142 + "Azul marinho" + "GG" = CAM-0142-AZULMARINHO-GG
     */
    public function montarSku(string $cor, string $tamanho): string
    {
        return $this->referencia . '-' . $this->limparTexto($cor) . '-' . $this->limparTexto($tamanho);
    }

    private function limparTexto(string $texto): string
    {
        $texto = Str::ascii($texto);
        $texto = strtoupper($texto);
        return preg_replace('/[^A-Z0-9]/', '', $texto);
    }
}
