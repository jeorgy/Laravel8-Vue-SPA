<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\ToDoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('register', [UserController::class, 'store'])->name('register');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::get('refresh', [LoginController::class, 'refresh'])->name('refresh');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        // Users Routes
        Route::get('user', [UserController::class, 'user'])->name('users.user');
        Route::prefix('users')->group(function() {
            Route::get('', [UserController::class, 'index'])->name('users');
            Route::post('store', [UserController::class, 'store'])->name('users.store');
            Route::get('{user}', [UserController::class, 'show'])->name('users.show');
            Route::post('update/{user}', [UserController::class, 'update'])->name('users.update')->where('user', '[0-9]+');
            Route::post('destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy')->where('user', '[0-9]+');
        });
        // Roles Routes
        Route::prefix('roles')->group(function () {
            Route::get('', [RoleController::class, 'index'])->name('roles.list');
            Route::post('store',[RoleController::class, 'store'])->name('roles.store');
            Route::post('update/{role}', [RoleController::class, 'update'])->name('roles.update')->where('role', '[0-9]+');
        });
        // ToDos Routes
        Route::prefix('to-dos')->group(function () {
            Route::get('', [ToDoController::class, 'index'])->name('todos.list');
            Route::get('not-completed', [ToDoController::class, 'notCompleted'])->name('todos.list');
            Route::post('store',[ToDoController::class, 'store'])->name('todos.store');
            Route::post('update/{toDo}', [ToDoController::class, 'update'])->name('todos.update')->where('toDo', '[0-9]+');
            Route::post('destroy/{toDo}', [ToDoController::class, 'destroy'])->name('todos.destroy')->where('toDo', '[0-9]+');
            Route::post('completed/{toDo}', [ToDoController::class, 'completed'])->name('todos.completed')->where('toDo', '[0-9]+');
        });
    });
});
