@extends('admin.layouts.body')

@section('title', 'Feed de Posts - Admin')

@section('conteudo')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-3 mb-md-0"><i class="fas fa-newspaper text-primary me-2"></i>Feed de Comunicados - Admin</h1>
        
        <!-- Search Bar -->
        <form action="{{ route('admin.feed.search') }}" method="GET" class="d-flex">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar posts..." 
                    value="{{ isset($search) ? $search : '' }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Create Post Button -->
    <div class="mb-4">
        <button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#createPostModal">
            <i class="fas fa-plus me-2"></i>Criar Novo Post
        </button>
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

    @if(isset($search) && isset($posts) && $posts->total() == 0)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Nenhum resultado encontrado para "<strong>{{ $search }}</strong>".
            <a href="{{ route('admin.feed') }}" class="alert-link">Voltar para todos os posts</a>
        </div>
    @elseif(!isset($posts) || $posts->count() == 0)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Nenhum post disponível no momento.
        </div>
    @endif

    <div class="row">
        @if(isset($posts) && $posts->count() > 0)
            @foreach ($posts as $post)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-shadow">
                        <div class="card-header bg-primary bg-gradient text-white d-flex justify-content-between align-items-center">
                            <span class="fw-bold">{{ $post->titulo }}</span>
                            <div class="d-flex align-items-center">
                                <small class="me-2"><i class="fas fa-calendar-alt me-1"></i> {{ $post->created_at->format('d/m/Y') }}</small>
                                <!-- Admin Actions -->
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $post->id }}"><i class="fas fa-edit me-2"></i>Editar</a></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete('{{ route('admin.chat-post.destroy', $post->id) }}')"><i class="fas fa-trash me-2"></i>Excluir</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ Str::limit($post->conteudo, 150) }}</p>
                            
                            <!-- Post Author Info -->
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>
                                    Por: {{ $post->user->primeiro_nome ?? '' }} {{ $post->user->ultimo_nome ?? '' }}
                                    <span class="badge bg-secondary ms-1">{{ ucfirst($post->tipo_autor) }}</span>
                                </small>
                            </div>
                            
                            <div class="mt-4">
                                <h5 class="fw-bold d-flex align-items-center">
                                    <i class="fas fa-comments text-primary me-2"></i> Comentários 
                                    <span class="badge bg-secondary ms-2">{{ $post->chatComentarios ? $post->chatComentarios->count() : 0 }}</span>
                                </h5>
                                
                                <div class="comment-section mt-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                                    @if($post->chatComentarios && $post->chatComentarios->count() > 0)
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
                                        
                                        @if($post->chatComentarios->count() > 5)
                                            <div class="text-center py-2">
                                                <button class="btn btn-link btn-sm view-all-comments" data-post-id="{{ $post->id }}">
                                                    Ver todos os {{ $post->chatComentarios->count() }} comentários
                                                </button>
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center text-muted py-3">
                                            <i class="fas fa-comment-slash"></i> Nenhum comentário ainda
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal for each post -->
                <div class="modal fade" id="editModal{{ $post->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $post->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Post</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.chat-post.update', $post->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="titulo{{ $post->id }}" class="form-label">Título</label>
                                        <input type="text" class="form-control" id="titulo{{ $post->id }}" name="titulo" value="{{ $post->titulo }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="conteudo{{ $post->id }}" class="form-label">Conteúdo</label>
                                        <textarea class="form-control" id="conteudo{{ $post->id }}" name="conteudo" rows="5" required>{{ $post->conteudo }}</textarea>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Atualizar Post</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    
    <!-- Pagination -->
    @if(isset($posts) && $posts instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    @endif
</div>

<!-- Create Post Modal -->
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar Novo Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.chat-post.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digite o título do post" required maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label for="conteudo" class="form-label">Conteúdo</label>
                        <textarea class="form-control" id="conteudo" name="conteudo" rows="6" placeholder="Digite o conteúdo do post..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Criar Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
        max-width: 60%;
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
    
    /* Admin specific styles */
    .dropdown-toggle::after {
        margin-left: 0.255em;
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
        
        .card-header .fw-bold {
            max-width: 50%;
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
    });

    function confirmDelete(url) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Esta ação não pode ser desfeita!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
@endpush