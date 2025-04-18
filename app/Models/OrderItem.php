<?php

namespace App\Models;

use App\Traits\GlobalTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory, GlobalTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price_at_time'
    ];
}
