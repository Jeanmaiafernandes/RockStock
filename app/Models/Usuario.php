<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $guarded = ['id'];
 //   protected $fillable = ['nome', 'email', 'senha'];

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

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }
}
