<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\UploadImages;
use Illuminate\Support\Facades\Gate;

class UserRepository
{
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    function getAuthenticatedUser()
    {
        $user = $this->user->with('roles')
            ->whereId(Auth::user()->id)
            ->first();

        $user->permissions = $user->getPermissionsViaRoles();

        return $user;
    }

    function store(Request $request)
    {
        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->hasFile('new_photo')) {
            $resultado = UploadImages::upload($request->new_photo, "user_id_{$user->id}_name_{$user->name}", 'users_images');
            if ($resultado != 'error') {
                $user->photo = $resultado;
                $user->save();
            }
        }

        $user->assignRole($request->get('role_id'));

        return $user;
    }

    function update(Request $request, User $user)
    {
        if (Gate::allows('edit_user') || Auth::user()->id === $user->id) {
            // Fill data
            $user->name = $request->name;
            $user->email = $request->email;
            if (Gate::allows('edit_users')) {
                $user->active = $request->active;
            }

            // Check password is present
            if ($request->filled('password')) :
                $user->password = bcrypt($request->get('password'));
            endif;

            // Assign role
            if ($request->filled('role_id')) :
                $user->roles()->detach();
                $user->assignRole($request->get('role_id'));
            endif;

            // Save user
            $user->save();

            if ($request->hasFile('new_photo')) {
                $resultado = UploadImages::upload($request->new_photo, "user_id_{$user->id}_name_{$user->name}", 'users_images');
                if ($resultado != 'error') {
                    $user->photo = $resultado;
                    $user->save();
                }
            }

            return $user;
        } else {
            return 'not authorized';
        }
        
    }
}