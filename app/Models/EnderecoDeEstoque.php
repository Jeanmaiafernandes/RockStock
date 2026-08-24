<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(name: 'enderecos_de_estoque')]
class EnderecoDeEstoque extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class, 'endereco_de_estoque_id');
    }
}
