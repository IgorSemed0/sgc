<div class="modal-body">
    <form action="{{ route('admin.voto.store') }}" method="POST">
        @csrf
        {{$voto=null}}
        @include('admin._form.voto.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>