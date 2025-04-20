<div class="row">
    <div class="col-md-6 mb-3">
        <label for="user_id">Usuário</label>
        <select class="form-control select2" id="user_id" name="user_id" required>
            <option value="">Selecione um usuário</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $notificacao->user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->full_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="tipo">Tipo</label>
        <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo', $notificacao->tipo ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="titulo">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $notificacao->titulo ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="conteudo">Conteúdo</label>
        <textarea class="form-control" id="conteudo" name="conteudo" required>{{ old('conteudo', $notificacao->conteudo ?? '') }}</textarea>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_hora">Data/Hora</label>
        <input type="datetime-local" class="form-control" id="data_hora" name="data_hora" value="{{ old('data_hora', $notificacao->data_hora ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="lida">Lida</label>
        <select class="form-control" id="lida" name="lida" required>
            <option value="0" {{ old('lida', $notificacao->lida ?? 0) == 0 ? 'selected' : '' }}>Não</option>
            <option value="1" {{ old('lida', $notificacao->lida ?? 0) == 1 ? 'selected' : '' }}>Sim</option>
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