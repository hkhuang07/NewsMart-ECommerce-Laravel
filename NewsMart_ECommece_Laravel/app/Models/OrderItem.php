<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $table = 'OrderItems';
    protected $primaryKey = 'ID';

    // Quan hệ n-1: OrderItem BELONGS TO Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'OrderID', 'ID');
    }

    // Quan hệ n-1: OrderItem BELONGS TO Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ID');
    }
}
