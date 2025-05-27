<div class="modal-body">
    <form action="{{ route('admin.edificio.store') }}" method="POST">
        @csrf
        {{$edificio=null}}
        @include('admin._form.edificio.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>