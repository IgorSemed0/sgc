<div class="row">
    <div class="col-md-6 mb-3">
        <label for="condominio_id">Condomínio</label>
        <select class="form-control select2" id="condominio_id" name="condominio_id" required>
            <option value="">Selecione um condomínio</option>
            @foreach ($condominios as $condominio)
                <option value="{{ $condominio->id }}" {{ old('condominio_id', $espacoComum->condominio_id ?? '') == $condominio->id ? 'selected' : '' }}>
                    {{ $condominio->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $espacoComum->nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao">{{ old('descricao', $espacoComum->descricao ?? '') }}</textarea>
    </div>
    <div class="col-md-6 mb-3">
        <label for="capacidade">Capacidade</label>
        <input type="number" class="form-control" id="capacidade" name="capacidade" value="{{ old('capacidade', $espacoComum->capacidade ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="regras">Regras</label>
        <textarea class="form-control" id="regras" name="regras">{{ old('regras', $espacoComum->regras ?? '') }}</textarea>
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