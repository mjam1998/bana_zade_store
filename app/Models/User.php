<?php

namespace App\Models;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles,softDeletes;
    protected  $fillable=[
        'name',
        'mobile',
        'type',
        'password'
    ];

    protected $casts=[
      'type'=>UserType::class,
    ];
}
