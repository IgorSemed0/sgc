<div class="modal-body">
    <form action="{{ route('admin.rupe.store') }}" method="POST">
        @csrf
        {{$rupe=null}}
        @include('admin._form.rupe.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>