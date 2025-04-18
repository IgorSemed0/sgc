<div class="modal-body">
    <form action="{{ route('admin.alocacao.store') }}" method="POST">
        @csrf
        {{$alocacao=null}}
        @include('admin._form.alocacao.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>