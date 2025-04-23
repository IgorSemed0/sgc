<div class="row">
    <div class="col-md-6 mb-3">
        <label for="primeiro_nome">Primeiro Nome</label>
        <input type="text" class="form-control" id="primeiro_nome" name="primeiro_nome" value="{{ old('primeiro_nome', $visitante->primeiro_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="nomes_meio">Nomes do Meio</label>
        <input type="text" class="form-control" id="nomes_meio" name="nomes_meio" value="{{ old('nomes_meio', $visitante->nomes_meio ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="ultimo_nome">Último Nome</label>
        <input type="text" class="form-control" id="ultimo_nome" name="ultimo_nome" value="{{ old('ultimo_nome', $visitante->ultimo_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="bi">BI</label>
        <input type="text" class="form-control" id="bi" name="bi" value="{{ old('bi', $visitante->bi ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $visitante->email ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $visitante->telefone ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="motivo_visita">Motivo da Visita</label>
        <input type="text" class="form-control" id="motivo_visita" name="motivo_visita" value="{{ old('motivo_visita', $visitante->motivo_visita ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="unidade_id">Unidade</label>
        <select class="form-control select2" id="unidade_id" name="unidade_id" required>
            <option value="">Selecione uma unidade</option>
            @foreach ($unidades as $unidade)
                <option value="{{ $unidade->id }}" {{ old('unidade_id', $visitante->unidade_id ?? '') == $unidade->id ? 'selected' : '' }}>
                    {{ $unidade->tipo }} - {{ $unidade->numero }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="condominio_id">Condomínio</label>
        <select class="form-control select2" id="condominio_id" name="condominio_id" required>
            <option value="">Selecione um condomínio</option>
            @foreach ($condominios as $condominio)
                <option value="{{ $condominio->id }}" {{ old('condominio_id', $visitante->condominio_id ?? '') == $condominio->id ? 'selected' : '' }}>
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