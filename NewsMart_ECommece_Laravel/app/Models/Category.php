<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $table = 'Categories';
    protected $primaryKey = 'ID';

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'CategoryID', 'ID');
    }

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'ParentID', 'ID');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'ParentID', 'ID');
    }
}