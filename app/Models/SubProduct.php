<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'product_id',
        'sub_product_id',
        'code',
      'name',
      'price',
      'discount',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
