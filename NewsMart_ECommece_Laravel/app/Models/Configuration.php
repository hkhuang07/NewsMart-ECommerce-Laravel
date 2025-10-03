<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'Configurations';
    protected $primaryKey = 'SettingKey'; 
    public $incrementing = false; 
    protected $keyType = 'string';
}