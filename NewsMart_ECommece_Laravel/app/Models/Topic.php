<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    protected $table = 'topics';
    protected $primaryKey = 'id';

    // Quan hệ 1-n: Topic HAS MANY Posts
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'topicid', 'id');
    }
}