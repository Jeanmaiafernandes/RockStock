<?php

namespace App\Models;

use Database\Factories\ProdutoCategoriaFactory;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Table(name: 'produtos_categorias')]
#[UseFactory(produtoCategoriaFactory::class)]
class ProdutoCategoria extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

//    public function Ativo()
//    {
//        return $this->produtos()->where('ativo', true);
//    }
}
