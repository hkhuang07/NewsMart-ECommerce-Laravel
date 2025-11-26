<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    // Quan hệ n-1: Order BELONGS TO User (Customer)
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }

    // Quan hệ n-1: Order BELONGS TO User (Saler)
    public function saler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'salerid', 'id');
    }

    // Quan hệ n-1: Order BELONGS TO OrderStatus
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'orderstatusid', 'id');
    }

    // Quan hệ 1-n: Order HAS MANY OrderItems
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'orderid', 'id');
    }

    // Quan hệ 1-1: Order HAS ONE ShippingInformation
    public function shipping(): HasOne
    {
        return $this->hasOne(ShippingInformation::class, 'orderid', 'id');
    }

    // Quan hệ 1-1: Order HAS ONE OrderTransaction
    public function transaction(): HasOne
    {
        return $this->hasOne(OrderTransaction::class, 'orderid', 'id');
    }
    
    // Quan hệ 1-1: Order HAS ONE ShipperAssignment
    public function shipperAssignment(): HasOne
    {
        return $this->hasOne(ShipperAssignment::class, 'orderid', 'id');
    }
}