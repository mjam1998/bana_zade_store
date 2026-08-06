<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
      'send_method_id',
        'code',
      'status',
      'name',
      'mobile',
      'total_amount',
      'pay_amount',
      'track_number',
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
    ];

    public function sendMethod()
    {
        return $this->belongsTo(SendMethod::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
