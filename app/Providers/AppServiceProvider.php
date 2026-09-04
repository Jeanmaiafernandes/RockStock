<?php

namespace App\Providers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Gate::define('criarPedido', function (Usuario $usuario, Pedido $pedido) {
            return $usuario->id === $pedido->usuario_id;
        });
    }
}
