@extends('admin.layouts.body')
@section('title', 'Filtros Relatório de Controle de Acesso')
@section('conteudo')
<form action="{{ route('pdf.access_control') }}" method="POST" class="mb-4">
    @csrf
    <h4>Filtros de Pesquisa - Controle de Acesso</h4>

    <div class="mb-3">
        <label>Data:</label>
        <input type="date" name="data" class="form-control">
    </div>

    <div class="mb-3">
        <label>Intervalo de Datas:</label>
        <div class="d-flex gap-3">
            <input type="date" name="data_inicio" class="form-control" placeholder="Início">
            <input type="date" name="data_fim" class="form-control" placeholder="Fim">
        </div>
    </div>

    <div class="mb-3">
        <label>Mês:</label>
        <select name="mes" class="form-control">
            <option value="">-- Selecionar Mês --</option>
            @foreach(range(1,12) as $mes)
                <option value="{{ $mes }}">{{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Intervalo de Meses:</label>
        <div class="d-flex gap-3">
            <select name="mes_inicio" class="form-control">
                <option value="">De</option>
                @foreach(range(1,12) as $mes)
                    <option value="{{ $mes }}">{{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}</option>
                @endforeach
            </select>
            <select name="mes_fim" class="form-control">
                <option value="">Até</option>
                @foreach(range(1,12) as $mes)
                    <option value="{{ $mes }}">{{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label>Ano:</label>
        <input type="number" name="ano" value="{{ date('Y') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Tipo de Pessoa:</label>
        <select name="tipo_pessoa" class="form-control">
            <option value="">Todos</option>
            <option value="morador">Morador</option>
            <option value="funcionario">Funcionário</option>
            <option value="visitante">Visitante</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Tipo de Acesso:</label>
        <select name="tipo" class="form-control">
            <option value="">Todos</option>
            <option value="Entrada">Entrada</option>
            <option value="Saida">Saída</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Tipo de Relatório:</label>
        <div class="d-flex gap-3">
            <div><input type="radio" name="tipo_relatorio" value="quantitativo" required> Quantitativo</div>
            <div><input type="radio" name="tipo_relatorio" value="qualitativo" required> Qualitativo</div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Gerar Relatório</button>
</form>
@endsection