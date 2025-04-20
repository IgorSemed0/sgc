<div class="modal-body">
    <form action="{{ route('admin.opcao-votacao.store') }}" method="POST">
        @csrf
        {{$opcaoVotacao=null}}
        @include('admin._form.opcao-votacao.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>