<?php

namespace App\Models;

use App\Traits\GlobalTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
