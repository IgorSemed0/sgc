<div class="modal-body">
    <form action="{{ route('admin.unidade.store') }}" method="POST">
        @csrf
        {{$unidade=null}}
        @include('admin._form.unidade.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>