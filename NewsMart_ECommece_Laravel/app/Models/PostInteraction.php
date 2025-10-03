<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostInteraction extends Model
{
    protected $table = 'PostInteractions';
    protected $primaryKey = 'ID';

    // Quan hệ n-1: PostInteraction BELONGS TO Post
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'PostID', 'ID');
    }

    // Quan hệ n-1: PostInteraction BELONGS TO User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID', 'ID');
    }
}