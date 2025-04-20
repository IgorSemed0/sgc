<div class="modal-body">
    <form action="{{ route('admin.pagamento.update', $pagamento->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.pagamento.index', ['pagamento' => $pagamento])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>