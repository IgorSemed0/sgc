<div class="modal-body">
    <form action="{{ route('admin.rupe.update', $rupe->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.rupe.index', ['rupe' => $rupe])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>