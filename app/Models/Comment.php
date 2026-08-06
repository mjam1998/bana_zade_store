<?php

namespace App\Models;

use App\Enums\CommentStatus;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = true;
    protected $fillable = [
      'product_id',
      'name',
      'comment',
      'admin_response',
      'status'
    ];
    protected $casts=[
      'status'=>CommentStatus::class,
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
