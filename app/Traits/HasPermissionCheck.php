<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasPermissionCheck
{
    public function hasPermission(string $permission): bool
    {
        return Auth::guard('api')->check() && Auth::guard('api')->user()->hasPermission($permission);
    }
}
