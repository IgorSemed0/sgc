<div class="modal-body">
    <form action="{{ route('admin.bloco.store') }}" method="POST">
        @csrf
        {{$bloco=null}}
        @include('admin._form.bloco.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>