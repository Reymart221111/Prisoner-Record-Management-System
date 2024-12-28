<?php

namespace App\Enums;

enum PrisonerStatus: string
{
    case ACTIVE = 'active';
    case RELEASED = 'released';
    case TRANSFERRED = 'transferred';
    case DECEASED = 'deceased';
    case ESCAPED = 'escaped';

    public function getLabel(): string
    {
        return match($this) {
            self::ACTIVE => 'Currently Imprisoned',
            self::RELEASED => 'Released from Prison',
            self::TRANSFERRED => 'Transferred to Another Facility',
            self::DECEASED => 'Deceased',
            self::ESCAPED => 'Escaped from Prison'
        };
    }
}