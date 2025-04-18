<div class="modal-body">
    <form action="{{ route('admin.unidade.update', $unidade->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.unidade.index', ['unidade' => $unidade])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>