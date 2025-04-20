<div class="modal-body">
    <form action="{{ route('admin.chat-post.update', $chatPost->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.chat-post.index', ['chatPost' => $chatPost])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>