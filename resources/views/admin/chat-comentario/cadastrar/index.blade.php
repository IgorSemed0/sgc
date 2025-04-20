<div class="modal-body">
    <form action="{{ route('admin.chat-comentario.store') }}" method="POST">
        @csrf
        {{$chatComentario=null}}
        @include('admin._form.chat-comentario.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>