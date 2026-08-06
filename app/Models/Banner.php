<?php

namespace App\Models;

use App\Enums\BannerType;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
      'type',
      'meta_title',
      'meta_description',
      'image',
      'image_alt',
      'image_title',
        'url'
    ];

    protected $casts = [
      'type'=>BannerType::class,
    ];

    public function getTypeNameAttribute()
    {
        return match($this->type) {
            BannerType::Slider => 'اسلایدر',
            BannerType::DiscountBanner => 'بنر تخفیف',
            BannerType::BannerOne => 'بنر یک',
            BannerType::BannerTwo => 'بنر دو',
            BannerType::BannerThree => 'بنر سه',
            BannerType::BannerFour => 'بنر چهار',
        };
    }
}
