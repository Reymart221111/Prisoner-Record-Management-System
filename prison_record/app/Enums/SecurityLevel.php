<?php

namespace App\Enums;

enum SecurityLevel: string
{
    case MINIMUM = 'minimum';
    case MEDIUM = 'medium';
    case MAXIMUM = 'maximum';
    case SUPERMAX = 'supermax';

    public function getLabel(): string
    {
        return match($this) {
            self::MINIMUM => 'Minimum Security',
            self::MEDIUM => 'Medium Security',
            self::MAXIMUM => 'Maximum Security',
            self::SUPERMAX => 'Super-Maximum Security'
        };
    }
}