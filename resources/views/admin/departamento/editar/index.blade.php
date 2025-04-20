<div class="modal-body">
    <form action="{{ route('admin.departamento.update', $departamento->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.departamento.index', ['departamento' => $departamento])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>