<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productid', 'id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'orderid', 'id');
    }
}