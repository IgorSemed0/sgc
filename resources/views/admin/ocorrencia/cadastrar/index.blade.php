<div class="modal-body">
    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf
        {{$user=null}}
        @include('admin._form.user.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>