<div class="modal-body">
    <form action="{{ route('admin.movimento.store') }}" method="POST">
        @csrf
        {{$movimento=null}}
        @include('admin._form.movimento.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>