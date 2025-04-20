<div class="modal-body">
    <form action="{{ route('admin.factura-item.store') }}" method="POST">
        @csrf
        {{$facturaItem=null}}
        @include('admin._form.factura-item.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>