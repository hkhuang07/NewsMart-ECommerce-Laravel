<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostImages extends Model
{
    protected $table = 'postimages';
    protected $primaryKey = 'id';

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'postid', 'id');
    }
}
