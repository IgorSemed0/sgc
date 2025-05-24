@extends('admin.layouts.body')
@section('title', 'Listar Blocos')
@section('conteudo')
<h1 class="h3">Tabela de Blocos</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#blocoModal">Novo Bloco</button>
    <a href="{{ route('admin.bloco.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Siga</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blocos as $bloco)
            <tr>
                <td>{{ $bloco->id }}</td>
                <td>{{ $bloco->nome }}</td>
                <td>{{ $bloco->descricao }}</td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $bloco->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.bloco.destroy', $bloco->id) }}')">Deletar</a>
                    <button class="btn btn-primary btn-sm edificio-modal-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#edificioModal{{ $bloco->id }}"
                            data-bloco-id="{{ $bloco->id }}"
                            data-bloco-nome="{{ $bloco->nome }}">
                            Adicionar Edifício
                    </button>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal{{ $bloco->id }}">Ver Informações</button>
                </td>
            </tr>

            <!-- Modal for Editing Bloco -->
            <div class="modal fade" id="editar_modal{{ $bloco->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $bloco->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Bloco</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.bloco.editar.index', ['bloco' => $bloco])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Adding Edificio -->
            <div class="modal fade edificio-modal" id="edificioModal{{ $bloco->id }}" tabindex="-1" aria-labelledby="edificioModal{{ $bloco->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Adicionar Edifício ao Bloco {{ $bloco->nome }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.bloco.edificio.store') }}" method="POST" class="edificio-form">
                                @csrf
                                <input type="hidden" name="bloco_id" value="{{ $bloco->id }}" class="bloco-id-input">
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sigla{{ $bloco->id }}" class="form-label">Sigla</label>
                                        <input type="text" class="form-control edificio-sigla" id="sigla{{ $bloco->id }}" name="nome" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="descricao{{ $bloco->id }}" class="form-label">Descrição</label>
                                        <input type="text" class="form-control edificio-descricao" id="descricao{{ $bloco->id }}" name="descricao">
                                    </div>
                                </div>
                                
                                <!-- Show selected bloco info (read-only) -->
                                <div class="mb-3">
                                    <label class="form-label">Bloco Selecionado</label>
                                    <div class="alert alert-info">
                                        <strong>{{ $bloco->nome }}</strong> - {{ $bloco->descricao ?? 'Sem descrição' }}
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Viewing Bloco Info -->
            <div class="modal fade" id="infoModal{{ $bloco->id }}" tabindex="-1" aria-labelledby="infoModal{{ $bloco->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Informações do Bloco {{ $bloco->nome }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Detalhes do Bloco</h6>
                            <p><strong>Siga:</strong> {{ $bloco->nome }}</p>
                            <p><strong>Descrição:</strong> {{ $bloco->descricao ?? 'N/A' }}</p>
                            <hr>
                            <h6>Edifícios</h6>
                            <p><strong>Total de Edifícios:</strong> {{ $bloco->edificio()->count() }}</p>
                            @if ($bloco->edificio()->count() > 0)
                                <ul>
                                    @foreach ($bloco->edificio as $edificio)
                                        <li>
                                            <strong>Nome:</strong> {{ $edificio->nome }}<br>
                                            <strong>Descrição:</strong> {{ $edificio->descricao ?? 'N/A' }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Nenhum edifício cadastrado neste bloco.</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <!-- Modal for Creating Bloco -->
    <div class="modal fade" id="blocoModal" tabindex="-1" aria-labelledby="blocoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Bloco</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.bloco.cadastrar.index')
            </div>
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
        // Clear edificio modal forms when they are shown
        const edificioModals = document.querySelectorAll('.edificio-modal');
        edificioModals.forEach(modal => {
            modal.addEventListener('show.bs.modal', function(event) {
                // Clear all form fields in this modal
                const form = this.querySelector('.edificio-form');
                if (form) {
                    // Clear text inputs but keep the hidden bloco_id
                    const textInputs = form.querySelectorAll('input[type="text"]');
                    textInputs.forEach(input => {
                        input.value = '';
                    });
                    
                    // Clear textareas
                    const textareas = form.querySelectorAll('textarea');
                    textareas.forEach(textarea => {
                        textarea.value = '';
                    });
                    
                    // Reset selects to first option
                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.selectedIndex = 0;
                    });
                }
            });
        });

        // Also clear the main bloco modal
        const blocoModal = document.getElementById('blocoModal');
        if (blocoModal) {
            blocoModal.addEventListener('show.bs.modal', function(event) {
                const form = this.querySelector('form');
                if (form) {
                    form.reset();
                }
            });
        }

        // Clear edit modals
        const editModals = document.querySelectorAll('[id^="editar_modal"]');
        editModals.forEach(modal => {
            modal.addEventListener('show.bs.modal', function(event) {
                // For edit modals, we might want to preserve the original values
                // So we don't clear them automatically
            });
        });
    });
</script>
@endsection