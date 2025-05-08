@extends('admin.layouts.body')
@section('title', 'Relatórios')
@section('conteudo')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Relatórios</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Moradores</h5>
                                <p class="card-text">Informações sobre os moradores do condomínio</p>
                                <a href="{{ route('pdf.morador.index') }}" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Unidades</h5>
                                <p class="card-text">Informações sobre as unidades do condomínio</p>
                                <a href="{{ route('pdf.unidade.index') }}" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Acessos</h5>
                                <p class="card-text">Registro de acessos ao condomínio</p>
                                <a href="{{ route('pdf.acesso.index') }}" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Despesas</h5>
                                <p class="card-text">Despesas registradas do condomínio</p>
                                <a href="{{ route('pdf.despesa.index') }}" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Inadimplência</h5>
                                <p class="card-text">Faturas pendentes de pagamento</p>
                                <a href="{{ route('pdf.inadimplencia.index') }}" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Pagamentos</h5>
                                <p class="card-text">Histórico de pagamentos realizados</p>
                                <a href="{{ route('pdf.pagamento.index') }}" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Visitantes</h5>
                                <p class="card-text">Registro de visitantes do condomínio</p>
                                <a href="{{ route('pdf.visitante.index') }}" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Funcionários</h5>
                                <p class="card-text">Informações sobre os funcionários</p>
                                <a href="{{ route('pdf.funcionario') }}" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection