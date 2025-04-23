@extends('admin.layouts.body')
@section('title', 'Filtros Relatório de Demografia de Moradores')
@section('conteudo')
<form action="{{ route('pdf.morador_demographics') }}" method="POST" class="mb-4">
    @csrf
    <h4>Filtros de Pesquisa - Demografia de Moradores</h4>

    <div class="mb-3">
        <label>Condomínio:</label>
        <select name="condominio_id" class="form-control">
            <option value="">Todos</option>
            @foreach($condominios as $condominio)
                <option value="{{ $condominio->id }}">{{ $condominio->nome }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Idade:</label>
        <input type="number" name="idade" placeholder="Ex: 25" class="form-control">
    </div>

    <div class="mb-3">
        <label>Intervalo de Idade:</label>
        <div class="d-flex gap-3">
            <input type="number" name="idade_min" placeholder="Mínima" class="form-control">
            <input type="number" name="idade_max" placeholder="Máxima" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <label>Sexo:</label>
        <select name="sexo" class="form-control">
            <option value="">Todos</option>
            <option value="masculino">Masculino</option>
            <option value="feminino">Feminino</option>
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