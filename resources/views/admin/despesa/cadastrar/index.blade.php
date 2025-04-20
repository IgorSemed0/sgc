<div class="modal-body">
    <form action="{{ route('admin.despesa.store') }}" method="POST">
        @csrf
        {{$despesa=null}}
        @include('admin._form.despesa.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>