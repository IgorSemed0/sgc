<div class="modal-body">
    <form action="{{ route('admin.conta.store') }}" method="POST">
        @csrf
        {{$conta=null}}
        @include('admin._form.conta.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>