<?php

namespace App\Models;

use Database\Factories\ProdutoStatusFactory;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(name: 'produtos_status')]
#[UseFactory(ProdutoStatusFactory::class)]
class ProdutoStatus extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'disponivel' => 'boolean',
        'permite_saida' => 'boolean'
    ];

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }

    public function scopeDisponiveis($query)
    {
        return $query->where('disponivel', true);
    }

    public function scopePermiteSaida($query)
    {
        return $query->where('permite_saida', true);
    }
}
