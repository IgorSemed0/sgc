<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $conta->nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="tipo">Tipo</label>
        <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo', $conta->tipo ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="saldo">Saldo</label>
        <input type="number" step="0.01" class="form-control" id="saldo" name="saldo" value="{{ old('saldo', $conta->saldo ?? '') }}" required>
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