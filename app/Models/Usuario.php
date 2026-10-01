<?php

namespace App\Models;

use Database\Factories\UsuarioFactory;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Table(name: 'usuarios')]
#[UseFactory(UsuarioFactory::class)]
class Usuario extends Authenticatable
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = ['senha', 'lembrar_token'];

    protected function casts(): array
    {
        return ['senha' => 'hashed'];
    }

    public function getAuthPassword(): string
    {
        return $this->senha;
    }

    public function getRememberTokenName(): string
    {
        return 'lembrar_token';
    }

    public function credenciais(): array
    {
        return [
            'email' => $this->email,
            'senha' => $this->senha,
        ];
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }
}
