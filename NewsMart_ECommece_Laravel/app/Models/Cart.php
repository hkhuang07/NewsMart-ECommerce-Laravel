<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $table = 'Carts';
    protected $primaryKey = 'ID';

    // Quan hệ n-1: Cart BELONGS TO User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID', 'ID');
    }

    // Quan hệ n-1: Cart BELONGS TO Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ID');
    }
}