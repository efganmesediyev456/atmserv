<?php

namespace App\Enums;

enum TransactionType : string
{
    case ADMIN = 'admin';
    case SYSTEM = 'system';


    public function toString(): string
    {
        return match ($this) {
            self::ADMIN => 'admin',
            self::SYSTEM => 'system',
        };
    }
}