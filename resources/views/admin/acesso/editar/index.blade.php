<div class="modal-body">
    <form action="{{ route('admin.acesso.update', $acesso->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.acesso.index', ['acesso' => $acesso])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>