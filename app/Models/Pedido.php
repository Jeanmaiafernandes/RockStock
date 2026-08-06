<?php

namespace App\Models;

use Database\Factories\PedidoFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[UseFactory(PedidoFactory::class)]
class Pedido extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function itens(): HasMany
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::creating(static function (Pedido $pedido) {
            $pedido->codigo ??= static::gerarCodigo();
        });
    }

    public static function gerarCodigo(): string
    {
        return 'PED-'.now()->format('Ymd').'-'.Str::upper(Str::random(5));
    }
}
