<?php

namespace App\Models\Auth;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = [
        'name',
        'details',
        'guard_name'
    ];

    /**
     * Accesors
     */
}
