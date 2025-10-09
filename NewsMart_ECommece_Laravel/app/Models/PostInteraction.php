<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostInteraction extends Model
{
    protected $table = 'postinteractions';
    protected $primaryKey = 'id';

    // Quan hệ n-1: PostInteraction BELONGS TO Post
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'postid', 'id');
    }

    // Quan hệ n-1: PostInteraction BELONGS TO User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
}