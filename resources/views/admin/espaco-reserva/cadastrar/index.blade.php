<div class="modal-body">
    <form action="{{ route('admin.espaco-comum.store') }}" method="POST">
        @csrf
        {{$espacoComum=null}}
        @include('admin._form.espaco-comum.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>