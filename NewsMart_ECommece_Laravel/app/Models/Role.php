<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';

    // Quan hệ 1-n: Role HAS MANY Users
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'roleid', 'id');
    }
}