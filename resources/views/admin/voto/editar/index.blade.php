<div class="modal-body">
    <form action="{{ route('admin.voto.update', $voto->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.voto.index', ['voto' => $voto])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>