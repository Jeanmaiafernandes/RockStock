<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    protected static ?string $senha = null;

    public function definition(): array
    {
        return [
            'nome'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'senha'             => static::$senha ??= Hash::make('password'),
            'lembrar_token'     => Str::random(10),
        ];
    }

//    public function naoVerificado(): static
//    {
//        return $this->state(fn (array $attributes) => [
//            'email_verified_at' => null,
//        ]);
//    }
}
