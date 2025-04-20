<div class="modal-body">
    <form action="{{ route('admin.morador.update', $morador->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.morador.index', ['morador' => $morador])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>