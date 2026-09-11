<?php

namespace App\Providers;

use App\Models\Usuario;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
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

        Route::resourceVerbs([
            'create' => 'criar',
            'edit'   => 'editar',
        ]);

        VerifyEmail::toMailUsing(function ($notifiable, string $url) {
            return (new MailMessage)
                ->subject(Lang::get('Verify Email Address'))
                ->line(Lang::get('Please click the button below to verify your email.'))
                ->action('Verify Email Address', $url);
        });
    }
}
