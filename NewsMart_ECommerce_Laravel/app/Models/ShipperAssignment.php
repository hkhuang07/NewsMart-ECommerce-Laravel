<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipperAssignment extends Model
{
    protected $table = 'shipperassignments';
    protected $primaryKey = 'id';

    // Quan hệ 1-1: ShipperAssignment BELONGS TO Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'orderid', 'id');
    }

    // Quan hệ n-1: ShipperAssignment BELONGS TO User (Shipper)
    public function shipper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shipperid', 'id');
    }
}