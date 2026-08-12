<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'name',
      'slug',
      'meta_title',
      'meta_description',
      'keywords',
        'image',
        'image_alt',
        'image_title',
         'is_active'

    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    protected static function booted()
    {
        static::deleting(function ($category) {
            $category->update([
                'slug'=> $category->slug . '_deleted_'.time()
            ]);
            $category->products()->each(function ($product) {
                $product->delete();
            });
        });

        static::updated(function ($category) {
            if ($category->wasChanged('is_active')) {
                $category->products()->update([
                    'is_active' => $category->is_active
                ]);
            }
        });

    }
}
