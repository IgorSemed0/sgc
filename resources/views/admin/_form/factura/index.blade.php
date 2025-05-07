<div class="row">
    <div class="col-md-6 mb-3">
        <label for="unidade_id">Unidade</label>
        <select class="form-control select2" id="unidade_id" name="unidade_id" required>
            <option value="">Selecione uma unidade</option>
            @foreach ($unidades as $unidade)
                <option value="{{ $unidade->id }}" {{ old('unidade_id', $factura->unidade_id ?? '') == $unidade->id ? 'selected' : '' }}>
                    {{ $unidade->tipo }} - {{ $unidade->numero }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="referencia">Referência</label>
        <input type="text" class="form-control" id="referencia" name="referencia" value="{{ old('referencia', $factura->referencia ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_emissao">Data de Emissão</label>
        <input type="date" class="form-control" id="data_emissao" name="data_emissao" value="{{ old('data_emissao', $factura->data_emissao ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_vencimento">Data de Vencimento</label>
        <input type="date" class="form-control" id="data_vencimento" name="data_vencimento" value="{{ old('data_vencimento', $factura->data_vencimento ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="valor_total">Valor Total</label>
        <input type="number" step="0.01" class="form-control" id="valor_total" name="valor_total" value="{{ old('valor_total', $factura->valor_total ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="status">Status</label>
        <select class="form-control select2" id="status" name="status" required>
            <option value="">Selecione o status</option>
            <option value="Pendente" {{ old('status', $factura->status ?? '') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
            <option value="Pago" {{ old('status', $factura->status ?? '') == 'Pago' ? 'selected' : '' }}>Pago</option>
            <option value="Cancelado" {{ old('status', $factura->status ?? '') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="observacao">Observação</label>
        <textarea class="form-control" id="observacao" name="observacao">{{ old('observacao', $factura->observacao ?? '') }}</textarea>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Selecione uma opção',
            width: '100%'
        });
    });
</script>\