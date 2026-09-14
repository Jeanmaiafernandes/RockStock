<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

#[UseModel(Usuario::class)]
class UsuarioFactory extends Factory
{
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
}
