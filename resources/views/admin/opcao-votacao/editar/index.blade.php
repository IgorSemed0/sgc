<div class="modal-body">
    <form action="{{ route('admin.opcao-votacao.update', $opcaoVotacao->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.opcao-votacao.index', ['opcaoVotacao' => $opcaoVotacao])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>