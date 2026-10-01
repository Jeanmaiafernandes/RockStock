<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('enderecos_de_estoque')]
class EnderecoDeEstoque extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'ativo' => 'boolean',
    ];

   public const TIPOS = [
        'doca'        => 'Doca',
        'armazenagem' => 'Armazenagem',
        'bloqueado'   => 'Bloqueado',
        'avaria'      => 'Avaria',
        'devolucao'   => 'Devolução',
    ];

    public function local(): BelongsTo
    {
        return $this->belongsTo(LocalEstoque::class, 'local_estoque_id');
    }

    // Verifica se o endereço já aparece em alguma movimentação
    public function temMovimentacoes(): bool
    {
        return MovimentacaoEstoque::where('endereco_origem_id', $this->id)
            ->orWhere('endereco_destino_id', $this->id)
            ->exists();
    }
}
