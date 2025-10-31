<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostType extends Model
{
    protected $table = 'posttypes';
    protected $primaryKey = 'id';

    // Quan hệ 1-n: PostType HAS MANY Posts
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'posttypeid', 'id');
    }
}