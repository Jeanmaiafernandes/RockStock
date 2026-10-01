<?php

namespace App\Models;

use App\Enums\TipoLocalEstoque;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * O TipoLocalEstoque é o nível acima do endereço. Penso numa hierarquia de dois níveis:
 *  Local é o prédio
 *  Endereço é a posição dentro do prédio.
 */
#[Table(name: 'locais_estoque')]
class LocalEstoque extends Model
{
    protected $table = 'locais_estoque';

    protected $guarded = ['id'];

    protected $casts = [
        'ativo' => 'boolean',
        'tipo' => TipoLocalEstoque::class,
    ];

    public function enderecos(): HasMany
    {
        return $this->hasMany(EnderecoDeEstoque::class, 'local_estoque_id');
    }
}
