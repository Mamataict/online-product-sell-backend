<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'description', 'guard_name'];

    public function roles()
    {
        return $this->morphedByMany(Role::class, 'model', 'model_permissions', 'permission_id', 'model_id');
    }
}
