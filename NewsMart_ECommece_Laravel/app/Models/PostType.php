<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostType extends Model
{
    protected $table = 'PostTypes';
    protected $primaryKey = 'ID';

    // Quan hệ 1-n: PostType HAS MANY Posts
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'PostTypeID', 'ID');
    }
}