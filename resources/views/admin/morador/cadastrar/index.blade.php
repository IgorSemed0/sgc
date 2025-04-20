<div class="modal-body">
    <form action="{{ route('admin.morador.store') }}" method="POST">
        @csrf
        {{$morador=null}}
        @include('admin._form.morador.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>