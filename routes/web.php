<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
    
    
    
    Route::prefix('dashboard')->middleware(['auth'])->group(function () {
        // Users Routes
        Route::prefix('users')->group(function () {
            Route::get('index', ['as' => 'admin.users.index', 'uses' => 'App\Http\Controllers\Admin\UserController@index']);
            Route::get('create', ['as' => 'admin.users.create', 'uses' => 'App\Http\Controllers\Admin\UserController@create']);
            Route::post('store', ['as' => 'admin.users.store', 'uses' => 'App\Http\Controllers\Admin\UserController@store']);
            Route::put('edit/{user}', ['as' => 'admin.users.edit', 'uses' => 'App\Http\Controllers\Admin\UserController@edit']);
            Route::get('update/{user}', ['as' => 'admin.users.update', 'uses' => 'App\Http\Controllers\Admin\UserController@update']);
            Route::get('show/{user}', ['as' => 'admin.users.show', 'uses' => 'App\Http\Controllers\Admin\UserController@show']);
            Route::get('profile', ['as' => 'admin.users.profile', 'uses' => 'App\Http\Controllers\Admin\UserController@profile']);
            Route::put('profile', ['as' => 'admin.users.profile.update', 'uses' => 'App\Http\Controllers\Admin\UserController@updateProfile']);
            Route::get('trash', ['as' => 'admin.users.trash', 'uses' => 'App\Http\Controllers\Admin\UserController@trash']);
            Route::delete('delete/{id}', ['as' => 'admin.users.delete', 'uses' => 'App\Http\Controllers\Admin\UserController@delete']);
            Route::post('restore/{id}', ['as' => 'admin.users.restore', 'uses' => 'App\Http\Controllers\Admin\UserController@restore']);
            Route::delete('purge/{id}', ['as' => 'admin.users.purge', 'uses' => 'App\Http\Controllers\Admin\UserController@purge']);
        });
    });
});
