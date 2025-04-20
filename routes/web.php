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

        //Edificio Routes
        Route::prefix('edificio')->group(function () {
            Route::get('index', ['as' => 'admin.edificio.index', 'uses' => 'App\Http\Controllers\Admin\EdificioController@index']);
            Route::get('create', ['as' => 'admin.edificio.create', 'uses' => 'App\Http\Controllers\Admin\EdificioController@create']);
            Route::post('store', ['as' => 'admin.edificio.store', 'uses' => 'App\Http\Controllers\Admin\EdificioController@store']);
            Route::get('edit/{id}', ['as' => 'admin.edificio.edit', 'uses' => 'App\Http\Controllers\Admin\EdificioController@edit']);
            Route::put('update/{id}', ['as' => 'admin.edificio.update', 'uses' => 'App\Http\Controllers\Admin\EdificioController@update']);
            Route::get('destroy/{id}', ['as' => 'admin.edificio.destroy', 'uses' => 'App\Http\Controllers\Admin\EdificioController@destroy']);
            Route::get('trash', ['as' => 'admin.edificio.trash', 'uses' => 'App\Http\Controllers\Admin\EdificioController@trash']);
            Route::post('restore/{id}', ['as' => 'admin.edificio.restore', 'uses' => 'App\Http\Controllers\Admin\EdificioController@restore']);
            Route::delete('purge/{id}', ['as' => 'admin.edificio.purge', 'uses' => 'App\Http\Controllers\Admin\EdificioController@purge']);
        });

        //Unidade Routes
        Route::prefix('unidade')->group(function () {
            Route::get('index', ['as' => 'admin.unidade.index', 'uses' => 'App\Http\Controllers\Admin\UnidadeController@index']);
            Route::get('create', ['as' => 'admin.unidade.create', 'uses' => 'App\Http\Controllers\Admin\UnidadeController@create']);
            Route::post('store', ['as' => 'admin.unidade.store', 'uses' => 'App\Http\Controllers\Admin\UnidadeController@store']);
            Route::get('edit/{id}', ['as' => 'admin.unidade.edit', 'uses' => 'App\Http\Controllers\Admin\UnidadeController@edit']);
            Route::put('update/{id}', ['as' => 'admin.unidade.update', 'uses' => 'App\Http\Controllers\Admin\UnidadeController@update']);
            Route::get('destroy/{id}', ['as' => 'admin.unidade.destroy', 'uses' => 'App\Http\Controllers\Admin\UnidadeController@destroy']);
            Route::get('trash', ['as' => 'admin.unidade.trash', 'uses' => 'App\Http\Controllers\Admin\UnidadeController@trash']);
            Route::post('restore/{id}', ['as' => 'admin.unidade.restore', 'uses' => 'App\Http\Controllers\Admin\UnidadeController@restore']);
            Route::delete('purge/{id}', ['as' => 'admin.unidade.purge', 'uses' => 'App\Http\Controllers\Admin\UnidadeController@purge']);
        });

        //Departamento Routes
        Route::prefix('departamento')->group(function () {
            Route::get('index', ['as' => 'admin.departamento.index', 'uses' => 'App\Http\Controllers\Admin\DepartamentoController@index']);
            Route::get('create', ['as' => 'admin.departamento.create', 'uses' => 'App\Http\Controllers\Admin\DepartamentoController@create']);
            Route::post('store', ['as' => 'admin.departamento.store', 'uses' => 'App\Http\Controllers\Admin\DepartamentoController@store']);
            Route::get('edit/{id}', ['as' => 'admin.departamento.edit', 'uses' => 'App\Http\Controllers\Admin\DepartamentoController@edit']);
            Route::put('update/{id}', ['as' => 'admin.departamento.update', 'uses' => 'App\Http\Controllers\Admin\DepartamentoController@update']);
            Route::get('destroy/{id}', ['as' => 'admin.departamento.destroy', 'uses' => 'App\Http\Controllers\Admin\DepartamentoController@destroy']);
            Route::get('trash', ['as' => 'admin.departamento.trash', 'uses' => 'App\Http\Controllers\Admin\DepartamentoController@trash']);
            Route::post('restore/{id}', ['as' => 'admin.departamento.restore', 'uses' => 'App\Http\Controllers\Admin\DepartamentoController@restore']);
            Route::delete('purge/{id}', ['as' => 'admin.departamento.purge', 'uses' => 'App\Http\Controllers\Admin\DepartamentoController@purge']);
        });

        //Funcionario Routes
        Route::prefix('funcionario')->group(function () {
            Route::get('index', ['as' => 'admin.funcionario.index', 'uses' => 'App\Http\Controllers\Admin\FuncionarioController@index']);
            Route::get('create', ['as' => 'admin.funcionario.create', 'uses' => 'App\Http\Controllers\Admin\FuncionarioController@create']);
            Route::post('store', ['as' => 'admin.funcionario.store', 'uses' => 'App\Http\Controllers\Admin\FuncionarioController@store']);
            Route::get('edit/{id}', ['as' => 'admin.funcionario.edit', 'uses' => 'App\Http\Controllers\Admin\FuncionarioController@edit']);
            Route::put('update/{id}', ['as' => 'admin.funcionario.update', 'uses' => 'App\Http\Controllers\Admin\FuncionarioController@update']);
            Route::get('destroy/{id}', ['as' => 'admin.funcionario.destroy', 'uses' => 'App\Http\Controllers\Admin\FuncionarioController@destroy']);
            Route::get('trash', ['as' => 'admin.funcionario.trash', 'uses' => 'App\Http\Controllers\Admin\FuncionarioController@trash']);
            Route::post('restore/{id}', ['as' => 'admin.funcionario.restore', 'uses' => 'App\Http\Controllers\Admin\FuncionarioController@restore']);
            Route::delete('purge/{id}', ['as' => 'admin.funcionario.purge', 'uses' => 'App\Http\Controllers\Admin\FuncionarioController@purge']);
        });
    });
});
