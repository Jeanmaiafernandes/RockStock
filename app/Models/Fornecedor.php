<?php

namespace App\Models;

use App\Models\Produto\Produto;
use Database\Factories\FornecedorFactory;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(name: 'fornecedores')]
#[UseFactory(FornecedorFactory::class)]
class Fornecedor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class, 'fornecedor_id');
    }
}
