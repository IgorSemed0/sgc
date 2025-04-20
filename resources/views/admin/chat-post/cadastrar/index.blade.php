<div class="modal-body">
    <form action="{{ route('admin.chat-post.store') }}" method="POST">
        @csrf
        {{$chatPost=null}}
        @include('admin._form.chat-post.index')
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>