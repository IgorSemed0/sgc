@extends('publico.layouts.body')

@section('title', 'Feed de Posts')

@section('conteudo')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-newspaper text-primary me-2"></i>Feed de Posts</h1>
    </div>

    @if(count($posts) == 0)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Nenhum post disponível no momento.
        </div>
    @endif

    <div class="row">
        @foreach ($posts as $post)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-shadow">
                    <div class="card-header bg-primary bg-gradient text-white d-flex justify-content-between align-items-center">
                        <span class="fw-bold">{{ $post->titulo }}</span>
                        <small><i class="fas fa-calendar-alt me-1"></i> {{ $post->created_at->format('d/m/Y') }}</small>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $post->conteudo }}</p>
                        
                        <div class="mt-4">
                            <h5 class="fw-bold d-flex align-items-center">
                                <i class="fas fa-comments text-primary me-2"></i> Comentários 
                                <span class="badge bg-secondary ms-2">{{ count($post->chatComentarios) }}</span>
                            </h5>
                            
                            <div class="comment-section mt-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                                @if(count($post->chatComentarios) > 0)
                                    @foreach ($post->chatComentarios as $comentario)
                                        <div class="comment p-2 mb-2 border-bottom">
                                            <div class="d-flex align-items-start">
                                                @php
                                                    $userPhoto = $comentario->user->vc_foto_perfil ? Storage::url($comentario->user->vc_foto_perfil) : asset('assets/images/user.jpg');
                                                @endphp
                                                <img src="{{ $userPhoto }}" class="rounded-circle me-2" width="32" height="32" alt="Foto de perfil">
                                                <div>
                                                    <div class="fw-bold">{{ $comentario->user->full_name }}</div>
                                                    <div>{{ $comentario->conteudo }}</div>
                                                    <small class="text-muted">{{ $comentario->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-3">
                                        <i class="fas fa-comment-slash"></i> Nenhum comentário ainda
                                    </div>
                                @endif
                            </div>
                            
                            <form action="{{ route('morador.feed.comment') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <div class="form-group mb-2">
                                    <div class="input-group">
                                        <textarea name="conteudo" class="form-control" placeholder="Adicione um comentário..." required rows="2"></textarea>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    @if(isset($posts) && method_exists($posts, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    
    .card {
        transition: all 0.3s ease;
    }
    
    .comment-section {
        border-radius: 5px;
        background-color: #f9f9f9;
        padding: 8px;
    }
    
    .comment {
        border-radius: 4px;
    }
    
    .comment:last-child {
        border-bottom: none !important;
    }
</style>
@endpush