<div class="row">
    <div class="col-md-6 mb-3">
        <label for="tipo">Tipo*</label>
        <select class="form-control select2" id="tipo" name="tipo" required>
            <option value="">Selecione o tipo</option>
            <option value="Apartamento" {{ old('tipo', $unidade->tipo ?? '') == 'Apartamento' ? 'selected' : '' }}>Apartamento</option>
            <option value="Estacionamento" {{ old('tipo', $unidade->tipo ?? '') == 'Estacionamento' ? 'selected' : '' }}>Estacionamento</option>
            <option value="Casa" {{ old('tipo', $unidade->tipo ?? '') == 'Casa' ? 'selected' : '' }}>Casa</option>
            <option value="Sala Comercial" {{ old('tipo', $unidade->tipo ?? '') == 'Estabelecimento Comercial' ? 'selected' : '' }}>Estabelecimento Comercial</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="numero">Número*</label>
        <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero', $unidade->numero ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="edificio_id">Edifício Sigla</label>
        <select class="form-control select2" id="edificio_id" name="edificio_id" >
            <option value="">Selecione um edifício</option>
            @foreach ($edificios as $edificio)
                <option value="{{ $edificio->id }}" {{ old('edificio_id', $unidade->edificio_id ?? '') == $edificio->id ? 'selected' : '' }}>
                    {{ $edificio->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="andar">Andar</label>
        <input type="number" class="form-control" id="andar" name="andar" value="{{ old('andar', $unidade->andar ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label for="status">Status*</label>
        <select class="form-control select2" id="status" name="status" required>
            <option value="">Selecione o status</option>
            <option value="alugada" {{ old('status', $unidade->status ?? '') == 'indisponivel' ? 'selected' : '' }}>Inisponível</option>
            <option value="disponivel" {{ old('status', $unidade->status ?? '') == 'disponivel' ? 'selected' : '' }}>Disponzível</option>
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