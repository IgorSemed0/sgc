<div class="modal-body">
    <form action="{{ route('admin.bloco.update', $bloco->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.bloco.index', ['bloco' => $bloco])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>