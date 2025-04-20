<div class="modal-body">
    <form action="{{ route('admin.espaco-comum.update', $espacoComum->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.espaco-comum.index', ['espacoComum' => $espacoComum])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>