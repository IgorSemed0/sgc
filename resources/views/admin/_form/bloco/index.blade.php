<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nome">Sigla</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $bloco->nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $bloco->descricao ?? '') }}">
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