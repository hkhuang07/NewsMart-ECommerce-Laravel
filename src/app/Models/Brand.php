<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $table = 'brands'; 
    protected $primaryKey = 'id';

    // Quan hệ 1-n: Brand HAS MANY Products
	
	protected $fillable = [
	'name',
    'slug',
    'logo',
	];
		public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brandid', 'id');
    }
}