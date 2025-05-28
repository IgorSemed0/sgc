@extends('admin.layouts.body')
@section('title', 'Listar Edifícios')
@section('conteudo')
<h1 class="h3">Tabela de Edifícios</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edificioModal">Novo Edifício</button>
    <a href="{{ route('admin.edificio.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sigla</th>
                <th>Descrição</th>
                <th>Bloco Sigla</th>
                <th>Unidades</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($edificios as $edificio)
            <tr>
                <td>{{ $edificio->id }}</td>
                <td>{{ $edificio->nome }}</td>
                <td>{{ $edificio->descricao }}</td>
                <td>{{ $edificio->bloco->nome }}</td>
                <td>
                    <span class="badge bg-info">{{ $edificio->unidades()->count() }} unidades</span>
                </td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $edificio->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.edificio.destroy', $edificio->id) }}')">Deletar</a>
                    <button class="btn btn-success btn-sm unidade-modal-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#unidadeModal{{ $edificio->id }}"
                            data-edificio-id="{{ $edificio->id }}"
                            data-edificio-nome="{{ $edificio->nome }}"
                            data-bloco-id="{{ $edificio->bloco_id }}"
                            data-bloco-nome="{{ $edificio->bloco->nome }}">
                            Adicionar Imóvel
                    </button>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal{{ $edificio->id }}">Ver Informações</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modals outside the foreach loop -->
@foreach ($edificios as $edificio)
    <!-- Modal for Editing Edificio -->
    <div class="modal fade" id="editar_modal{{ $edificio->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $edificio->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Edifício</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('admin.edificio.editar.index', ['edificio' => $edificio])
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Unidade -->
    <div class="modal fade unidade-modal" id="unidadeModal{{ $edificio->id }}" tabindex="-1" aria-labelledby="unidadeModal{{ $edificio->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Imóvel ao Edifício {{ $edificio->nome }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.edificio.unidade.store') }}" method="POST" class="unidade-form">
                        @csrf
                        <input type="hidden" name="edificio_id" value="{{ $edificio->id }}" class="edificio-id-input">
                        <input type="hidden" name="bloco_id" value="{{ $edificio->bloco_id }}" class="bloco-id-input">
                        
                        <!-- Show selected edificio and bloco info (read-only) -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Bloco Selecionado</label>
                                <div class="alert alert-secondary">
                                    <strong>{{ $edificio->bloco->nome }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Edifício Selecionado</label>
                                <div class="alert alert-info">
                                    <strong>{{ $edificio->nome }}</strong> - {{ $edificio->descricao ?? 'Sem descrição' }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="tipo{{ $edificio->id }}" class="form-label">Tipo <span class="text-danger">*</span></label>
                                <select class="form-select unidade-tipo" id="tipo{{ $edificio->id }}" name="tipo" required>
                                    <option value="">Selecione o tipo</option>
                                    <option value="Apartamento">Apartamento</option>
                                    <option value="Casa">Casa</option>
                                    <option value="Estabelecimento Comercial">Estabelecimento Comercial</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="numero{{ $edificio->id }}" class="form-label">Número <span class="text-danger">*</span></label>
                                <input type="text" class="form-control unidade-numero" id="numero{{ $edificio->id }}" name="numero" required placeholder="Ex: 101, 201A, etc.">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="andar{{ $edificio->id }}" class="form-label">Andar</label>
                                <input type="number" class="form-control unidade-andar" id="andar{{ $edificio->id }}" name="andar" min="0" placeholder="Ex: 1, 2, 10">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status{{ $edificio->id }}" class="form-label">Status</label>
                                <select class="form-select unidade-status" id="status{{ $edificio->id }}" name="status">
                                    <option value="disponivel">Disponível</option>
                                    <option value="ocupado">Ocupado</option>
                                </select>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Salvar Imóvel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Viewing Edificio Info -->
    <div class="modal fade" id="infoModal{{ $edificio->id }}" tabindex="-1" aria-labelledby="infoModal{{ $edificio->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informações do Edifício {{ $edificio->nome }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Detalhes do Edifício</h6>
                    <p><strong>Sigla:</strong> {{ $edificio->nome }}</p>
                    <p><strong>Descrição:</strong> {{ $edificio->descricao ?? 'N/A' }}</p>
                    <p><strong>Bloco:</strong> {{ $edificio->bloco->nome }}</p>
                    <hr>
                    <h6>Imóveis/Unidades</h6>
                    <p><strong>Total de Unidades:</strong> {{ $edificio->unidades()->count() }}</p>
                    @if ($edificio->unidades()->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Tipo</th>
                                        <th>Andar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($edificio->unidades as $unidade)
                                        <tr>
                                            <td>{{ $unidade->numero }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $unidade->tipo)) }}</td>
                                            <td>{{ $unidade->andar ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $unidade->status == 'disponivel' ? 'success' : ($unidade->status == 'ocupado' ? 'primary' : 'warning') }}">
                                                    {{ ucfirst($unidade->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>Nenhuma unidade cadastrada neste edifício.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Modal for Creating Edificio -->
<div class="modal fade" id="edificioModal" tabindex="-1" aria-labelledby="edificioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastro de Edifício</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @include('admin.edificio.cadastrar.index')
        </div>
    </div>
</div>

@if (session('success'))
<script>
    Swal.fire({
        title: "Sucesso!",
        text: "{{ session('success') }}",
        icon: "success",
        confirmButtonText: "OK"
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        title: "Erro!",
        text: "{{ session('error') }}",
        icon: "error",
        confirmButtonText: "OK"
    });
</script>
@endif

<script>
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

    // Clear form fields when modals are opened
    document.addEventListener('DOMContentLoaded', function() {
        // Clear unidade modal forms when they are shown
        const unidadeModals = document.querySelectorAll('.unidade-modal');
        unidadeModals.forEach(modal => {
            modal.addEventListener('show.bs.modal', function(event) {
                // Clear all form fields in this modal
                const form = this.querySelector('.unidade-form');
                if (form) {
                    // Clear text inputs but keep the hidden edificio_id and bloco_id
                    const textInputs = form.querySelectorAll('input[type="text"], input[type="number"]');
                    textInputs.forEach(input => {
                        input.value = '';
                    });
                    
                    // Reset selects to first option
                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.selectedIndex = 0;
                    });
                }
            });
        });

        // Clear the main edificio modal
        const edificioModal = document.getElementById('edificioModal');
        if (edificioModal) {
            edificioModal.addEventListener('show.bs.modal', function(event) {
                const form = this.querySelector('form');
                if (form) {
                    form.reset();
                }
            });
        }
    });
</script>
@endsection