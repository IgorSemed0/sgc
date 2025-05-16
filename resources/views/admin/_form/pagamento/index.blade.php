<div class="row">
    <div class="col-md-6 mb-3">
        <label for="factura_id">Cobrança</label>
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
        <label for="metodo_pagamento">Método Pagamento</label>
        <select class="form-control select2" id="metodo_pagamento" name="metodo_pagamento" required>
            <option value="">Selecione um método de pagamento</option>
            <option value="dinheiro" {{ old('metodo_pagamento', $pagamento->metodo_pagamento ?? '') == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
            <option value="transferencia_bancaria" {{ old('metodo_pagamento', $pagamento->metodo_pagamento ?? '') == 'transferencia_bancaria' ? 'selected' : '' }}>Transferência Bancária</option>
            <option value="cartao_credito" {{ old('metodo_pagamento', $pagamento->metodo_pagamento ?? '') == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
            <option value="multicaixa" {{ old('metodo_pagamento', $pagamento->metodo_pagamento ?? '') == 'multicaixa' ? 'selected' : '' }}>Multicaixa</option>
            <option value="paypal" {{ old('metodo_pagamento', $pagamento->metodo_pagamento ?? '') == 'transferencia-express' ? 'selected' : '' }}>Transferência Express</option>
            <option value="outro" {{ old('metodo_pagamento', $pagamento->metodo_pagamento ?? '') == 'outro' ? 'selected' : '' }}>Outro</option>
        </select>
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