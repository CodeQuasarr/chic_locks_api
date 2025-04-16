<?php

namespace App\Models;

use App\Traits\GlobalTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory, GlobalTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id', 'status', 'payment_intent_id', 'amount', 'payment_status', 'payment_address','payment_method',
    ];
}
