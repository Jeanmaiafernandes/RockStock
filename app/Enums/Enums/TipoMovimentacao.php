<?php

namespace App\Enums\Enums;

enum TipoMovimentacao: string
{
    case Entrada = 'entrada';
    case Saida = 'saida';
    case Transf = 'transf';
    case Ajuste = 'ajuste';

    public function exigeOrigem()
    {
        return in_array($this, [self::Saida, self::Transf], true);
    }

    public function exigeDestino(): bool
    {
        return in_array($this, [self::Entrada, self::Transf], true);
    }

    public function rotulo(): string
    {
        return match ($this) {
            self::Entrada => 'Entrada',
            self::Saida   => 'Saída',
            self::Transf  => 'Transferência',
            self::Ajuste  => 'Ajuste',
        };
    }
}
