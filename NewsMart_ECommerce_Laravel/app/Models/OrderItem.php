<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';

    // Quan hệ n-1: OrderItem BELONGS TO Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'orderid', 'id');
    }

    // Quan hệ n-1: OrderItem BELONGS TO Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productid', 'id');
    }
}
