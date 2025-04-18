<div class="row">
    <div class="col-md-6 mb-3">
        <label for="tipo">Tipo</label>
        <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo', $unidade->tipo ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="numero">Número</label>
        <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero', $unidade->numero ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="bloco_id">Bloco</label>
        <select class="form-control select2" id="bloco_id" name="bloco_id" required>
            <option value="">Selecione um bloco</option>
            @foreach ($blocos as $bloco)
                <option value="{{ $bloco->id }}" {{ old('bloco_id', $unidade->bloco_id ?? '') == $bloco->id ? 'selected' : '' }}>
                    {{ $bloco->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="edificio_id">Edifício</label>
        <select class="form-control select2" id="edificio_id" name="edificio_id" required>
            <option value="">Selecione um edifício</option>
            @foreach ($edificios as $edificio)
                <option value="{{ $edificio->id }}" {{ old('edificio_id', $unidade->edificio_id ?? '') == $edificio->id ? 'selected' : '' }}>
                    {{ $edificio->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="area_m2">Área (m²)</label>
        <input type="number" step="0.01" class="form-control" id="area_m2" name="area_m2" value="{{ old('area_m2', $unidade->area_m2 ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="andar">Andar</label>
        <input type="number" class="form-control" id="andar" name="andar" value="{{ old('andar', $unidade->andar ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="status">Status</label>
        <input type="text" class="form-control" id="status" name="status" value="{{ old('status', $unidade->status ?? '') }}" required>
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