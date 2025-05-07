<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $departamento->nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $departamento->descricao ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="unidade_id">Unidade (Opcional)</label>
        <select class="form-control select2" id="unidade_id" name="unidade_id">
            <option value="">Selecione uma unidade</option>
            @foreach ($unidades as $unidade)
                <option value="{{ $unidade->id }}" {{ old('unidade_id', $departamento->unidade_id ?? '') == $unidade->id ? 'selected' : '' }}>
                    {{ $unidade->tipo }} - {{ $unidade->numero }}
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