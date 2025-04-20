<div class="row">
    <div class="col-md-6 mb-3">
        <label for="primeiro_nome">Primeiro Nome</label>
        <input type="text" class="form-control" id="primeiro_nome" name="primeiro_nome" value="{{ old('primeiro_nome', $morador->primeiro_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="nomes_meio">Nomes do Meio</label>
        <input type="text" class="form-control" id="nomes_meio" name="nomes_meio" value="{{ old('nomes_meio', $morador->nomes_meio ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="ultimo_nome">Último Nome</label>
        <input type="text" class="form-control" id="ultimo_nome" name="ultimo_nome" value="{{ old('ultimo_nome', $morador->ultimo_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $morador->email ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $morador->username ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $morador->telefone ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="bi">BI</label>
        <input type="text" class="form-control" id="bi" name="bi" value="{{ old('bi', $morador->bi ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_nascimento">Data de Nascimento</label>
        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $morador->data_nascimento ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="sexo">Sexo</label>
        <select class="form-control select2" id="sexo" name="sexo" required>
            <option value="">Selecione o sexo</option>
            <option value="Masculino" {{ old('sexo', $morador->sexo ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="Feminino" {{ old('sexo', $morador->sexo ?? '') == 'Feminino' ? 'selected' : '' }}>Feminino</option>
            <option value="Outro" {{ old('sexo', $morador->sexo ?? '') == 'Outro' ? 'selected' : '' }}>Outro</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="tipo">Tipo</label>
        <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo', $morador->tipo ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="rf_id">RF ID</label>
        <input type="text" class="form-control" id="rf_id" name="rf_id" value="{{ old('rf_id', $morador->rf_id ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="processo">Processo</label>
        <input type="text" class="form-control" id="processo" name="processo" value="{{ old('processo', $morador->processo ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="unidade_id">Unidade</label>
        <select class="form-control select2" id="unidade_id" name="unidade_id" required>
            <option value="">Selecione uma unidade</option>
            @foreach ($unidades as $unidade)
                <option value="{{ $unidade->id }}" {{ old('unidade_id', $morador->unidade_id ?? '') == $unidade->id ? 'selected' : '' }}>
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