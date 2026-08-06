<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SendMethod extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'name',
        'description',
    ];

    public function Orders()
    {
        return $this->hasMany(Order::class);
    }
}
