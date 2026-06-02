<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Branch\BranchInfo;
use App\Models\Order\Adjustment;
use App\Models\Order\OrderInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->morphToMany(Role::class, 'model', 'model_roles', 'model_id', 'role_id');
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'model', 'model_permissions');
    }

    public function users_permissions()
    {
        return $this->roles->map->permissions->flatten()->pluck('name')->unique();
    }

    public function users_permissions_check()
    {
        return $this->roles->map->permissions->flatten()->pluck('name');
    }

    public function hasPermission($permissionName)
    {
        // $cacheKey = "permissions_{$this->id}_{$this->getMorphClass()}";
        // $permissions = Cache::remember($cacheKey, now()->addHours(24), function () {
           
        //     $direct = $this->permissions()->pluck('name')->toArray();
            
        //     return array_unique(array_merge($direct, $viaRoles));
        // });
            return $this->users_permissions_check()->contains($permissionName);
    }

    public function branches(){
        return $this->belongsToMany(BranchInfo::class, 'branch_user', 'user_id', 'branch_info_id');
    }

    public function orders(){
        return $this->hasMany(OrderInfo::class, 'sales_person');
    }

    public function adjustments()
    {
        return $this->hasMany(Adjustment::class, 'created_by');
    }
}
