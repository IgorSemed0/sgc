@extends('admin.layouts.body')
@section('title', 'Relatórios')
@section('conteudo')
    <h1>Relatórios</h1>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('pdf.morador') }}" class="btn btn-primary btn-block">Relatório de Moradores</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('pdf.unidade') }}" class="btn btn-primary btn-block">Relatório de Unidades</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('pdf.acesso') }}" class="btn btn-primary btn-block">Relatório de Acessos</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('pdf.despesa') }}" class="btn btn-primary btn-block">Relatório de Despesas</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('pdf.inadimplencia') }}" class="btn btn-primary btn-block">Relatório de Inadimplência</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('pdf.pagamento') }}" class="btn btn-primary btn-block">Relatório de Pagamentos</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('pdf.visitante') }}" class="btn btn-primary btn-block">Relatório de Visitantes</a>
        </div>
    </div>
@endsection