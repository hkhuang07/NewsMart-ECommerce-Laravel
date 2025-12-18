<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';

    // Quan hệ n-1: Post BELONGS TO User (Author)
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'authorid', 'id');
    }

    // Quan hệ n-1: Post BELONGS TO PostType
    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class, 'posttypeid', 'id');
    }

    // Quan hệ n-1: Post BELONGS TO PostStatus
    public function postStatus(): BelongsTo
    {
        return $this->belongsTo(PostStatus::class, 'poststatusid', 'id');
    }

    // Quan hệ n-1: Post BELONGS TO Topic
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'topicid', 'id');
    }

    // Quan hệ n-1: Post BELONGS TO Product (Optional)
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productid', 'id');
    }

    // Quan hệ 1-n: Post HAS MANY Comments
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'postid', 'id');
    }

    // Quan hệ 1-n: Post HAS MANY PostInteractions
    public function interactions(): HasMany
    {
        return $this->hasMany(PostInteraction::class, 'postid', 'id');
    }
}