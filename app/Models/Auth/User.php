<?php

namespace App\Models\Auth;

use App\Models\ToDos\ToDo;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory,
        Notifiable,
        HasRoles,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $guard_name = 'api';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Scopes
     */
    public function scopeIsRoot($query, $user)
    {
        if (!$user->hasRole('root')) {
            return $query->whereHas('roles', function ($q) {
                $q->where('name', '<>', 'root');
            });
        }
    }

    /**
     * Relations
     */
    public function toDos()
    {
        return $this->hasMany(ToDo::class);
    }

    /**
     * JWT Interface
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Mutators
     */
    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])->format('d/m/Y H:i:s');
    }

    public function getUpdatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])->format('d/m/Y H:i:s');
    }

    public function getPhotoAttribute()
    {
        return $this->attributes['photo'] ? $this->attributes['photo'] : '/images/avatar.svg';
    }
}
