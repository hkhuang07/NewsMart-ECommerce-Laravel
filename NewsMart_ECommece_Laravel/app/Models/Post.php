<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $table = 'Posts';
    protected $primaryKey = 'ID';

    // Quan hệ n-1: Post BELONGS TO User (Author)
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'AuthorID', 'ID');
    }

    // Quan hệ n-1: Post BELONGS TO PostType
    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class, 'PostTypeID', 'ID');
    }

    // Quan hệ n-1: Post BELONGS TO Topic
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'TopicID', 'ID');
    }

    // Quan hệ n-1: Post BELONGS TO Product (Optional)
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ID');
    }

    // Quan hệ 1-n: Post HAS MANY Comments
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'PostID', 'ID');
    }

    // Quan hệ 1-n: Post HAS MANY PostInteractions
    public function interactions(): HasMany
    {
        return $this->hasMany(PostInteraction::class, 'PostID', 'ID');
    }
}