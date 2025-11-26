<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
    protected $table = 'useractivities';
    protected $primaryKey = 'id';

    // Quan hệ n-1: UserActivity BELONGS TO User
    // Khóa ngoại userid có thể NULL (ON DELETE SET NULL)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
    
}