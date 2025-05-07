<div class="row">
    <div class="col-md-6 mb-3">
        <label for="categoria">Categoria</label>
        <input type="text" class="form-control" id="categoria" name="categoria" value="{{ old('categoria', $despesa->categoria ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $despesa->descricao ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="valor">Valor</label>
        <input type="number" step="0.01" class="form-control" id="valor" name="valor" value="{{ old('valor', $despesa->valor ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_despesa">Data Despesa</label>
        <input type="date" class="form-control" id="data_despesa" name="data_despesa" value="{{ old('data_despesa', $despesa->data_despesa ?? '') }}" required>
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