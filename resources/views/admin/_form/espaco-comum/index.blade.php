<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $espacoComum->nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao">{{ old('descricao', $espacoComum->descricao ?? '') }}</textarea>
    </div>
    <div class="col-md-6 mb-3">
        <label for="bloco_id">Bloco Sigla</label>
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