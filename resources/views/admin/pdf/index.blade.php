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
                            <form action="{{ route('pdf.morador.index') }}" target="_blank" method="GET">
                                <div class="mb-3">
                                    <label>Bloco:</label>
                                    <select name="bloco" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($blocos as $bloco)
                                            <option value="{{ $bloco->id }}">{{ $bloco->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Unidade:</label>
                                    <select name="unidade" class="form-control">
                                        <option value="">Todas</option>
                                        @foreach($unidades as $unidade)
                                            <option value="{{ $unidade->id }}">{{ $unidade->numero }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Tipo de Morador:</label>
                                    <select name="tipo" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($tiposMorador as $tipo)
                                            <option value="{{ $tipo }}">{{ $tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Gerar Relatório</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Unidades -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Unidades</h5>
                            <p class="card-text">Informações sobre as unidades do condomínio</p>
                            <form action="{{ route('pdf.unidade.index') }}" target="_blank" method="GET">
                                <div class="mb-3">
                                    <label>Bloco:</label>
                                    <select name="bloco" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($blocos as $bloco)
                                            <option value="{{ $bloco->id }}">{{ $bloco->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Edifício:</label>
                                    <select name="edificio" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($edificios as $edificio)
                                            <option value="{{ $edificio->id }}">{{ $edificio->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Tipo de Unidade:</label>
                                    <select name="tipo" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($tiposUnidade as $tipo)
                                            <option value="{{ $tipo }}">{{ $tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Status:</label>
                                    <select name="status" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($statusUnidade as $status)
                                            <option value="{{ $status }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Andar:</label>
                                    <input type="number" name="andar" class="form-control" placeholder="Ex: 1">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Gerar Relatório</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Acessos -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Acessos</h5>
                            <p class="card-text">Registro de acessos ao condomínio</p>
                            <form action="{{ route('pdf.acesso.index') }}" target="_blank" method="GET">
                                <div class="mb-3">
                                    <label>Data de Início:</label>
                                    <input type="date" name="start" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Data de Fim:</label>
                                    <input type="date" name="end" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Tipo de Pessoa:</label>
                                    @foreach($tiposPessoaAcesso as $tipo)
                                        <div class="form-check">
                                            <input type="checkbox" name="tipo_pessoa[]" value="{{ $tipo }}" class="form-check-input">
                                            <label class="form-check-label">{{ $tipo }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mb-3">
                                    <label>Tipo de Acesso:</label>
                                    <select name="tipo_acesso" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($tiposAcesso as $tipo)
                                            <option value="{{ $tipo }}">{{ $tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Unidade:</label>
                                    <select name="unidade" class="form-control">
                                        <option value="">Todas</option>
                                        @foreach($unidades as $unidade)
                                            <option value="{{ $unidade->id }}">{{ $unidade->numero }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Gerar Relatório</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Despesas -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Despesas</h5>
                            <p class="card-text">Relatório de despesas do condomínio</p>
                            <form action="{{ route('pdf.despesa.index') }}" target="_blank" method="GET">
                                <div class="mb-3">
                                    <label>Data de Início:</label>
                                    <input type="date" name="start" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Data de Fim:</label>
                                    <input type="date" name="end" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Categoria:</label>
                                    <select name="categoria" class="form-control">
                                        <option value="">Todas</option>
                                        @foreach($categoriasDespesa as $categoria)
                                            <option value="{{ $categoria }}">{{ $categoria }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Valor Mínimo:</label>
                                    <input type="number" name="valor_min" class="form-control" step="0.01" placeholder="Ex: 100.00">
                                </div>
                                <div class="mb-3">
                                    <label>Valor Máximo:</label>
                                    <input type="number" name="valor_max" class="form-control" step="0.01" placeholder="Ex: 500.00">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Gerar Relatório</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Inadimplência -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Inadimplência</h5>
                            <p class="card-text">Relatório de faturas pendentes</p>
                            <form action="{{ route('pdf.inadimplencia.index') }}" target="_blank" method="GET">
                                <div class="mb-3">
                                    <label>Data de Vencimento Início:</label>
                                    <input type="date" name="start" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Data de Vencimento Fim:</label>
                                    <input type="date" name="end" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Bloco:</label>
                                    <select name="bloco" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($blocos as $bloco)
                                            <option value="{{ $bloco->id }}">{{ $bloco->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Unidade:</label>
                                    <select name="unidade" class="form-control">
                                        <option value="">Todas</option>
                                        @foreach($unidades as $unidade)
                                            <option value="{{ $unidade->id }}">{{ $unidade->numero }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Valor Mínimo:</label>
                                    <input type="number" name="valor_min" class="form-control" step="0.01" placeholder="Ex: 100.00">
                                </div>
                                <div class="mb-3">
                                    <label>Valor Máximo:</label>
                                    <input type="number" name="valor_max" class="form-control" step="0.01" placeholder="Ex: 500.00">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Gerar Relatório</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Pagamentos -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Pagamentos</h5>
                            <p class="card-text">Relatório de pagamentos efetuados</p>
                            <form action="{{ route('pdf.pagamento.index') }}" target="_blank" method="GET">
                                <div class="mb-3">
                                    <label>Data de Pagamento Início:</label>
                                    <input type="date" name="start" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Data de Pagamento Fim:</label>
                                    <input type="date" name="end" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Bloco:</label>
                                    <select name="bloco" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($blocos as $bloco)
                                            <option value="{{ $bloco->id }}">{{ $bloco->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Unidade:</label>
                                    <select name="unidade" class="form-control">
                                        <option value="">Todas</option>
                                        @foreach($unidades as $unidade)
                                            <option value="{{ $unidade->id }}">{{ $unidade->numero }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Método de Pagamento:</label>
                                    <select name="metodo" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($metodosPagamento as $metodo)
                                            <option value="{{ $metodo }}">{{ $metodo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Valor Mínimo:</label>
                                    <input type="number" name="valor_min" class="form-control" step="0.01" placeholder="Ex: 100.00">
                                </div>
                                <div class="mb-3">
                                    <label>Valor Máximo:</label>
                                    <input type="number" name="valor_max" class="form-control" step="0.01" placeholder="Ex: 500.00">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Gerar Relatório</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Visitantes -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Visitantes</h5>
                            <p class="card-text">Relatório de visitantes do condomínio</p>
                            <form action="{{ route('pdf.visitante.index') }}" target="_blank" method="GET">
                                <div class="mb-3">
                                    <label>Data de Visita Início:</label>
                                    <input type="date" name="start" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Data de Visita Fim:</label>
                                    <input type="date" name="end" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Bloco:</label>
                                    <select name="bloco" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($blocos as $bloco)
                                            <option value="{{ $bloco->id }}">{{ $bloco->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Unidade:</label>
                                    <select name="unidade" class="form-control">
                                        <option value="">Todas</option>
                                        @foreach($unidades as $unidade)
                                            <option value="{{ $unidade->id }}">{{ $unidade->numero }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Motivo da Visita:</label>
                                    <select name="motivo" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($motivosVisita as $motivo)
                                            <option value="{{ $motivo }}">{{ $motivo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Gerar Relatório</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Funcionários -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Funcionários</h5>
                            <p class="card-text">Relatório de funcionários do condomínio</p>
                            <form action="{{ route('pdf.funcionario.index') }}" target="_blank" method="GET">
                                <div class="mb-3">
                                    <label>Departamento:</label>
                                    <select name="departamento" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}">{{ $departamento->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Tipo de Funcionário:</label>
                                    <select name="tipo" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($tiposFuncionario as $tipo)
                                            <option value="{{ $tipo }}">{{ $tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Cargo:</label>
                                    <select name="cargo" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($cargos as $cargo)
                                            <option value="{{ $cargo }}">{{ $cargo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Gerar Relatório</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection