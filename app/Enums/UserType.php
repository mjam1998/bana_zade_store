<?php

namespace App\Enums;

enum UserType:int
{
    case Primary=1;
    case Regular=2;


    public function label(): string
    {
        return match ($this) {
            self::Primary  => 'فعال',
            self::Regular  => ' غیرفعال',

        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Primary => 'success',          // سبز
            self::Regular => 'danger',      // قرمز
        };
    }
}
