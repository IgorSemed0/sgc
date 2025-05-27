@extends('admin.layouts.body')
@section('title', 'Filtros Relatório de Acessos')
@section('conteudo')
<form action="{{ route('pdf.acesso.index') }}" method="GET" class="mb-4">
    <h4>Filtros de Pesquisa - Acessos</h4>
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
        @foreach($tiposPessoa as $tipo)
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
    <button type="submit" class="btn btn-primary">Gerar Relatório</button>
</form>
@endsection