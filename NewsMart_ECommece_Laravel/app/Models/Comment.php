<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $table = 'Comments';
    protected $primaryKey = 'ID';

    // Quan hệ n-1: Comment BELONGS TO Post
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'PostID', 'ID');
    }

    // Quan hệ n-1: Comment BELONGS TO User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID', 'ID');
    }

    // Quan hệ đệ quy (n-1): Comment BELONGS TO Parent Comment
    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'ParentCommentID', 'ID');
    }

    // Quan hệ đệ quy (1-n): Comment HAS MANY Replies
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'ParentCommentID', 'ID');
    }
}