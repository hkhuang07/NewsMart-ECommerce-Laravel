<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'id';
	protected $fillable = [
        'productid', 
        'url',        // CẬP NHẬT TỪ 'path'
        'ismainimage', // CẬP NHẬT TỪ 'is_primary'
    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productid', 'id');
    }
}