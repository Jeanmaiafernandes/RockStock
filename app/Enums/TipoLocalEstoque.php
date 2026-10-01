<?php

namespace App\Enums;

enum TipoLocalEstoque: string
{
    case Cd = 'cd';
    case Loja = 'loja';

    public function rotulo(): string
    {
        return match ($this) {
            self::Cd   => 'Centro de distribuição',
            self::Loja => 'Loja',
        };
    }

    // Lista para o select: ['cd' => 'Centro de distribuição', 'loja' => 'Loja']
    public static function opcoes(): array
    {
        return [
            self::Cd->value   => self::Cd->rotulo(),
            self::Loja->value => self::Loja->rotulo(),
        ];
    }
}
