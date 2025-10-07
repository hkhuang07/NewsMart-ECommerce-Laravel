<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    protected $table = 'OrderStatuses';
    protected $primaryKey = 'ID';

    // Quan hệ 1-n: OrderStatus HAS MANY Orders
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'OrderStatusID', 'ID');
    }
}