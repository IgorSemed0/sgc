<div class="modal-body">
    <form action="{{ route('admin.factura.update', $factura->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.factura.index', ['factura' => $factura])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>