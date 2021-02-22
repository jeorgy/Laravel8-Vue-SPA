<?php

namespace App\Models\Auth;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'details',
        'guard_name'
    ];

    /**
     * Scopes
     */
    public function scopeByUser($query, $currentUser)
    {
        $query->orderBy('id', 'ASC');

        // If user in role root
        if (!$currentUser->hasRole('root')) {
            $query->where('name', '!=', 'root');
        }

        return $query;
    }

    /**
     * Accesors
     */
}
