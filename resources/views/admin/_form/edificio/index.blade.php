<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $edificio->nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $edificio->descricao ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="bloco_id">Bloco</label>
        <select class="form-control select2" id="bloco_id" name="bloco_id" required>
            <option value="">Selecione um bloco</option>
            @foreach ($blocos as $bloco)
                <option value="{{ $bloco->id }}" {{ old('bloco_id', $edificio->bloco_id ?? '') == $bloco->id ? 'selected' : '' }}>
                    {{ $bloco->nome }}
                </option>
            @endforeach
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