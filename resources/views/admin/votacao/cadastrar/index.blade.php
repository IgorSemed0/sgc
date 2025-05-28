<div class="modal-body">
    <form action="{{ route('admin.votacao.store') }}" method="POST">
        @csrf
        @php $votacao = null; @endphp
        @include('admin._form.votacao.index', ['uniqueId' => 'new'])
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>