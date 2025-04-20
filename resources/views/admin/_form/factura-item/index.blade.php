<div class="row">
    <div class="col-md-6 mb-3">
        <label for="factura_id">Fatura</label>
        <select class="form-control select2" id="factura_id" name="factura_id" required>
            <option value="">Selecione uma fatura</option>
            @foreach ($facturas as $factura)
                <option value="{{ $factura->id }}" {{ old('factura_id', $facturaItem->factura_id ?? '') == $factura->id ? 'selected' : '' }}>
                    {{ $factura->referencia }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="categoria">Categoria</label>
        <input type="text" class="form-control" id="categoria" name="categoria" value="{{ old('categoria', $facturaItem->categoria ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $facturaItem->descricao ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="valor">Valor</label>
        <input type="number" step="0.01" class="form-control" id="valor" name="valor" value="{{ old('valor', $facturaItem->valor ?? '') }}" required>
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