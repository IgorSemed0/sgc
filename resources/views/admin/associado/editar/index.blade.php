<div class="modal-body">
    <form action="{{ route('admin.associado.update', $associado->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.associado.index', ['associado' => $associado])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>