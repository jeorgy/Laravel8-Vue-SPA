<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUser;
use App\Http\Requests\Users\UpdateUser;
use App\Providers\RouteServiceProvider;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('permission:view_users', ['only' => ['index']]);
        $this->middleware('permission:add_users', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_users', ['only' => ['activate']]);
        $this->middleware('permission:delete_users', ['only' => ['deactivate']]);

        $this->user = $user;
    }

    public function index()
    {
        $users = User::with('roles')->isRoot(Auth::user())->get();
        return response()->json(
            [
                'status' => 'success',
                'users' => $users->toArray()
            ],
            200
        );
    }

    public function show(User $user)
    {
        $user->role_id = $user->roles[0]->id;
        return response()->json(
            [
                'status' => 'success',
                'user' => $user->toArray()
            ],
            200
        );
    }

    public function user()
    {
        $user = $this->user->getAuthenticatedUser();
        
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request  $request
     * @return \App\Models\Auth\User
     */
    protected function store(CreateUser $request)
    {
        try {
            $user = $this->user->store($request);

            return response()->json([
                'user'  =>  $user,
                'message' => 'Usuário adicionado com sucesso!'
            ], 200);
        } catch (\Exception $e) {
            Log::error("Store new user error: {$e->getMessage()}");

            return response()->json([
                'message'  =>  'Erro interno, avise o administrador!',
                'status' => 'error'
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateUser $request, User $user)
    {
        $user = $this->user->update($request, $user);

        if ($user != 'not authorized') {
            // Return to list
            return response()->json([
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'Usuário não autorizado!'
            ], 403);
        }
        

    }

    /**
     * Destroy a specified user.
     *
     * @param  \App\Models\Auth\User  $user
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([
                    'message' => 'Usuário deletado com sucesso!'
                ],200);
        } catch (\Exception $e) {
            Log::error($e);
            return back()->withError('Erro Interno no Sistema, informe o administrador!');
        }
    }
}
