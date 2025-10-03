<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'Products';
    protected $primaryKey = 'ID';

    // Quan hệ n-1: Product BELONGS TO Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'CategoryID', 'ID');
    }

    // Quan hệ n-1: Product BELONGS TO Brand
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'BrandID', 'ID');
    }

    // Quan hệ n-1: Product BELONGS TO User (Saler)
    public function saler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'SalerID', 'ID');
    }

    // Quan hệ 1-n: Product HAS MANY ProductImages
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'ProductID', 'ID');
    }

    // Quan hệ 1-n: Product HAS MANY OrderItems
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'ProductID', 'ID');
    }

    // Quan hệ 1-n: Product HAS MANY Reviews
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'ProductID', 'ID');
    }

    // Quan hệ 1-n: Product HAS MANY Carts
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'ProductID', 'ID');
    }
    
    // Quan hệ 1-n: Product HAS MANY Posts (bài viết liên quan đến sản phẩm)
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'ProductID', 'ID');
    }

    // Quan hệ nhiều-nhiều: Product BELONGS TO MANY Users (Favorites)
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'ProductFavorites', 'ProductID', 'UserID');
    }
}