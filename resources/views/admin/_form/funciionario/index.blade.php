<div class="row">
    <div class="col-md-6 mb-3">
        <label for="primeiro_nome">Primeiro Nome</label>
        <input type="text" class="form-control" id="primeiro_nome" name="primeiro_nome" value="{{ old('primeiro_nome', $funcionario->primeiro_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="nomes_meio">Nomes do Meio</label>
        <input type="text" class="form-control" id="nomes_meio" name="nomes_meio" value="{{ old('nomes_meio', $funcionario->nomes_meio ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="ultimo_nome">Último Nome</label>
        <input type="text" class="form-control" id="ultimo_nome" name="ultimo_nome" value="{{ old('ultimo_nome', $funcionario->ultimo_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $funcionario->email ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $funcionario->username ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $funcionario->telefone ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="bi">BI</label>
        <input type="text" class="form-control" id="bi" name="bi" value="{{ old('bi', $funcionario->bi ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="sexo">Sexo</label>
        <select class="form-control select2" id="sexo" name="sexo" required>
            <option value="">Selecione o sexo</option>
            <option value="Masculino" {{ old('sexo', $funcionario->sexo ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="Feminino" {{ old('sexo', $funcionario->sexo ?? '') == 'Feminino' ? 'selected' : '' }}>Feminino</option>
            <option value="Outro" {{ old('sexo', $funcionario->sexo ?? '') == 'Outro' ? 'selected' : '' }}>Outro</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="cargo">Cargo</label>
        <input type="text" class="form-control" id="cargo" name="cargo" value="{{ old('cargo', $funcionario->cargo ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="departamento_id">Departamento</label>
        <select class="form-control select2" id="departamento_id" name="departamento_id" required>
            <option value="">Selecione um departamento</option>
            @foreach ($departamentos as $departamento)
                <option value="{{ $departamento->id }}" {{ old('departamento_id', $funcionario->departamento_id ?? '') == $departamento->id ? 'selected' : '' }}>
                    {{ $departamento->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="condominio_id">Condomínio</label>
        <select class="form-control select2" id="condominio_id" name="condominio_id" required>
            <option value="">Selecione um condomínio</option>
            @foreach ($condominios as $condominio)
                <option value="{{ $condominio->id }}" {{ old('condominio_id', $funcionario->condominio_id ?? '') == $condominio->id ? 'selected' : '' }}>
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