<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::pluck('name', 'id');

        return response()->json([
            'roles' => $roles
        ], 200);
    }

    public function store(Request $request)
    {
        $validate = validator($request->all(), [
            'name' => 'required|max:60|unique:roles,name',
            'details' => 'required|max:60',
            'permissions' => 'required'
        ]);

        // If fails validate
        if ($validate->fails()) :
            // Warning message
            return response()->json([
                'errors' => $validate->getMessageBag()
            ], 403);
        endif;

        // Create result
        $role = $this->roles->create($request->only('name', 'details'));

        // Assign permissions to role
        $role->syncPermissions($request->get('permissions', []));

        // Return to list
        return response()->json([
            'role' => $role
        ], 200);
    }

    public function update(Request $request, Role $role)
    {
        $validate = validator($request->all(), [
            'details' => 'required|max:60',
            'permissions' => 'required'
        ]);

        // If fails validate
        if ($validate->fails()) :
            // Warning message
            return response()->json([
                'errors' => $validate->getMessageBag()
            ], 403);
        endif;

        // Fill data
        $role->fill($request->only('details'))->save();

        // Assign permissions to role
        $role->syncPermissions($request->get('permissions', []));

        // Return to list
        return response()->json([
            'role' => $role
        ],200);
    }
}
