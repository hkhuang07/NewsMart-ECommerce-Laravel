<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';

    // Quan hệ n-1: Comment BELONGS TO Post
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'postid', 'id');
    }

    // Quan hệ n-1: Comment BELONGS TO User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }

    // Quan hệ đệ quy (n-1): Comment BELONGS TO Parent Comment
    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parentcommentid', 'id');
    }

    // Quan hệ đệ quy (1-n): Comment HAS MANY Replies
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parentcommentid', 'id');
    }
}