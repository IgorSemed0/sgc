@extends('admin.layouts.body')
@section('title', 'Filtros Relatório de Edifícios')
@section('conteudo')
<form action="{{ route('pdf.edificio.index') }}" method="GET" class="mb-4">
    <h4>Filtros de Pesquisa - Edifícios</h4>
    <div class="mb-3">
        <label>Bloco:</label>
        <select name="bloco" class="form-control">
            <option value="">Todos</option>
            @foreach($blocos as $bloco)
                <option value="{{ $bloco->id }}">{{ $bloco->nome }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Gerar Relatório</button>
</form>
@endsection