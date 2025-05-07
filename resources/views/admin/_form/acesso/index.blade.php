<div class="row">
    <div class="col-md-6 mb-3">
        <label for="tipo_pessoa">Tipo de Pessoa</label>
        <select class="form-control select2" id="tipo_pessoa" name="tipo_pessoa" required>
            <option value="">Selecione o tipo de pessoa</option>
            <option value="Visitante" {{ old('tipo_pessoa', $acesso->tipo_pessoa ?? '') == 'Visitante' ? 'selected' : '' }}>Visitante</option>
            <option value="Morador" {{ old('tipo_pessoa', $acesso->tipo_pessoa ?? '') == 'Morador' ? 'selected' : '' }}>Morador</option>
            <option value="Funcionario" {{ old('tipo_pessoa', $acesso->tipo_pessoa ?? '') == 'Funcionario' ? 'selected' : '' }}>Funcionário</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="entidade_id">Entidade</label>
        <select class="form-control select2" id="entidade_id" name="entidade_id" required>
            <option value="">Selecione uma entidade</option>
            @foreach ($visitantes as $visitante)
                <option value="{{ $visitante->id }}" {{ old('entidade_id', $acesso->entidade_id ?? '') == $visitante->id ? 'selected' : '' }}>
                    Visitante: {{ $visitante->primeiro_nome }} {{ $visitante->ultimo_nome }}
                </option>
            @endforeach
            @foreach ($moradores as $morador)
                <option value="{{ $morador->id }}" {{ old('entidade_id', $acesso->entidade_id ?? '') == $morador->id ? 'selected' : '' }}>
                    Morador: {{ $morador->primeiro_nome }} {{ $morador->ultimo_nome }}
                </option>
            @endforeach
            @foreach ($funcionarios as $funcionario)
                <option value="{{ $funcionario->id }}" {{ old('entidade_id', $acesso->entidade_id ?? '') == $funcionario->id ? 'selected' : '' }}>
                    Funcionário: {{ $funcionario->primeiro_nome }} {{ $funcionario->ultimo_nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_hora">Data e Hora</label>
        <input type="datetime-local" class="form-control" id="data_hora" name="data_hora" value="{{ old('data_hora', $acesso->data_hora ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="tipo">Tipo</label>
        <select class="form-control select2" id="tipo" name="tipo" required>
            <option value="">Selecione o tipo</option>
            <option value="Entrada" {{ old('tipo', $acesso->tipo ?? '') == 'Entrada' ? 'selected' : '' }}>Entrada</option>
            <option value="Saída" {{ old('tipo', $acesso->tipo ?? '') == 'Saída' ? 'selected' : '' }}>Saída</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="observacao">Observação</label>
        <textarea class="form-control" id="observacao" name="observacao">{{ old('observacao', $acesso->observacao ?? '') }}</textarea>
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