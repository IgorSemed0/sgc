<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $condominio->nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="endereco">Endereço</label>
        <input type="text" class="form-control" id="endereco" name="endereco" value="{{ old('endereco', $condominio->endereco ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="bairro">Bairro</label>
        <input type="text" class="form-control" id="bairro" name="bairro" value="{{ old('bairro', $condominio->bairro ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('cidade', $condominio->cidade ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="estado">Estado</label>
        <input type="text" class="form-control" id="estado" name="estado" value="{{ old('estado', $condominio->estado ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $condominio->telefone ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $condominio->email ?? '') }}">
    </div>
</div>