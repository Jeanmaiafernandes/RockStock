<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(name: 'produtos_tamanhos')]
class ProdutoTamanho extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'ordem' => 'integer',
    ];

    public function variacoes(): HasMany
    {
        return $this->hasMany(ProdutoVariacao::class, 'tamanho_id');
    }

    /** Tamanho::ordenados()->get() → PP, P, M, G, GG... */
    public function scopeOrdenados(Builder $query): Builder
    {
        return $query->orderBy('ordem');
    }
}
