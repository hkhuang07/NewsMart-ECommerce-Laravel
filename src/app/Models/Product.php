<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';


    protected $fillable = [
        'categoryid',
        'brandid',
        'salerid',
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'stockquantity',
        'discount',
        'averragerate',
        'favorites',
        'purchases',
        'views',
        'isactive',


    ];

    // Quan hệ n-1: Product BELONGS TO Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categoryid', 'id');
    }

    // Quan hệ n-1: Product BELONGS TO Brand
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brandid', 'id');
    }

    // Quan hệ n-1: Product BELONGS TO User (Saler)
    public function saler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'salerid', 'id');
    }

    // Quan hệ 1-n: Product HAS MANY ProductImages
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'productid', 'id');
    }

    public function avatar(): HasOne
    {
        return $this->hasOne(ProductImage::class, 'productid', 'id')
            ->where('ismainimage', true)
            ->latest();
    }
    // Quan hệ 1-n: Product HAS MANY OrderItems
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'productid', 'id');
    }

    // Quan hệ 1-n: Product HAS MANY Reviews
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'productid', 'id');
    }
    public function mainImage()
    {
        // hasOne(Model liên quan, 'foreign_key')
        return $this->hasOne(ProductImage::class, 'productid')
            // Thêm điều kiện để đảm bảo chỉ lấy ảnh chính
            ->where('ismainimage', true);
    }
    // Quan hệ 1-n: Product HAS MANY Carts
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'productid', 'id');
    }

    // Quan hệ 1-n: Product HAS MANY Posts (bài viết liên quan đến sản phẩm)
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'productid', 'id');
    }

    // Quan hệ nhiều-nhiều: Product BELONGS TO MANY Users (Favorites)
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'productfavorites', 'productid', 'userid');
    }
}
