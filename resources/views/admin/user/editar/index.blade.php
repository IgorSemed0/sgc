<div class="modal-body">
    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin._form.user.index', ['user' => $user])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>