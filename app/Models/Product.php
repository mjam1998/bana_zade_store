<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'name',
      'category_id',
      'slug',
      'code',
      'size',
      'count',
      'price',
      'discount',
      'description',
      'meta_title',
      'meta_description',
      'keywords',
      'image',
      'image_alt',
      'image_title',
        'has_sub_product'
    ];

    protected $casts = [
        'has_sub_product' => 'boolean',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
    public function subProducts()
    {
        return $this->hasMany(SubProduct::class);
    }
    protected static function booted()
    {
        static::deleting(function ($product) {
            $product->update([
                'slug'=> $product->slug . '_deleted_'.time(),
                'code'=> $product->code . '_deleted_'.time(),
            ]);
            $product->subProducts()->each(function ($subProduct) {
                $subProduct->delete();
            });
            $product->comments()->each(function ($comment) {
                $comment->delete();
            });

        });
    }
}
