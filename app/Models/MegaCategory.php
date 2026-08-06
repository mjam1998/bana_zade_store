<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MegaCategory extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'name',
    ];

    public function superCategories(){
        return $this->hasMany(SuperCategory::class);
    }

    protected static function booted()
    {
        static::deleting(function ($megaCategory) {
            $megaCategory->superCategories()->each(function ($superCategory) {
                $superCategory->delete();
            });
        });
    }
}
