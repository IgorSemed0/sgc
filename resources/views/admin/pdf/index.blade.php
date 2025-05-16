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
                    <!-- Moradores -->
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Moradores</h5>
                                <p class="card-text">Informações sobre os moradores do condomínio</p>
                                <select id="period-morador" class="form-control mb-2">
                                    <option value="all">Todos</option>
                                    <option value="week">Última Semana</option>
                                    <option value="month">Último Mês</option>
                                    <option value="year">Último Ano</option>
                                </select>
                                <a href="#" onclick="generatePdf('morador', document.getElementById('period-morador').value)" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>

                    <!-- Unidades -->
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Unidades</h5>
                                <p class="card-text">Informações sobre as unidades do condomínio</p>
                                <select id="period-unidade" class="form-control mb-2">
                                    <option value="all">Todos</option>
                                    <option value="week">Última Semana</option>
                                    <option value="month">Último Mês</option>
                                    <option value="year">Último Ano</option>
                                </select>
                                <a href="#" onclick="generatePdf('unidade', document.getElementById('period-unidade').value)" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>

                    <!-- Acessos -->
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Acessos</h5>
                                <p class="card-text">Registro de acessos ao condomínio</p>
                                <select id="period-acesso" class="form-control mb-2">
                                    <option value="all">Todos</option>
                                    <option value="week">Última Semana</option>
                                    <option value="month">Último Mês</option>
                                    <option value="year">Último Ano</option>
                                </select>
                                <a href="#" onclick="generatePdf('acesso', document.getElementById('period-acesso').value)" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>

                    <!-- Despesas -->
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Despesas</h5>
                                <p class="card-text">Despesas registradas do condomínio</p>
                                <select id="period-despesa" class="form-control mb-2">
                                    <option value="all">Todos</option>
                                    <option value="week">Última Semana</option>
                                    <option value="month">Último Mês</option>
                                    <option value="year">Último Ano</option>
                                </select>
                                <a href="#" onclick="generatePdf('despesa', document.getElementById('period-despesa').value)" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>

                    <!-- Inadimplência -->
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Inadimplência</h5>
                                <p class="card-text">Faturas pendentes de pagamento</p>
                                <select id="period-inadimplencia" class="form-control mb-2">
                                    <option value="all">Todos</option>
                                    <option value="week">Última Semana</option>
                                    <option value="month">Último Mês</option>
                                    <option value="year">Último Ano</option>
                                </select>
                                <a href="#" onclick="generatePdf('inadimplencia', document.getElementById('period-inadimplencia').value)" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>

                    <!-- Pagamentos -->
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Pagamentos</h5>
                                <p class="card-text">Histórico de pagamentos realizados</p>
                                <select id="period-pagamento" class="form-control mb-2">
                                    <option value="all">Todos</option>
                                    <option value="week">Última Semana</option>
                                    <option value="month">Último Mês</option>
                                    <option value="year">Último Ano</option>
                                </select>
                                <a href="#" onclick="generatePdf('pagamento', document.getElementById('period-pagamento').value)" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>

                    <!-- Visitantes -->
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Visitantes</h5>
                                <p class="card-text">Registro de visitantes do condomínio</p>
                                <select id="period-visitante" class="form-control mb-2">
                                    <option value="all">Todos</option>
                                    <option value="week">Última Semana</option>
                                    <option value="month">Último Mês</option>
                                    <option value="year">Último Ano</option>
                                </select>
                                <a href="#" onclick="generatePdf('visitante', document.getElementById('period-visitante').value)" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>

                    <!-- Funcionários -->
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Funcionários</h5>
                                <p class="card-text">Informações sobre os funcionários</p>
                                <select id="period-funcionario" class="form-control mb-2">
                                    <option value="all">Todos</option>
                                    <option value="week">Última Semana</option>
                                    <option value="month">Último Mês</option>
                                    <option value="year">Último Ano</option>
                                </select>
                                <a href="#" onclick="generatePdf('funcionario', document.getElementById('period-funcionario').value)" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>

                    <!-- Blocos -->
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Blocos</h5>
                                <p class="card-text">Informações sobre os blocos e suas unidades</p>
                                <select id="period-bloco" class="form-control mb-2">
                                    <option value="all">Todos</option>
                                    <option value="week">Última Semana</option>
                                    <option value="month">Último Mês</option>
                                    <option value="year">Último Ano</option>
                                </select>
                                <a href="#" onclick="generatePdf('bloco', document.getElementById('period-bloco').value)" target="_blank" class="btn btn-primary btn-block">Gerar Relatório</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generatePdf(type, period) {
            window.open('{{ url("/pdf") }}/' + type + '?period=' + period, '_blank');
        }
    </script>
@endsection