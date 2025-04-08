<?php

namespace App\Models;

use App\Traits\GlobalTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, GlobalTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'slug',
        'stock',
        'active',
        'image',
        'category_id',
        'rating',
    ];
}
