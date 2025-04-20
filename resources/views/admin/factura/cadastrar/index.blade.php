<div class="modal-body">
    <form action="{{ route('admin.factura.store') }}" method="POST">
        @csrf
        {{$factura=null}}
        @include('admin._form.factura.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>