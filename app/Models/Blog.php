<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
       'title',
       'slug',
       'description',
        'image',
        'image_alt',
        'image_title',
        'meta_description',
        'meta_title',
        'keywords'
    ];
}
