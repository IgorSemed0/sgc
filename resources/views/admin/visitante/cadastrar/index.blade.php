<div class="modal-body">
    <form action="{{ route('admin.visitante.store') }}" method="POST">
        @csrf
        {{$visitante=null}}
        @include('admin._form.visitante.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>