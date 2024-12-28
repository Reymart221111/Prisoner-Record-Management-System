<?php

namespace App\Enums;

enum ParoleStatus:string
{
    case REGULAR = 'regular';
    case MEDICAL = 'medical';

    public function getLabel(): string
    {
        return match($this)
        {
            self::REGULAR => 'Regular Parole',
            self::MEDICAL => 'Medical Parole',
        };
    }

}