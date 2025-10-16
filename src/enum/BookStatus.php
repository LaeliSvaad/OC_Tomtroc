<?php

namespace App\Enum;
enum BookStatus : string
{
    case available = 'available';
    case not_available = 'not-available';
    case reserved = 'reserved';

    public function getLabel(): string

    {

        return match($this) {

            self::available => 'Disponible',

            self::not_available => 'Non disponible',

            self::reserved => 'Réservé',

        };

    }
}