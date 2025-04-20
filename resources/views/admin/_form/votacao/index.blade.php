<div class="row">
    <div class="col-md-6 mb-3">
        <label for="condominio_id">Condomínio</label>
        <select class="form-control select2" id="condominio_id" name="condominio_id" required>
            <option value="">Selecione um condomínio</option>
            @foreach ($condominios as $condominio)
                <option value="{{ $condominio->id }}" {{ old('condominio_id', $votacao->condominio_id ?? '') == $condominio->id ? 'selected' : '' }}>
                    {{ $condominio->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="titulo">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $votacao->titulo ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao" required>{{ old('descricao', $votacao->descricao ?? '') }}</textarea>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_inicio">Data Início</label>
        <input type="datetime-local" class="form-control" id="data_inicio" name="data_inicio" value="{{ old('data_inicio', $votacao->data_inicio ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_fim">Data Fim</label>
        <input type="datetime-local" class="form-control" id="data_fim" name="data_fim" value="{{ old('data_fim', $votacao->data_fim ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="quorum_minimo">Quórum Mínimo</label>
        <input type="number" class="form-control" id="quorum_minimo" name="quorum_minimo" value="{{ old('quorum_minimo', $votacao->quorum_minimo ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="status">Status</label>
        <input type="text" class="form-control" id="status" name="status" value="{{ old('status', $votacao->status ?? '') }}" required>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Selecione uma opção',
            width: '100%'
        });
    });
</script>