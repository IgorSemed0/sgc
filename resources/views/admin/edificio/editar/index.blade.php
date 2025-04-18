<div class="modal-body">
    <form action="{{ route('admin.edificio.update', $edificio->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.edificio.index', ['edificio' => $edificio])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>