<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    protected $table = 'orderstatuses';
    protected $primaryKey = 'id';

    // Quan hệ 1-n: OrderStatus HAS MANY Orders
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'orderstatusid', 'id');
    }
}