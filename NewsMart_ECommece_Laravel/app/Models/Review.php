<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $table = 'Reviews';
    protected $primaryKey = 'ID';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID', 'ID');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ID');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'OrderID', 'ID');
    }
}