<div class="row">
    <div class="col-md-6 mb-3">
        <label for="primeiro_nome">Primeiro Nome</label>
        <input type="text" class="form-control" id="primeiro_nome" name="primeiro_nome" value="{{ old('primeiro_nome', $user->primeiro_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="nomes_meio">Nomes do Meio</label>
        <input type="text" class="form-control" id="nomes_meio" name="nomes_meio" value="{{ old('nomes_meio', $user->nomes_meio ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="ultimo_nome">Último Nome</label>
        <input type="text" class="form-control" id="ultimo_nome" name="ultimo_nome" value="{{ old('ultimo_nome', $user->ultimo_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="password">Senha</label>
        <input type="password" class="form-control" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
        @if (isset($user))
            <small class="form-text text-muted">Deixe em branco para manter a senha atual.</small>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label for="bi">BI</label>
        <input type="text" class="form-control" id="bi" name="bi" value="{{ old('bi', $user->bi ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $user->telefone ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="tipo_usuario">Tipo de Usuário</label>
        <select class="form-control select2" id="tipo_usuario" name="tipo_usuario" required>
            <option value="">Selecione o tipo</option>
            <option value="admin" {{ old('tipo_usuario', $user->tipo_usuario ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="morador" {{ old('tipo_usuario', $user->tipo_usuario ?? '') == 'morador' ? 'selected' : '' }}>Morador</option>
            <option value="funcionario" {{ old('tipo_usuario', $user->tipo_usuario ?? '') == 'funcionario' ? 'selected' : '' }}>Funcionário</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="condominio_id">Condomínio</label>
        <select class="form-control select2" id="condominio_id" name="condominio_id" required>
            <option value="">Selecione um condomínio</option>
            @foreach ($condominios as $condominio)
                <option value="{{ $condominio->id }}" {{ old('condominio_id', $user->condominio_id ?? '') == $condominio->id ? 'selected' : '' }}>
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