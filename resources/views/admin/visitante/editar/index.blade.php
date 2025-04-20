<div class="modal-body">
    <form action="{{ route('admin.visitante.update', $visitante->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.visitante.index', ['visitante' => $visitante])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>