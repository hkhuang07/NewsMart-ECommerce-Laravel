<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFavorite extends Model
{
    protected $table = 'ProductFavorites';
   
    public $timestamps = false; 
    protected $primaryKey = ['UserID', 'ProductID'];
    public $incrementing = false;
}