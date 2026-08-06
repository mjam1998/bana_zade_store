<?php

namespace App\Enums;

enum CommentStatus:int
{
    case Accepted = 1;
    case Waiting = 2;
    case Rejected = 3;

    public function label(): string
    {
        return match ($this) {
            self::Accepted  => 'تایید شده',
            self::Waiting  => 'درحال بررسی',
            self::Rejected => 'تایید نشده',
        };
    }
}
