<div class="modal-body">
    <form action="{{ route('admin.notificacao.update', $notificacao->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.notificacao.index', ['notificacao' => $notificacao])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>