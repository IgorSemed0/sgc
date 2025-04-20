<div class="modal-body">
    <form action="{{ route('admin.espaco-reserva.store') }}" method="POST">
        @csrf
        {{$espacoReserva=null}}
        @include('admin._form.espaco-reserva.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>