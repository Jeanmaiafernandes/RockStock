<?php

namespace App\Models;

use Database\Factories\PedidoItemFactory;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(name: 'pedidos_itens')]
#[UseFactory(PedidoItemFactory::class)]
class PedidoItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }
}
