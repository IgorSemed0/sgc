<div class="modal-body">
    <form action="{{ route('admin.funcionario.store') }}" method="POST">
        @csrf
        {{$funcionario=null}}
        @include('admin._form.funcionario.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>