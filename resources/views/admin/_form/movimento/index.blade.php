<div class="row">
    <div class="col-md-6 mb-3">
        <label for="conta_id">Conta</label>
        <select class="form-control select2" id="conta_id" name="conta_id" required>
            <option value="">Selecione uma conta</option>
            @foreach ($contas as $conta)
                <option value="{{ $conta->id }}" {{ old('conta_id', $movimento->conta_id ?? '') == $conta->id ? 'selected' : '' }}>
                    {{ $conta->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="tipo">Tipo</label>
        <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo', $movimento->tipo ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="valor">Valor</label>
        <input type="number" step="0.01" class="form-control" id="valor" name="valor" value="{{ old('valor', $movimento->valor ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $movimento->descricao ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_movimento">Data Movimento</label>
        <input type="date" class="form-control" id="data_movimento" name="data_movimento" value="{{ old('data_movimento', $movimento->data_movimento ?? '') }}" required>
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