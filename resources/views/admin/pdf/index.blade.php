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
                            <form action="{{ route('pdf.morador.index') }}" method="GET">
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
                                    <label>Tipo de Morador:</label>
                                    <select name="tipo" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($tiposMorador as $tipo)
                                            <option value="{{ $tipo }}">{{ $tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Gênero:</label>
                                    <select name="genero" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($generos as $genero)
                                            <option value="{{ $genero }}">{{ $genero }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Idade Mínima:</label>
                                    <input type="number" name="idade_min" class="form-control" placeholder="Ex: 18">
                                </div>
                                <div class="mb-3">
                                    <label>Idade Máxima:</label>
                                    <input type="number" name="idade_max" class="form-control" placeholder="Ex: 65">
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
                            <form action="{{ route('pdf.unidade.index') }}" method="GET">
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
                            <form action="{{ route('pdf.acesso.index') }}" method="GET">
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
                                    <label>Local de Destino:</label>
                                    <input type="text" name="destino" class="form-control" placeholder="Ex: Apt B203">
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
                            <form action="{{ route('pdf.despesa.index') }}" method="GET">
                                <div class="mb-3">
                                    <label>Data de Início:</label>
                                    <input type="date" name="start" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Data de Fim:</label>
                                    <input type="date" name="end" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Descrição:</label>
                                    <input type="text" name="descricao" class="form-control" placeholder="Ex: Manutenção">
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
                            <form action="{{ route('pdf.inadimplencia.index') }}" method="GET">
                                <div class="mb-3">
                                    <label>Data de Vencimento Início:</label>
                                    <input type="date" name="start" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Data de Vencimento Fim:</label>
                                    <input type="date" name="end" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Unidade:</label>
                                    <input type="text" name="unidade" class="form-control" placeholder="Ex: A101">
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
                            <form action="{{ route('pdf.pagamento.index') }}" method="GET">
                                <div class="mb-3">
                                    <label>Data de Pagamento Início:</label>
                                    <input type="date" name="start" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Data de Pagamento Fim:</label>
                                    <input type="date" name="end" class="form-control">
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
                            <form action="{{ route('pdf.visitante.index') }}" method="GET">
                                <div class="mb-3">
                                    <label>Data de Visita Início:</label>
                                    <input type="date" name="start" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Data de Visita Fim:</label>
                                    <input type="date" name="end" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Motivo da Visita:</label>
                                    <input type="text" name="motivo" class="form-control" placeholder="Ex: Entrega">
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
                            <form action="{{ route('pdf.funcionario.index') }}" method="GET">
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
                                    <label>Cargo:</label>
                                    <select name="cargo" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($cargos as $cargo)
                                            <option value="{{ $cargo }}">{{ $cargo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Tipo:</label>
                                    <select name="tipo" class="form-control">
                                        <option value="">Todos</option>
                                        <option value="Permanente">Permanente</option>
                                        <option value="Temporário">Temporário</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Gerar Relatório</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Blocos -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Blocos</h5>
                            <p class="card-text">Relatório de blocos do condomínio</p>
                            <form action="{{ route('pdf.bloco.index') }}" method="GET">
                                <div class="mb-3">
                                    <label>Nome:</label>
                                    <input type="text" name="nome" class="form-control" placeholder="Ex: Bloco A">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Gerar Relatório</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edifícios -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Edifícios</h5>
                            <p class="card-text">Relatório de edifícios do condomínio</p>
                            <form action="{{ route('pdf.edificio.index') }}" method="GET">
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
                                    <label>Nome:</label>
                                    <input type="text" name="nome" class="form-control" placeholder="Ex: Edifício Central">
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