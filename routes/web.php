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
        //Condominio Routes
        Route::prefix('condominio')->group(function () {
            Route::get('index', ['as' => 'admin.condominio.index', 'uses' => 'App\Http\Controllers\Admin\CondominioController@index']);
            Route::get('create', ['as' => 'admin.condominio.create', 'uses' => 'App\Http\Controllers\Admin\CondominioController@create']);
            Route::post('store', ['as' => 'admin.condominio.store', 'uses' => 'App\Http\Controllers\Admin\CondominioController@store']);
            Route::get('edit/{id}', ['as' => 'admin.condominio.edit', 'uses' => 'App\Http\Controllers\Admin\CondominioController@edit']);
            Route::put('update/{id}', ['as' => 'admin.condominio.update', 'uses' => 'App\Http\Controllers\Admin\CondominioController@update']);
            Route::get('destroy/{id}', ['as' => 'admin.condominio.destroy', 'uses' => 'App\Http\Controllers\Admin\CondominioController@destroy']);
            Route::get('trash', ['as' => 'admin.condominio.trash', 'uses' => 'App\Http\Controllers\Admin\CondominioController@trash']);
            Route::post('restore/{id}', ['as' => 'admin.condominio.restore', 'uses' => 'App\Http\Controllers\Admin\CondominioController@restore']);
            Route::delete('purge/{id}', ['as' => 'admin.condominio.purge', 'uses' => 'App\Http\Controllers\Admin\CondominioController@purge']);
        });

        //Bloco Routes
        Route::prefix('bloco')->group(function () {
            Route::get('index', ['as' => 'admin.bloco.index', 'uses' => 'App\Http\Controllers\Admin\BlocoController@index']);
            Route::get('create', ['as' => 'admin.bloco.create', 'uses' => 'App\Http\Controllers\Admin\BlocoController@create']);
            Route::post('store', ['as' => 'admin.bloco.store', 'uses' => 'App\Http\Controllers\Admin\BlocoController@store']);
            Route::get('edit/{id}', ['as' => 'admin.bloco.edit', 'uses' => 'App\Http\Controllers\Admin\BlocoController@edit']);
            Route::put('update/{id}', ['as' => 'admin.bloco.update', 'uses' => 'App\Http\Controllers\Admin\BlocoController@update']);
            Route::get('destroy/{id}', ['as' => 'admin.bloco.destroy', 'uses' => 'App\Http\Controllers\Admin\BlocoController@destroy']);
            Route::get('trash', ['as' => 'admin.bloco.trash', 'uses' => 'App\Http\Controllers\Admin\BlocoController@trash']);
            Route::post('restore/{id}', ['as' => 'admin.bloco.restore', 'uses' => 'App\Http\Controllers\Admin\BlocoController@restore']);
            Route::delete('purge/{id}', ['as' => 'admin.bloco.purge', 'uses' => 'App\Http\Controllers\Admin\BlocoController@purge']);
        });
    });
});
