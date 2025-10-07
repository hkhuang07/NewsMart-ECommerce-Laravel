<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $table = 'Brands'; 
    protected $primaryKey = 'ID';

    // Quan hệ 1-n: Brand HAS MANY Products
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'BrandID', 'ID');
    }
}