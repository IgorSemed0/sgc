<div class="modal-body">
    <form action="{{ route('admin.despesa.update', $despesa->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.despesa.index', ['despesa' => $despesa])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>