@extends('publico.layouts.body')

@section('title', 'Votações')

@section('conteudo')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-3 mb-md-0"><i class="fas fa-vote-yea text-primary me-2"></i>Votações Ativas</h1>
        
        <!-- Barra de Busca -->
        <form action="{{ route('morador.votacao.search') }}" method="GET" class="d-flex">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar votações..." 
                    value="{{ isset($search) ? $search : '' }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Mensagem de Sucesso -->
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Mensagem de Erro -->
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Mensagem para Resultados de Busca ou Votações Vazias -->
    @if(isset($search) && $votacaos->total() == 0)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Nenhum resultado encontrado para "<strong>{{ $search }}</strong>".
            <a href="{{ route('morador.votacao') }}" class="alert-link">Voltar para todas as votações</a>
        </div>
    @elseif(count($votacaos) == 0)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Nenhuma votação disponível no momento.
        </div>
    @endif

    <div class="row">
        @foreach ($votacaos as $votacao)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-shadow">
                    <div class="card-header bg-primary bg-gradient text-white d-flex justify-content-between align-items-center">
                        <span class="fw-bold">{{ $votacao->titulo }}</span>
                        <small><i class="fas fa-calendar-alt me-1"></i> {{ $votacao->created_at->format('d/m/Y') }}</small>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $votacao->descricao }}</p>
                        <form action="{{ route('morador.votacao.vote') }}" method="POST">
                            @csrf
                            <input type="hidden" name="votacao_id" value="{{ $votacao->id }}">
                            <div class="form-group mb-2">
                                <label for="opcao_id_{{ $votacao->id }}">Escolha uma opção</label>
                                <select name="opcao_id" id="opcao_id_{{ $votacao->id }}" class="form-control">
                                    @foreach ($votacao->opcaoVotacaos as $opcao)
                                        <option value="{{ $opcao->id }}">{{ $opcao->descricao }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Votar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $votacaos->links() }}
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
    
    /* Estilização da Paginação */
    .pagination {
        --bs-pagination-color: var(--blue);
        --bs-pagination-hover-color: var(--dark-blue);
        --bs-pagination-active-bg: var(--blue);
        --bs-pagination-active-border-color: var(--blue);
    }
    
    /* Responsividade da Barra de Busca */
    @media (max-width: 767.98px) {
        .input-group {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss de alertas após 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                const closeBtn = new bootstrap.Alert(alert);
                closeBtn.close();
            });
        }, 5000);
    });
</script>
@endpush