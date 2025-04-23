@extends('admin.layouts.body')
@section('title', 'Filtros Relatório de Ocupação de Unidades')
@section('conteudo')
<form action="{{ route('pdf.unidade_occupancy') }}" method="POST" class="mb-4">
    @csrf
    <h4>Filtros de Pesquisa - Ocupação de Unidades</h4>

    <div class="mb-3">
        <label>Condomínio:</label>
        <select name="condominio_id" class="form-control" id="condominio_id">
            <option value="">Todos</option>
            @foreach($condominios as $condominio)
                <option value="{{ $condominio->id }}">{{ $condominio->nome }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Bloco:</label>
        <select name="bloco_id" class="form-control" id="bloco_id">
            <option value="">Todos</option>
            @foreach($blocos as $bloco)
                <option value="{{ $bloco->id }}" data-condominio="{{ $bloco->condominio_id }}">{{ $bloco->nome }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Gerar Relatório</button>
</form>

<script>
document.getElementById('condominio_id').addEventListener('change', function() {
    const condominioId = this.value;
    const blocoSelect = document.getElementById('bloco_id');
    const options = blocoSelect.querySelectorAll('option');

    options.forEach(option => {
        if (option.value === '' || !condominioId || option.dataset.condominio === condominioId) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });

    // Reset bloco selection if the current one is not valid
    if (blocoSelect.value && blocoSelect.selectedOptions[0].style.display === 'none') {
        blocoSelect.value = '';
    }
});
</script>
@endsection