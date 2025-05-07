<div class="row">
    <div class="col-md-6 mb-3">
        <label for="factura_id">Fatura</label>
        <select class="form-control select2" id="factura_id" name="factura_id" required>
            <option value="">Selecione uma fatura</option>
            @foreach ($facturas as $factura)
                <option value="{{ $factura->id }}" {{ old('factura_id', $pagamento->factura_id ?? '') == $factura->id ? 'selected' : '' }}>
                    {{ $factura->referencia }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_pagamento">Data Pagamento</label>
        <input type="date" class="form-control" id="data_pagamento" name="data_pagamento" value="{{ old('data_pagamento', $pagamento->data_pagamento ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="valor_pago">Valor Pago</label>
        <input type="number" step="0.01" class="form-control" id="valor_pago" name="valor_pago" value="{{ old('valor_pago', $pagamento->valor_pago ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="metodo_pagamento">Método Pagamento</label>
        <input type="text" class="form-control" id="metodo_pagamento" name="metodo_pagamento" value="{{ old('metodo_pagamento', $pagamento->metodo_pagamento ?? '') }}" required>
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