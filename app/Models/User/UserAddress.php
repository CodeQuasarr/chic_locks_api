<?php

namespace App\Models\User;

use App\Traits\GlobalTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    /** @use HasFactory<\Database\Factories\User\UserAddressFactory> */
    use HasFactory, GlobalTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'street', 'city', 'post_code', 'country', 'user_id', 'is_default'
    ];
}
