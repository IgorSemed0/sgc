<div class="modal-body">
    <form action="{{ route('admin.condominio.store') }}" method="POST">
        @csrf
        {{$condominio=null}}
        @include('admin._form.condominio.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>