<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $bloco->nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $bloco->descricao ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="condominio_id">Condomínio</label>
        <select class="form-control select2" id="condominio_id" name="condominio_id" required>
            <option value="">Selecione um condomínio</option>
            @foreach ($condominios as $condominio)
                <option value="{{ $condominio->id }}" {{ old('condominio_id', $bloco->condominio_id ?? '') == $condominio->id ? 'selected' : '' }}>
                    {{ $condominio->nome }}
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