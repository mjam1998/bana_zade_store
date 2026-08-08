<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoBanner extends Model
{
    protected $fillable=[
      'video_mp4',
      'video_webm',
      'image',
      'image_alt',
      'meta_description',
      'page_title',
    ];
}
