<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFavorite extends Model
{
    protected $table = 'productfavorites';

    public $timestamps = false;
    protected $primaryKey = ['userid', 'productid'];
    public $incrementing = false;
}