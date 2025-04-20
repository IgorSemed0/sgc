<div class="modal-body">
    <form action="{{ route('admin.pagamento.store') }}" method="POST">
        @csrf
        {{$pagamento=null}}
        @include('admin._form.pagamento.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>