<div class="modal-body">
    <form action="{{ route('admin.factura-item.update', $facturaItem->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.factura-item.index', ['facturaItem' => $facturaItem])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>