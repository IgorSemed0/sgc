@extends('publico.layouts.body')

@section('title', 'Feed de Posts')

@section('conteudo')
    <h1 class="h3 mb-4">Feed de Posts</h1>
    <div class="row">
        @foreach ($posts as $post)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">{{ $post->titulo }}</div>
                    <div class="card-body">
                        <p>{{ $post->conteudo }}</p>
                        <h5>Comentários</h5>
                        @foreach ($post->chatComentarios as $comentario)
                            <div class="comment mb-2">
                                <strong>{{ $comentario->user->full_name }}</strong>: {{ $comentario->conteudo }}
                            </div>
                        @endforeach
                        <form action="{{ route('morador.feed.comment') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="form-group mb-2">
                                <textarea name="conteudo" class="form-control" placeholder="Adicione um comentário" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Comentar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection