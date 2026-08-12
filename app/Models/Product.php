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
      'count',
      'base_price',
      'discount',
      'description',
      'meta_title',
      'meta_description',
      'keywords',
      'image',
      'image_alt',
      'image_title',
        'is_special',
        'is_active',
        'unit_name',
        'min_shop_count',
    ];

    protected $casts = [
        'is_special' => 'boolean',
        'is_active' => 'boolean',
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

    public function productPriceTiers()
    {
        return $this->hasMany(ProductPriceTier::class);
    }
    public function unitPriceFor(int $qty): int
    {
        $tier = $this->priceTiers()
            ->where('min_qty', '<=', $qty)
            ->where(function ($q) use ($qty) {
                $q->whereNull('max_qty')->orWhere('max_qty', '>=', $qty);
            })
            ->orderByDesc('min_qty')
            ->first();

        return $tier?->unit_price ?? $this->base_price;
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            $product->update([
                'slug'=> $product->slug . '_deleted_'.time(),
            ]);
            $product->comments()->each(function ($comment) {
                $comment->delete();
            });

        });
    }
}
