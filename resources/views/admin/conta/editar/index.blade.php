<div class="modal-body">
    <form action="{{ route('admin.conta.update', $conta->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.conta.index', ['conta' => $conta])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>