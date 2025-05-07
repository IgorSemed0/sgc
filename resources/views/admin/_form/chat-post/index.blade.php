<div class="row">
    <div class="col-md-6 mb-3">
        <label for="autor_id">Autor</label>
        <select class="form-control select2" id="autor_id" name="autor_id" required>
            <option value="">Selecione um usuário</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('autor_id', $chatPost->autor_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->full_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="tipo_autor">Tipo Autor</label>
        <input type="text" class="form-control" id="tipo_autor" name="tipo_autor" value="{{ old('tipo_autor', $chatPost->tipo_autor ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="titulo">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $chatPost->titulo ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="conteudo">Conteúdo</label>
        <textarea class="form-control" id="conteudo" name="conteudo" required>{{ old('conteudo', $chatPost->conteudo ?? '') }}</textarea>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_publicacao">Data Publicação</label>
        <input type="datetime-local" class="form-control" id="data_publicacao" name="data_publicacao" value="{{ old('data_publicacao', $chatPost->data_publicacao ?? '') }}" required>
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