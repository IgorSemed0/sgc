@extends('admin.layouts.body')
@section('title', 'Filtros Relatório de Ocupação de Unidades')
@section('conteudo')
<form action="{{ route('pdf.unidade_occupancy') }}" method="POST" class="mb-4">
    @csrf
    <h4>Filtros de Pesquisa - Ocupação de Unidades</h4>

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
        <label>Bloco:</label>
        <input type="text" name="bloco" placeholder="Ex: A" class="form-control">
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