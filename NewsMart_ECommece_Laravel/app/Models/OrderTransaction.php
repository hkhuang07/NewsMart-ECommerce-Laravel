<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTransaction extends Model
{
    protected $table = 'OrderTransactions';
    protected $primaryKey = 'ID';
    
    // Quan hệ 1-1: OrderTransaction BELONGS TO Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'OrderID', 'ID');
    }
}