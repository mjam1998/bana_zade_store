<?php

namespace App\Enums;

enum OrderStatus:int
{
    case WaitingSend = 0;
    case Sent = 1;
    case Cancelled = 2;

    public function label(): string
    {
        return match ($this) {
            self::WaitingSend  => 'منتظر ارسال',
            self::Sent  => ' ارسال شده',
            self::Cancelled => ' کنسل شده',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::WaitingSend => 'primary',   // آبی
            self::Sent => 'success',          // سبز
            self::Cancelled => 'danger',      // قرمز
        };
    }

}
