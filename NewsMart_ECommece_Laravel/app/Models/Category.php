<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'categoryid', 'id');
    }

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parentid', 'id');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parentid', 'id');
    }
}