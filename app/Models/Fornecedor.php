<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(name: 'fornecedores')]
class Fornecedor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class, 'fornecedor_id');
    }
}
