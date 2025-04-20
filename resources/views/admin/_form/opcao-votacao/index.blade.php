<div class="row">
    <div class="col-md-6 mb-3">
        <label for="votacao_id">Votação</label>
        <select class="form-control select2" id="votacao_id" name="votacao_id" required>
            <option value="">Selecione uma votação</option>
            @foreach ($votacaos as $votacao)
                <option value="{{ $votacao->id }}" {{ old('votacao_id', $opcaoVotacao->votacao_id ?? '') == $votacao->id ? 'selected' : '' }}>
                    {{ $votacao->titulo }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $opcaoVotacao->descricao ?? '') }}" required>
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