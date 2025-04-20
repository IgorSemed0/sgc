<div class="modal-body">
    <form action="{{ route('admin.votacao.store') }}" method="POST">
        @csrf
        {{$votacao=null}}
        @include('admin._form.votacao.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>