<?php

namespace App\Models;

use Database\Factories\ProdutoFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UseFactory(ProdutoFactory::class)]
class Produto extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'quantidade' => 'integer',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(ProdutoCategoria::class, 'produto_categoria_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ProdutoStatus::class, 'produto_status_id');
    }

    public function pedidosItens(): HasMany
    {
        return $this->hasMany(PedidoItem::class, 'produto_id');
    }

    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }

    public function enderecoDeEstoque(): BelongsTo
    {
        return $this->belongsTo(EnderecoDeEstoque::class, 'endereco_de_estoque_id');
    }
}
