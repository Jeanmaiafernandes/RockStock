<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];

    protected $hidden = [
        'senha',
        'lembrar_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'senha'             => 'hashed',
        ];
    }

    public function getAuthPassword(): ?string
    {
        return $this->senha;
    }

    public function getRememberTokenName(): string
    {
        return 'lembrar_token';
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }
}
