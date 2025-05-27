@extends('admin.layouts.body')
@section('title', 'Filtros Relatório de Moradores')
@section('conteudo')
<form action="{{ route('pdf.morador.index') }}" method="GET" class="mb-4">
    <h4>Filtros de Pesquisa - Moradores</h4>
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
            @foreach($tipos as $tipo)
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
    <button type="submit" class="btn btn-primary">Gerar Relatório</button>
</form>
@endsection