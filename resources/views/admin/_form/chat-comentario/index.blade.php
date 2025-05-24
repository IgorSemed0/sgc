<div class="row">
    <div class="col-md-6 mb-3">
        <label for="post_id">Post</label>
        <select class="form-control select2" id="post_id" name="post_id" required>
            <option value="">Selecione um post</option>
            @foreach ($chatPosts as $chatPost)
                <option value="{{ $chatPost->id }}" {{ old('post_id', $chatComentario->post_id ?? '') == $chatPost->id ? 'selected' : '' }}>
                    {{ $chatPost->titulo }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="conteudo">Conteúdo</label>
        <textarea class="form-control" id="conteudo" name="conteudo" required>{{ old('conteudo', $chatComentario->conteudo ?? '') }}</textarea>
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