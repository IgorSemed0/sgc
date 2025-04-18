<div class="modal-body">
    <form action="{{ route('admin.condominio.update', $condominio->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.condominio.index', ['condominio' => $condominio])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>