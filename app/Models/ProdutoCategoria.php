<?php

namespace App\Models;

use Database\Factories\ProdutoCategoriaFactory;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Table(name: 'produtos_categorias')]
#[UseFactory(produtoCategoriaFactory::class)]
class ProdutoCategoria extends Model
{
    use HasFactory;

    protected function test(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => 'teste',
            set: fn($value) => $value,
        );
    }

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public function ativas()
    {
        return $this->produtos()->where('ativo', true);
    }
}
