<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuperCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'mega_category_id'
    ];

    public function megaCategory(){
        return $this->belongsTo(MegaCategory::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    protected static function booted()
    {
        static::deleting(function ($superCategory) {
            $superCategory->categories()->each(function ($category) {
                $category->delete();
            });
        });
    }
}
