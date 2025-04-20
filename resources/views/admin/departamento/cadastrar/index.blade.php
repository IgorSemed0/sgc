<div class="modal-body">
    <form action="{{ route('admin.departamento.store') }}" method="POST">
        @csrf
        {{$departamento=null}}
        @include('admin._form.departamento.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>