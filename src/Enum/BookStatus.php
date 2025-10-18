<?php

namespace App\Enum;
enum BookStatus : string
{
    case AVAILABLE = 'available';
    case NOT_AVAILABLE = 'not-available';
    case RESERVED = 'reserved';

    public function getLabel(): string
    {
        return match($this) {
            self::AVAILABLE => 'Disponible',
            self::NOT_AVAILABLE => 'Non disponible',
            self::RESERVED => 'Réservé',
            default => 'inconnu',
        };
    }
}