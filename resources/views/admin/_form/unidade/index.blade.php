<div class="row">
    <div class="col-md-6 mb-3">
        <label for="tipo">Tipo</label>
        <select class="form-control select2" id="tipo" name="tipo" required>
            <option value="">Selecione o tipo</option>
            <option value="Apartamento" {{ old('tipo', $unidade->tipo ?? '') == 'Apartamento' ? 'selected' : '' }}>Apartamento</option>
            <option value="Loja" {{ old('tipo', $unidade->tipo ?? '') == 'Loja' ? 'selected' : '' }}>Loja</option>
            <option value="Estacionamento" {{ old('tipo', $unidade->tipo ?? '') == 'Estacionamento' ? 'selected' : '' }}>Estacionamento</option>
            <option value="Casa" {{ old('tipo', $unidade->tipo ?? '') == 'Casa' ? 'selected' : '' }}>Casa</option>
            <option value="Sala Comercial" {{ old('tipo', $unidade->tipo ?? '') == 'Sala Comercial' ? 'selected' : '' }}>Sala Comercial</option>
            <option value="Depósito" {{ old('tipo', $unidade->tipo ?? '') == 'Depósito' ? 'selected' : '' }}>Depósito</option>
            <option value="Kitnet" {{ old('tipo', $unidade->tipo ?? '') == 'Kitnet' ? 'selected' : '' }}>Kitnet</option>
            <option value="Duplex" {{ old('tipo', $unidade->tipo ?? '') == 'Duplex' ? 'selected' : '' }}>Duplex</option>
            <option value="Triplex" {{ old('tipo', $unidade->tipo ?? '') == 'Triplex' ? 'selected' : '' }}>Triplex</option>
            <option value="Cobertura" {{ old('tipo', $unidade->tipo ?? '') == 'Cobertura' ? 'selected' : '' }}>Cobertura</option>
            <option value="Studio" {{ old('tipo', $unidade->tipo ?? '') == 'Studio' ? 'selected' : '' }}>Studio</option>
            <option value="Flat" {{ old('tipo', $unidade->tipo ?? '') == 'Flat' ? 'selected' : '' }}>Flat</option>
            <option value="Galpão" {{ old('tipo', $unidade->tipo ?? '') == 'Galpão' ? 'selected' : '' }}>Galpão</option>
            <option value="Terreno" {{ old('tipo', $unidade->tipo ?? '') == 'Terreno' ? 'selected' : '' }}>Terreno</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="numero">Número</label>
        <input type="number" class="form-control" id="numero" name="numero" value="{{ old('numero', $unidade->numero ?? '') }}" required>
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
        <select class="form-control select2" id="status" name="status" required>
            <option value="">Selecione o status</option>
            <option value="alugada" {{ old('status', $unidade->status ?? '') == 'alugada' ? 'selected' : '' }}>Alugada</option>
            <option value="vendida" {{ old('status', $unidade->status ?? '') == 'vendida' ? 'selected' : '' }}>Vendida</option>
            <option value="disponivel" {{ old('status', $unidade->status ?? '') == 'disponivel' ? 'selected' : '' }}>Disponível</option>
            <option value="indisponivel" {{ old('status', $unidade->status ?? '') == 'indisponivel' ? 'selected' : '' }}>Indisponível</option>
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