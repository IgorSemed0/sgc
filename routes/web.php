<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Morador\PerfilController;

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('home', function () {
    return redirect(route('morador.feed'));
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    Route::prefix('dashboard')->middleware(['auth'])->group(function () {
        Route::middleware(['admin'])->group(function () {
            Route::get('index', ['as' => 'admin.home.index', 'uses' => 'App\Http\Controllers\Admin\HomeController@index']);
            Route::get('/', ['as' => 'admin.home.index', 'uses' => 'App\Http\Controllers\Admin\HomeController@index']);        
            Route::get('/', ['as' => 'dashboard', 'uses' => 'App\Http\Controllers\Admin\HomeController@index']);        
    
            // User Routes
            Route::prefix('user')->group(function () {
                Route::get('index', ['as' => 'admin.user.index', 'uses' => 'App\Http\Controllers\Admin\UserController@index']);
                Route::get('create', ['as' => 'admin.user.create', 'uses' => 'App\Http\Controllers\Admin\UserController@create']);
                Route::post('store', ['as' => 'admin.user.store', 'uses' => 'App\Http\Controllers\Admin\UserController@store']);
                Route::get('edit/{id}', ['as' => 'admin.user.edit', 'uses' => 'App\Http\Controllers\Admin\UserController@edit']);
                Route::put('update/{id}', ['as' => 'admin.user.update', 'uses' => 'App\Http\Controllers\Admin\UserController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.user.destroy', 'uses' => 'App\Http\Controllers\Admin\UserController@destroy']);
                Route::get('trash', ['as' => 'admin.user.trash', 'uses' => 'App\Http\Controllers\Admin\UserController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.user.restore', 'uses' => 'App\Http\Controllers\Admin\UserController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.user.purge', 'uses' => 'App\Http\Controllers\Admin\UserController@purge']);
            });
    
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

            Route::prefix('morador')->group(function () {
                Route::get('index', ['as' => 'admin.morador.index', 'uses' => 'App\Http\Controllers\Admin\MoradorController@index']);
                Route::get('create', ['as' => 'admin.morador.create', 'uses' => 'App\Http\Controllers\Admin\MoradorController@create']);
                Route::post('store', ['as' => 'admin.morador.store', 'uses' => 'App\Http\Controllers\Admin\MoradorController@store']);
                Route::get('edit/{id}', ['as' => 'admin.morador.edit', 'uses' => 'App\Http\Controllers\Admin\MoradorController@edit']);
                Route::put('update/{id}', ['as' => 'admin.morador.update', 'uses' => 'App\Http\Controllers\Admin\MoradorController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.morador.destroy', 'uses' => 'App\Http\Controllers\Admin\MoradorController@destroy']);
                Route::get('trash', ['as' => 'admin.morador.trash', 'uses' => 'App\Http\Controllers\Admin\MoradorController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.morador.restore', 'uses' => 'App\Http\Controllers\Admin\MoradorController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.morador.purge', 'uses' => 'App\Http\Controllers\Admin\MoradorController@purge']);
            });

            Route::prefix('visitante')->group(function () {
                Route::get('index', ['as' => 'admin.visitante.index', 'uses' => 'App\Http\Controllers\Admin\VisitanteController@index']);
                Route::get('create', ['as' => 'admin.visitante.create', 'uses' => 'App\Http\Controllers\Admin\VisitanteController@create']);
                Route::post('store', ['as' => 'admin.visitante.store', 'uses' => 'App\Http\Controllers\Admin\VisitanteController@store']);
                Route::get('edit/{id}', ['as' => 'admin.visitante.edit', 'uses' => 'App\Http\Controllers\Admin\VisitanteController@edit']);
                Route::put('update/{id}', ['as' => 'admin.visitante.update', 'uses' => 'App\Http\Controllers\Admin\VisitanteController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.visitante.destroy', 'uses' => 'App\Http\Controllers\Admin\VisitanteController@destroy']);
                Route::get('trash', ['as' => 'admin.visitante.trash', 'uses' => 'App\Http\Controllers\Admin\VisitanteController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.visitante.restore', 'uses' => 'App\Http\Controllers\Admin\VisitanteController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.visitante.purge', 'uses' => 'App\Http\Controllers\Admin\VisitanteController@purge']);
            });
    
            Route::prefix('acesso')->group(function () {
                Route::get('index', ['as' => 'admin.acesso.index', 'uses' => 'App\Http\Controllers\Admin\AcessoController@index']);
                Route::get('create', ['as' => 'admin.acesso.create', 'uses' => 'App\Http\Controllers\Admin\AcessoController@create']);
                Route::post('store', ['as' => 'admin.acesso.store', 'uses' => 'App\Http\Controllers\Admin\AcessoController@store']);
                Route::get('edit/{id}', ['as' => 'admin.acesso.edit', 'uses' => 'App\Http\Controllers\Admin\AcessoController@edit']);
                Route::put('update/{id}', ['as' => 'admin.acesso.update', 'uses' => 'App\Http\Controllers\Admin\AcessoController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.acesso.destroy', 'uses' => 'App\Http\Controllers\Admin\AcessoController@destroy']);
                Route::get('trash', ['as' => 'admin.acesso.trash', 'uses' => 'App\Http\Controllers\Admin\AcessoController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.acesso.restore', 'uses' => 'App\Http\Controllers\Admin\AcessoController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.acesso.purge', 'uses' => 'App\Http\Controllers\Admin\AcessoController@purge']);
            });
    
            Route::prefix('factura')->group(function () {
                Route::get('index', ['as' => 'admin.factura.index', 'uses' => 'App\Http\Controllers\Admin\FacturaController@index']);
                Route::get('create', ['as' => 'admin.factura.create', 'uses' => 'App\Http\Controllers\Admin\FacturaController@create']);
                Route::post('store', ['as' => 'admin.factura.store', 'uses' => 'App\Http\Controllers\Admin\FacturaController@store']);
                Route::get('edit/{id}', ['as' => 'admin.factura.edit', 'uses' => 'App\Http\Controllers\Admin\FacturaController@edit']);
                Route::put('update/{id}', ['as' => 'admin.factura.update', 'uses' => 'App\Http\Controllers\Admin\FacturaController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.factura.destroy', 'uses' => 'App\Http\Controllers\Admin\FacturaController@destroy']);
                Route::get('trash', ['as' => 'admin.factura.trash', 'uses' => 'App\Http\Controllers\Admin\FacturaController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.factura.restore', 'uses' => 'App\Http\Controllers\Admin\FacturaController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.factura.purge', 'uses' => 'App\Http\Controllers\Admin\FacturaController@purge']);
            });
    
            // FacturaItem Routes
            Route::prefix('factura-item')->group(function () {
                Route::get('index', ['as' => 'admin.factura-item.index', 'uses' => 'App\Http\Controllers\Admin\FacturaItemController@index']);
                Route::get('create', ['as' => 'admin.factura-item.create', 'uses' => 'App\Http\Controllers\Admin\FacturaItemController@create']);
                Route::post('store', ['as' => 'admin.factura-item.store', 'uses' => 'App\Http\Controllers\Admin\FacturaItemController@store']);
                Route::get('edit/{id}', ['as' => 'admin.factura-item.edit', 'uses' => 'App\Http\Controllers\Admin\FacturaItemController@edit']);
                Route::put('update/{id}', ['as' => 'admin.factura-item.update', 'uses' => 'App\Http\Controllers\Admin\FacturaItemController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.factura-item.destroy', 'uses' => 'App\Http\Controllers\Admin\FacturaItemController@destroy']);
                Route::get('trash', ['as' => 'admin.factura-item.trash', 'uses' => 'App\Http\Controllers\Admin\FacturaItemController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.factura-item.restore', 'uses' => 'App\Http\Controllers\Admin\FacturaItemController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.factura-item.purge', 'uses' => 'App\Http\Controllers\Admin\FacturaItemController@purge']);
            });
    
            // Pagamento Routes
            Route::prefix('pagamento')->group(function () {
                Route::get('index', ['as' => 'admin.pagamento.index', 'uses' => 'App\Http\Controllers\Admin\PagamentoController@index']);
                Route::get('create', ['as' => 'admin.pagamento.create', 'uses' => 'App\Http\Controllers\Admin\PagamentoController@create']);
                Route::post('store', ['as' => 'admin.pagamento.store', 'uses' => 'App\Http\Controllers\Admin\PagamentoController@store']);
                Route::get('edit/{id}', ['as' => 'admin.pagamento.edit', 'uses' => 'App\Http\Controllers\Admin\PagamentoController@edit']);
                Route::put('update/{id}', ['as' => 'admin.pagamento.update', 'uses' => 'App\Http\Controllers\Admin\PagamentoController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.pagamento.destroy', 'uses' => 'App\Http\Controllers\Admin\PagamentoController@destroy']);
                Route::get('trash', ['as' => 'admin.pagamento.trash', 'uses' => 'App\Http\Controllers\Admin\PagamentoController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.pagamento.restore', 'uses' => 'App\Http\Controllers\Admin\PagamentoController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.pagamento.purge', 'uses' => 'App\Http\Controllers\Admin\PagamentoController@purge']);
            });
            
            // Despesa Routes
            Route::prefix('despesa')->group(function () {
                Route::get('index', ['as' => 'admin.despesa.index', 'uses' => 'App\Http\Controllers\Admin\DespesaController@index']);
                Route::get('create', ['as' => 'admin.despesa.create', 'uses' => 'App\Http\Controllers\Admin\DespesaController@create']);
                Route::post('store', ['as' => 'admin.despesa.store', 'uses' => 'App\Http\Controllers\Admin\DespesaController@store']);
                Route::get('edit/{id}', ['as' => 'admin.despesa.edit', 'uses' => 'App\Http\Controllers\Admin\DespesaController@edit']);
                Route::put('update/{id}', ['as' => 'admin.despesa.update', 'uses' => 'App\Http\Controllers\Admin\DespesaController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.despesa.destroy', 'uses' => 'App\Http\Controllers\Admin\DespesaController@destroy']);
                Route::get('trash', ['as' => 'admin.despesa.trash', 'uses' => 'App\Http\Controllers\Admin\DespesaController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.despesa.restore', 'uses' => 'App\Http\Controllers\Admin\DespesaController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.despesa.purge', 'uses' => 'App\Http\Controllers\Admin\DespesaController@purge']);
            });
            
            // Conta Routes
            Route::prefix('conta')->group(function () {
                Route::get('index', ['as' => 'admin.conta.index', 'uses' => 'App\Http\Controllers\Admin\ContaController@index']);
                Route::get('create', ['as' => 'admin.conta.create', 'uses' => 'App\Http\Controllers\Admin\ContaController@create']);
                Route::post('store', ['as' => 'admin.conta.store', 'uses' => 'App\Http\Controllers\Admin\ContaController@store']);
                Route::get('edit/{id}', ['as' => 'admin.conta.edit', 'uses' => 'App\Http\Controllers\Admin\ContaController@edit']);
                Route::put('update/{id}', ['as' => 'admin.conta.update', 'uses' => 'App\Http\Controllers\Admin\ContaController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.conta.destroy', 'uses' => 'App\Http\Controllers\Admin\ContaController@destroy']);
                Route::get('trash', ['as' => 'admin.conta.trash', 'uses' => 'App\Http\Controllers\Admin\ContaController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.conta.restore', 'uses' => 'App\Http\Controllers\Admin\ContaController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.conta.purge', 'uses' => 'App\Http\Controllers\Admin\ContaController@purge']);
            });
            
            // Movimento Routes
            Route::prefix('movimento')->group(function () {
                Route::get('index', ['as' => 'admin.movimento.index', 'uses' => 'App\Http\Controllers\Admin\MovimentoController@index']);
                Route::get('create', ['as' => 'admin.movimento.create', 'uses' => 'App\Http\Controllers\Admin\MovimentoController@create']);
                Route::post('store', ['as' => 'admin.movimento.store', 'uses' => 'App\Http\Controllers\Admin\MovimentoController@store']);
                Route::get('edit/{id}', ['as' => 'admin.movimento.edit', 'uses' => 'App\Http\Controllers\Admin\MovimentoController@edit']);
                Route::put('update/{id}', ['as' => 'admin.movimento.update', 'uses' => 'App\Http\Controllers\Admin\MovimentoController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.movimento.destroy', 'uses' => 'App\Http\Controllers\Admin\MovimentoController@destroy']);
                Route::get('trash', ['as' => 'admin.movimento.trash', 'uses' => 'App\Http\Controllers\Admin\MovimentoController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.movimento.restore', 'uses' => 'App\Http\Controllers\Admin\MovimentoController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.movimento.purge', 'uses' => 'App\Http\Controllers\Admin\MovimentoController@purge']);
            });
            
            // Rupe Routes
            Route::prefix('rupe')->group(function () {
                Route::get('index', ['as' => 'admin.rupe.index', 'uses' => 'App\Http\Controllers\Admin\RupeController@index']);
                Route::get('create', ['as' => 'admin.rupe.create', 'uses' => 'App\Http\Controllers\Admin\RupeController@create']);
                Route::post('store', ['as' => 'admin.rupe.store', 'uses' => 'App\Http\Controllers\Admin\RupeController@store']);
                Route::get('edit/{id}', ['as' => 'admin.rupe.edit', 'uses' => 'App\Http\Controllers\Admin\RupeController@edit']);
                Route::put('update/{id}', ['as' => 'admin.rupe.update', 'uses' => 'App\Http\Controllers\Admin\RupeController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.rupe.destroy', 'uses' => 'App\Http\Controllers\Admin\RupeController@destroy']);
                Route::get('trash', ['as' => 'admin.rupe.trash', 'uses' => 'App\Http\Controllers\Admin\RupeController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.rupe.restore', 'uses' => 'App\Http\Controllers\Admin\RupeController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.rupe.purge', 'uses' => 'App\Http\Controllers\Admin\RupeController@purge']);
            });
            
            // Votacao Routes
            Route::prefix('votacao')->group(function () {
                Route::get('index', ['as' => 'admin.votacao.index', 'uses' => 'App\Http\Controllers\Admin\VotacaoController@index']);
                Route::get('create', ['as' => 'admin.votacao.create', 'uses' => 'App\Http\Controllers\Admin\VotacaoController@create']);
                Route::post('store', ['as' => 'admin.votacao.store', 'uses' => 'App\Http\Controllers\Admin\VotacaoController@store']);
                Route::get('edit/{id}', ['as' => 'admin.votacao.edit', 'uses' => 'App\Http\Controllers\Admin\VotacaoController@edit']);
                Route::put('update/{id}', ['as' => 'admin.votacao.update', 'uses' => 'App\Http\Controllers\Admin\VotacaoController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.votacao.destroy', 'uses' => 'App\Http\Controllers\Admin\VotacaoController@destroy']);
                Route::get('trash', ['as' => 'admin.votacao.trash', 'uses' => 'App\Http\Controllers\Admin\VotacaoController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.votacao.restore', 'uses' => 'App\Http\Controllers\Admin\VotacaoController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.votacao.purge', 'uses' => 'App\Http\Controllers\Admin\VotacaoController@purge']);
            });
            
            // OpcaoVotacao Routes
            Route::prefix('opcao-votacao')->group(function () {
                Route::get('index', ['as' => 'admin.opcao-votacao.index', 'uses' => 'App\Http\Controllers\Admin\OpcaoVotacaoController@index']);
                Route::get('create', ['as' => 'admin.opcao-votacao.create', 'uses' => 'App\Http\Controllers\Admin\OpcaoVotacaoController@create']);
                Route::post('store', ['as' => 'admin.opcao-votacao.store', 'uses' => 'App\Http\Controllers\Admin\OpcaoVotacaoController@store']);
                Route::get('edit/{id}', ['as' => 'admin.opcao-votacao.edit', 'uses' => 'App\Http\Controllers\Admin\OpcaoVotacaoController@edit']);
                Route::put('update/{id}', ['as' => 'admin.opcao-votacao.update', 'uses' => 'App\Http\Controllers\Admin\OpcaoVotacaoController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.opcao-votacao.destroy', 'uses' => 'App\Http\Controllers\Admin\OpcaoVotacaoController@destroy']);
                Route::get('trash', ['as' => 'admin.opcao-votacao.trash', 'uses' => 'App\Http\Controllers\Admin\OpcaoVotacaoController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.opcao-votacao.restore', 'uses' => 'App\Http\Controllers\Admin\OpcaoVotacaoController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.opcao-votacao.purge', 'uses' => 'App\Http\Controllers\Admin\OpcaoVotacaoController@purge']);
            });
            
            // Voto Routes
            Route::prefix('voto')->group(function () {
                Route::get('index', ['as' => 'admin.voto.index', 'uses' => 'App\Http\Controllers\Admin\VotoController@index']);
                Route::get('create', ['as' => 'admin.voto.create', 'uses' => 'App\Http\Controllers\Admin\VotoController@create']);
                Route::post('store', ['as' => 'admin.voto.store', 'uses' => 'App\Http\Controllers\Admin\VotoController@store']);
                Route::get('edit/{id}', ['as' => 'admin.voto.edit', 'uses' => 'App\Http\Controllers\Admin\VotoController@edit']);
                Route::put('update/{id}', ['as' => 'admin.voto.update', 'uses' => 'App\Http\Controllers\Admin\VotoController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.voto.destroy', 'uses' => 'App\Http\Controllers\Admin\VotoController@destroy']);
                Route::get('trash', ['as' => 'admin.voto.trash', 'uses' => 'App\Http\Controllers\Admin\VotoController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.voto.restore', 'uses' => 'App\Http\Controllers\Admin\VotoController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.voto.purge', 'uses' => 'App\Http\Controllers\Admin\VotoController@purge']);
            });
                        // EspacoComum Routes
            Route::prefix('espaco-comum')->group(function () {
                Route::get('index', ['as' => 'admin.espaco-comum.index', 'uses' => 'App\Http\Controllers\Admin\EspacoComumController@index']);
                Route::get('create', ['as' => 'admin.espaco-comum.create', 'uses' => 'App\Http\Controllers\Admin\EspacoComumController@create']);
                Route::post('store', ['as' => 'admin.espaco-comum.store', 'uses' => 'App\Http\Controllers\Admin\EspacoComumController@store']);
                Route::get('edit/{id}', ['as' => 'admin.espaco-comum.edit', 'uses' => 'App\Http\Controllers\Admin\EspacoComumController@edit']);
                Route::put('update/{id}', ['as' => 'admin.espaco-comum.update', 'uses' => 'App\Http\Controllers\Admin\EspacoComumController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.espaco-comum.destroy', 'uses' => 'App\Http\Controllers\Admin\EspacoComumController@destroy']);
                Route::get('trash', ['as' => 'admin.espaco-comum.trash', 'uses' => 'App\Http\Controllers\Admin\EspacoComumController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.espaco-comum.restore', 'uses' => 'App\Http\Controllers\Admin\EspacoComumController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.espaco-comum.purge', 'uses' => 'App\Http\Controllers\Admin\EspacoComumController@purge']);
            });
            
            // EspacoReserva Routes
            Route::prefix('espaco-reserva')->group(function () {
                Route::get('index', ['as' => 'admin.espaco-reserva.index', 'uses' => 'App\Http\Controllers\Admin\EspacoReservaController@index']);
                Route::get('create', ['as' => 'admin.espaco-reserva.create', 'uses' => 'App\Http\Controllers\Admin\EspacoReservaController@create']);
                Route::post('store', ['as' => 'admin.espaco-reserva.store', 'uses' => 'App\Http\Controllers\Admin\EspacoReservaController@store']);
                Route::get('edit/{id}', ['as' => 'admin.espaco-reserva.edit', 'uses' => 'App\Http\Controllers\Admin\EspacoReservaController@edit']);
                Route::put('update/{id}', ['as' => 'admin.espaco-reserva.update', 'uses' => 'App\Http\Controllers\Admin\EspacoReservaController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.espaco-reserva.destroy', 'uses' => 'App\Http\Controllers\Admin\EspacoReservaController@destroy']);
                Route::get('trash', ['as' => 'admin.espaco-reserva.trash', 'uses' => 'App\Http\Controllers\Admin\EspacoReservaController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.espaco-reserva.restore', 'uses' => 'App\Http\Controllers\Admin\EspacoReservaController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.espaco-reserva.purge', 'uses' => 'App\Http\Controllers\Admin\EspacoReservaController@purge']);
            });
            
            // ChatPost Routes
            Route::prefix('chat-post')->group(function () {
                Route::get('index', ['as' => 'admin.chat-post.index', 'uses' => 'App\Http\Controllers\Admin\ChatPostController@index']);
                Route::get('create', ['as' => 'admin.chat-post.create', 'uses' => 'App\Http\Controllers\Admin\ChatPostController@create']);
                Route::post('store', ['as' => 'admin.chat-post.store', 'uses' => 'App\Http\Controllers\Admin\ChatPostController@store']);
                Route::get('edit/{id}', ['as' => 'admin.chat-post.edit', 'uses' => 'App\Http\Controllers\Admin\ChatPostController@edit']);
                Route::put('update/{id}', ['as' => 'admin.chat-post.update', 'uses' => 'App\Http\Controllers\Admin\ChatPostController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.chat-post.destroy', 'uses' => 'App\Http\Controllers\Admin\ChatPostController@destroy']);
                Route::get('trash', ['as' => 'admin.chat-post.trash', 'uses' => 'App\Http\Controllers\Admin\ChatPostController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.chat-post.restore', 'uses' => 'App\Http\Controllers\Admin\ChatPostController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.chat-post.purge', 'uses' => 'App\Http\Controllers\Admin\ChatPostController@purge']);
            });
            
            // ChatComentario Routes
            Route::prefix('chat-comentario')->group(function () {
                Route::get('index', ['as' => 'admin.chat-comentario.index', 'uses' => 'App\Http\Controllers\Admin\ChatComentarioController@index']);
                Route::get('create', ['as' => 'admin.chat-comentario.create', 'uses' => 'App\Http\Controllers\Admin\ChatComentarioController@create']);
                Route::post('store', ['as' => 'admin.chat-comentario.store', 'uses' => 'App\Http\Controllers\Admin\ChatComentarioController@store']);
                Route::get('edit/{id}', ['as' => 'admin.chat-comentario.edit', 'uses' => 'App\Http\Controllers\Admin\ChatComentarioController@edit']);
                Route::put('update/{id}', ['as' => 'admin.chat-comentario.update', 'uses' => 'App\Http\Controllers\Admin\ChatComentarioController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.chat-comentario.destroy', 'uses' => 'App\Http\Controllers\Admin\ChatComentarioController@destroy']);
                Route::get('trash', ['as' => 'admin.chat-comentario.trash', 'uses' => 'App\Http\Controllers\Admin\ChatComentarioController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.chat-comentario.restore', 'uses' => 'App\Http\Controllers\Admin\ChatComentarioController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.chat-comentario.purge', 'uses' => 'App\Http\Controllers\Admin\ChatComentarioController@purge']);
            });
            
            // Notificacao Routes
            Route::prefix('notificacao')->group(function () {
                Route::get('index', ['as' => 'admin.notificacao.index', 'uses' => 'App\Http\Controllers\Admin\NotificacaoController@index']);
                Route::get('create', ['as' => 'admin.notificacao.create', 'uses' => 'App\Http\Controllers\Admin\NotificacaoController@create']);
                Route::post('store', ['as' => 'admin.notificacao.store', 'uses' => 'App\Http\Controllers\Admin\NotificacaoController@store']);
                Route::get('edit/{id}', ['as' => 'admin.notificacao.edit', 'uses' => 'App\Http\Controllers\Admin\NotificacaoController@edit']);
                Route::put('update/{id}', ['as' => 'admin.notificacao.update', 'uses' => 'App\Http\Controllers\Admin\NotificacaoController@update']);
                Route::get('destroy/{id}', ['as' => 'admin.notificacao.destroy', 'uses' => 'App\Http\Controllers\Admin\NotificacaoController@destroy']);
                Route::get('trash', ['as' => 'admin.notificacao.trash', 'uses' => 'App\Http\Controllers\Admin\NotificacaoController@trash']);
                Route::post('restore/{id}', ['as' => 'admin.notificacao.restore', 'uses' => 'App\Http\Controllers\Admin\NotificacaoController@restore']);
                Route::delete('purge/{id}', ['as' => 'admin.notificacao.purge', 'uses' => 'App\Http\Controllers\Admin\NotificacaoController@purge']);
            });

        });
    });

    Route::prefix('morador')->middleware(['auth'])->group(function () {
        Route::get('feed', ['as' => 'morador.feed', 'uses' => 'App\Http\Controllers\Morador\FeedController@index']);
        Route::post('feed/comment', ['as' => 'morador.feed.comment', 'uses' => 'App\Http\Controllers\Morador\FeedController@comment']);
        Route::get('feed/search', ['as' => 'morador.feed.search', 'uses' => 'App\Http\Controllers\Morador\FeedController@search']);
        Route::get('votacao', ['as' => 'morador.votacao', 'uses' => 'App\Http\Controllers\Morador\VotacaoController@index']);
        Route::post('votacao/vote', ['as' => 'morador.votacao.vote', 'uses' => 'App\Http\Controllers\Morador\VotacaoController@vote']);
        Route::get('votacao/search', ['as' => 'morador.votacao.search', 'uses' => 'App\Http\Controllers\Morador\VotacaoController@search']); // Nova rota
        Route::get('/morador/perfil', [PerfilController::class, 'index'])->name('morador.perfil');
        Route::put('/morador/perfil', [PerfilController::class, 'update'])->name('morador.perfil.update');
        Route::post('/morador/perfil/update-password', [PerfilController::class, 'updatePassword'])->name('morador.perfil.updatePassword');
        Route::get('/morador/perfil/two-factor-qr-code', [PerfilController::class, 'twoFactorQrCode'])->name('morador.perfil.twoFactorQrCode');
        Route::post('/morador/perfil/confirm-two-factor', [PerfilController::class, 'confirmTwoFactor'])->name('morador.perfil.confirmTwoFactor');
        Route::post('/morador/perfil/show-recovery-codes', [PerfilController::class, 'showRecoveryCodes'])->name('morador.perfil.showRecoveryCodes');
        Route::post('/morador/perfil/disable-two-factor', [PerfilController::class, 'disableTwoFactor'])->name('morador.perfil.disableTwoFactor');
        Route::post('/morador/perfil/logout-other-sessions', [PerfilController::class, 'logoutOtherSessions'])->name('morador.perfil.logoutOtherSessions');
        Route::post('/morador/perfil/delete-account', [PerfilController::class, 'deleteAccount'])->name('morador.perfil.deleteAccount');
    });

    Route::prefix('portaria')->middleware(['auth', 'admin'])->group(function () {
        Route::get('index', ['as' => 'portaria.index', 'uses' => 'App\Http\Controllers\Portaria\PortariaController@index']);
        Route::post('search', ['as' => 'portaria.search', 'uses' => 'App\Http\Controllers\Portaria\PortariaController@search']);
        Route::post('access', ['as' => 'portaria.access', 'uses' => 'App\Http\Controllers\Portaria\PortariaController@registerAccess']);
        Route::post('visitante/store', ['as' => 'portaria.visitante.store', 'uses' => 'App\Http\Controllers\Portaria\PortariaController@storeVisitante']);
    });

    Route::prefix('pdf')->middleware(['auth', 'admin'])->group(function () {
        Route::get('index', ['as' => 'pdf.index', 'uses' => 'App\Http\Controllers\Admin\PdfController@index']);
        Route::get('morador', ['as' => 'pdf.morador.index', 'uses' => 'App\Http\Controllers\Admin\PdfController@morador']);
        Route::get('unidade', ['as' => 'pdf.unidade.index', 'uses' => 'App\Http\Controllers\Admin\PdfController@unidade']);
        Route::get('acesso', ['as' => 'pdf.acesso.index', 'uses' => 'App\Http\Controllers\Admin\PdfController@acesso']);
        Route::get('despesa', ['as' => 'pdf.despesa.index', 'uses' => 'App\Http\Controllers\Admin\PdfController@despesa']);
        Route::get('inadimplencia', ['as' => 'pdf.inadimplencia.index', 'uses' => 'App\Http\Controllers\Admin\PdfController@inadimplencia']);
        Route::get('pagamento', ['as' => 'pdf.pagamento.index', 'uses' => 'App\Http\Controllers\Admin\PdfController@pagamento']);
        Route::get('visitante', ['as' => 'pdf.visitante.index', 'uses' => 'App\Http\Controllers\Admin\PdfController@visitante']);
        Route::get('funcionario', ['as' => 'pdf.funcionario', 'uses' => 'App\Http\Controllers\Admin\PdfController@funcionario']);
    });
});