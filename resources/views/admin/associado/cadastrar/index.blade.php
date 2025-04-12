<div class="modal-body">
    <form action="{{ route('admin.associado.store') }}" method="POST">
        @csrf
        @php
            $associado = null;
        @endphp
        @include('admin._form.associado.index', ['associado' => $associado])
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>