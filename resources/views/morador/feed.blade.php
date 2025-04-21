@extends('publico.layouts.body')

@section('title', 'Feed de Posts')

@section('conteudo')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-3 mb-md-0"><i class="fas fa-newspaper text-primary me-2"></i>Feed de Posts</h1>
        
        <!-- Search Bar -->
        <form action="{{ route('morador.feed.search') }}" method="GET" class="d-flex">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar posts..." 
                    value="{{ isset($search) ? $search : '' }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Success Message -->
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Message -->
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($search) && $posts->total() == 0)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Nenhum resultado encontrado para "<strong>{{ $search }}</strong>".
            <a href="{{ route('morador.feed') }}" class="alert-link">Voltar para todos os posts</a>
        </div>
    @elseif(count($posts) == 0)
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
                        <p class="card-text">{{ Str::limit($post->conteudo, 150) }}</p>
                        
                        <div class="mt-4">
                            <h5 class="fw-bold d-flex align-items-center">
                                <i class="fas fa-comments text-primary me-2"></i> Comentários 
                                <span class="badge bg-secondary ms-2">{{ count($post->chatComentarios) }}</span>
                            </h5>
                            
                            <div class="comment-section mt-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                                @if(count($post->chatComentarios) > 0)
                                    @foreach ($post->chatComentarios->sortByDesc('created_at')->take(5) as $comentario)
                                        <div class="comment p-2 mb-2 border-bottom">
                                            <div class="d-flex align-items-start">
                                                @php
                                                    $userPhoto = $comentario->user->vc_foto_perfil ? Storage::url($comentario->user->vc_foto_perfil) : asset('assets/images/user.jpg');
                                                @endphp
                                                <img src="{{ $userPhoto }}" class="rounded-circle me-2" width="32" height="32" alt="Foto de perfil">
                                                <div class="comment-content">
                                                    <div class="fw-bold text-break">{{ $comentario->user->full_name }}</div>
                                                    <div class="text-break comment-text">{{ $comentario->conteudo }}</div>
                                                    <small class="text-muted">{{ $comentario->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    @if(count($post->chatComentarios) > 5)
                                        <div class="text-center py-2">
                                            <button class="btn btn-link btn-sm view-all-comments" data-post-id="{{ $post->id }}">
                                                Ver todos os {{ count($post->chatComentarios) }} comentários
                                            </button>
                                        </div>
                                    @endif
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
                                        <textarea name="conteudo" class="form-control" placeholder="Adicione um comentário..." required rows="2" maxlength="500"></textarea>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Máximo 500 caracteres</small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
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
    
    /* Comment text wrapping */
    .comment-content {
        width: calc(100% - 40px);
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
        hyphens: auto;
    }
    
    .comment-text {
        max-width: 100%;
        font-size: 0.95rem;
    }
    
    /* Post title should not overflow */
    .card-header .fw-bold {
        max-width: 70%;
    }
    
    /* Make sure text won't overflow */
    .text-break {
        overflow-wrap: break-word !important;
        word-wrap: break-word !important;
        word-break: break-word !important;
        hyphens: auto !important;
    }
    
    /* Pagination styling */
    .pagination {
        --bs-pagination-color: var(--blue);
        --bs-pagination-hover-color: var(--dark-blue);
        --bs-pagination-active-bg: var(--blue);
        --bs-pagination-active-border-color: var(--blue);
    }
    
    /* Responsive search bar */
    @media (max-width: 767.98px) {
        .input-group {
            width: 100%;
        }
        
        /* Smaller font for mobile */
        .comment-text {
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                const closeBtn = new bootstrap.Alert(alert);
                closeBtn.close();
            });
        }, 5000);
        
        // Character counter for comment textarea
        const textareas = document.querySelectorAll('textarea[name="conteudo"]');
        textareas.forEach(function(textarea) {
            textarea.addEventListener('input', function() {
                const maxLength = this.getAttribute('maxlength');
                const currentLength = this.value.length;
                const counterEl = this.parentElement.nextElementSibling;
                
                if (currentLength >= maxLength - 50) {
                    counterEl.textContent = `${maxLength - currentLength} caracteres restantes`;
                    counterEl.classList.add('text-danger');
                } else {
                    counterEl.textContent = 'Máximo 500 caracteres';
                    counterEl.classList.remove('text-danger');
                }
            });
        });
    });
</script>
@endpush