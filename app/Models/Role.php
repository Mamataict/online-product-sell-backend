<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'guard_name'];
    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'model', 'model_permissions', 'model_id', 'permission_id');
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'model', 'model_roles', 'role_id', 'model_id');
    }
    
}
