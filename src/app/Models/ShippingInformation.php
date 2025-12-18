<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingInformation extends Model
{
    protected $table = 'shippinginformation';
    protected $primaryKey = 'id';

    // Quan hệ 1-1: ShippingInformation BELONGS TO Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'orderid', 'id');
    }
}