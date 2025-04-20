<div class="modal-body">
    <form action="{{ route('admin.notificacao.store') }}" method="POST">
        @csrf
        {{$notificacao=null}}
        @include('admin._form.notificacao.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>