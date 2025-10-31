<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PostStatus extends Model
{
    protected $table = 'poststatuses';
    protected $primaryKey = 'id';

    // Quan hệ 1-n: PostStatus HAS MANY Posts
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'poststatusid', 'id');
    }
}
