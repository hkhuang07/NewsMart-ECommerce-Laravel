<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
    protected $table = 'UserActivities';
    protected $primaryKey = 'ID';

    // Quan hệ n-1: UserActivity BELONGS TO User
    // Khóa ngoại UserID có thể NULL (ON DELETE SET NULL)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID', 'ID');
    }
}