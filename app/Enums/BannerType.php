<?php

namespace App\Enums;

enum BannerType:int
{
    case Slider = 1;
    case DiscountBanner = 2;
    case BannerOne = 3;
    case BannerTwo = 4;
    case BannerThree = 5;
    case BannerFour = 6;

    public function label(): string
    {
        return match ($this) {
            self::Slider  => 'slider',
            self::DiscountBanner  => 'discount-banner',
            self::BannerOne  => 'banner-one',
            self::BannerTwo  => 'banner-two',
            self::BannerThree  => 'banner-three',
            self::BannerFour  => 'banner-four',

        };
    }

}
