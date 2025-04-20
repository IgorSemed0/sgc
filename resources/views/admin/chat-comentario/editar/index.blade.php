<div class="modal-body">
    <form action="{{ route('admin.chat-comentario.update', $chatComentario->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.chat-comentario.index', ['chatComentario' => $chatComentario])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>