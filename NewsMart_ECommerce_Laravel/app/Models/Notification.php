<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';

    // Quan hệ n-1: Notification BELONGS TO User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
}