<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPriceTier extends Model
{
    protected $fillable = [
      'product_id',
      'min_qty',
      'max_qty',
      'unit_price',
    ];

    protected $appends = ['discount_percent'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getDiscountPercentAttribute(): float
    {
        $base = $this->product->base_price;

        if ($base <= 0) return 0;

        return round((($base - $this->unit_price) / $base) * 100, 1);
    }

}
