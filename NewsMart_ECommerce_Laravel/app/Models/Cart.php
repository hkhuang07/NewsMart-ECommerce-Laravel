<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';

    // Quan hệ n-1: Cart BELONGS TO User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }

    // Quan hệ n-1: Cart BELONGS TO Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productid', 'id');
    }
}