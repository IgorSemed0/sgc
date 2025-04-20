<div class="row">
    <div class="col-md-6 mb-3">
        <label for="condominio_id">Condomínio</label>
        <select class="form-control select2" id="condominio_id" name="condominio_id" required>
            <option value="">Selecione um condomínio</option>
            @foreach ($condominios as $condominio)
                <option value="{{ $condominio->id }}" {{ old('condominio_id', $rupe->condominio_id ?? '') == $condominio->id ? 'selected' : '' }}>
                    {{ $condominio->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $rupe->descricao ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="valor">Valor</label>
        <input type="number" step="0.01" class="form-control" id="valor" name="valor" value="{{ old('valor', $rupe->valor ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_receita">Data Receita</label>
        <input type="date" class="form-control" id="data_receita" name="data_receita" value="{{ old('data_receita', $rupe->data_receita ?? '') }}" required>
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