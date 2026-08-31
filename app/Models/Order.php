<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
      'user_id',
        'code',
      'status',
      'name',
      'mobile',
      'total_amount',
      'pay_amount',
      'description',
      'state',
      'city',
      'address',
      'postal_code',
      'is_paid',
      'authority',
      'ref_id',
      'send_at',
      'paid_at',
    ];

    protected $casts = [
       'status' => OrderStatus::class,
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
