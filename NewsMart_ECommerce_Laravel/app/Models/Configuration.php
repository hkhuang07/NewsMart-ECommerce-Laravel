<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'configurations';
    protected $primaryKey = 'settingkey'; 
    public $incrementing = false; 
    protected $keyType = 'string';
}
