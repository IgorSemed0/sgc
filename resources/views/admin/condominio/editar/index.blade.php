<div class="modal-body">
    <form action="{{ route('admin.alocacao.update', $alocacao->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.alocacao.index')
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>