<div class="modal-body">
    <form action="{{ route('admin.votacao.update', $votacao->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.votacao.index', ['votacao' => $votacao, 'uniqueId' => $votacao->id])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>