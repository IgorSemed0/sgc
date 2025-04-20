<div class="modal-body">
    <form action="{{ route('admin.funcionario.update', $funcionario->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.funcionario.index', ['funcionario' => $funcionario])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>