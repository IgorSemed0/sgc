@extends('admin.layouts.body')
@section('title', 'Listar Unidades')
@section('conteudo')
<h1 class="h3">Tabela de Imóveis</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#unidadeModal">Novo Imóvel</button>
    <a href="{{ route('admin.unidade.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Número</th>
                <th>Bloco Sigla</th>
                <th>Edifício Sigla</th>
                <th>Andar</th>
                <th>Status</th>
                <th>Moradores</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($unidades as $unidade)
            <tr>
                <td>{{ $unidade->id }}</td>
                <td>{{ $unidade->tipo }}</td>
                <td>{{ $unidade->numero }}</td>
                <td>{{ $unidade->bloco->nome }}</td>
                <td>{{ $unidade->edificio->nome }}</td>
                <td>{{ $unidade->andar }}</td>
                <td>{{ $unidade->status }}</td>
                <td>
                    <span class="badge bg-info">{{ $unidade->moradores()->count() }} moradores</span>
                </td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $unidade->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.unidade.destroy', $unidade->id) }}')">Deletar</a>
                    <button class="btn btn-success btn-sm morador-modal-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#moradorModal{{ $unidade->id }}"
                            data-unidade-id="{{ $unidade->id }}"
                            data-unidade-numero="{{ $unidade->numero }}"
                            data-unidade-tipo="{{ $unidade->tipo }}">
                            Adicionar Morador
                    </button>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal{{ $unidade->id }}">Ver Informações</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modals outside the foreach loop -->
@foreach ($unidades as $unidade)
    <!-- Modal for Editing Unidade -->
    <div class="modal fade" id="editar_modal{{ $unidade->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $unidade->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Imóvel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('admin.unidade.editar.index', ['unidade' => $unidade])
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Morador -->
    <div class="modal fade morador-modal" id="moradorModal{{ $unidade->id }}" tabindex="-1" aria-labelledby="moradorModal{{ $unidade->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Morador ao Imóvel {{ $unidade->numero }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.unidade.morador.store') }}" method="POST" class="morador-form">
                        @csrf
                        <input type="hidden" name="unidade_id" value="{{ $unidade->id }}" class="unidade-id-input">
                        
                        <!-- Show selected unidade info (read-only) -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Imóvel Selecionado</label>
                                <div class="alert alert-info">
                                    <strong>{{ $unidade->numero }}</strong> - {{ $unidade->tipo }}
                                    <br><small>{{ $unidade->edificio->nome }} - {{ $unidade->bloco->nome }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="primeiro_nome{{ $unidade->id }}" class="form-label">Primeiro Nome <span class="text-danger">*</span></label>
                                <input type="text" class="form-control morador-primeiro-nome" id="primeiro_nome{{ $unidade->id }}" name="primeiro_nome" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="nomes_meio{{ $unidade->id }}" class="form-label">Nomes do Meio</label>
                                <input type="text" class="form-control morador-nomes-meio" id="nomes_meio{{ $unidade->id }}" name="nomes_meio">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ultimo_nome{{ $unidade->id }}" class="form-label">Último Nome <span class="text-danger">*</span></label>
                                <input type="text" class="form-control morador-ultimo-nome" id="ultimo_nome{{ $unidade->id }}" name="ultimo_nome" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email{{ $unidade->id }}" class="form-label">Email</label>
                                <input type="email" class="form-control morador-email" id="email{{ $unidade->id }}" name="email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefone{{ $unidade->id }}" class="form-label">Telefone</label>
                                <input type="text" class="form-control morador-telefone" id="telefone{{ $unidade->id }}" name="telefone">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="bi{{ $unidade->id }}" class="form-label">BI</label>
                                <input type="text" class="form-control morador-bi" id="bi{{ $unidade->id }}" name="bi">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cedula{{ $unidade->id }}" class="form-label">Cédula</label>
                                <input type="text" class="form-control morador-cedula" id="cedula{{ $unidade->id }}" name="cedula">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="data_nascimento{{ $unidade->id }}" class="form-label">Data de Nascimento <span class="text-danger">*</span></label>
                                <input type="date" class="form-control morador-data-nascimento" id="data_nascimento{{ $unidade->id }}" name="data_nascimento" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="sexo{{ $unidade->id }}" class="form-label">Sexo <span class="text-danger">*</span></label>
                                <select class="form-select morador-sexo" id="sexo{{ $unidade->id }}" name="sexo" required>
                                    <option value="">Selecione o sexo</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Feminino">Feminino</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tipo{{ $unidade->id }}" class="form-label">Tipo <span class="text-danger">*</span></label>
                                <select class="form-select morador-tipo" id="tipo{{ $unidade->id }}" name="tipo" required onchange="toggleDependenteFields({{ $unidade->id }})">
                                    <option value="">Selecione o tipo</option>
                                    <option value="proprietario">Proprietário</option>
                                    <option value="inquilino">Inquilino</option>
                                    <option value="dependente">Dependente</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="estado_residente{{ $unidade->id }}" class="form-label">Estado Residente</label>
                                <select class="form-select morador-estado-residente" id="estado_residente{{ $unidade->id }}" name="estado_residente">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>

                        <!-- Dependente fields (hidden by default) -->
                        <div class="row dependente-fields" id="dependenteFields{{ $unidade->id }}" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label for="grau_parentesco{{ $unidade->id }}" class="form-label">Grau de Parentesco</label>
                                <input type="text" class="form-control morador-grau-parentesco" id="grau_parentesco{{ $unidade->id }}" name="grau_parentesco" placeholder="Ex: Filho, Filha, Cônjuge">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dependente_de{{ $unidade->id }}" class="form-label">Dependente de</label>
                                <select class="form-select morador-dependente-de" id="dependente_de{{ $unidade->id }}" name="dependente_de">
                                    <option value="">Selecione o responsável</option>
                                    @foreach($unidade->moradores->where('tipo', '!=', 'dependente') as $morador)
                                        <option value="{{ $morador->id }}">{{ $morador->primeiro_nome }} {{ $morador->ultimo_nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Salvar Morador</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Viewing Unidade Info -->
    <div class="modal fade" id="infoModal{{ $unidade->id }}" tabindex="-1" aria-labelledby="infoModal{{ $unidade->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informações do Imóvel {{ $unidade->numero }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Detalhes do Imóvel</h6>
                    <p><strong>Número:</strong> {{ $unidade->numero }}</p>
                    <p><strong>Tipo:</strong> {{ $unidade->tipo }}</p>
                    <p><strong>Bloco:</strong> {{ $unidade->bloco->nome }}</p>
                    <p><strong>Edifício:</strong> {{ $unidade->edificio->nome }}</p>
                    <p><strong>Andar:</strong> {{ $unidade->andar ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ $unidade->status }}</p>
                    <hr>
                    <h6>Moradores</h6>
                    <p><strong>Total de Moradores:</strong> {{ $unidade->moradores()->count() }}</p>
                    @if ($unidade->moradores()->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Tipo</th>
                                        <th>Telefone</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unidade->moradores as $morador)
                                        <tr>
                                            <td>{{ $morador->primeiro_nome }} {{ $morador->ultimo_nome }}</td>
                                            <td>
                                                <span class="badge bg-{{ $morador->tipo == 'proprietario' ? 'success' : ($morador->tipo == 'inquilino' ? 'primary' : 'warning') }}">
                                                    {{ ucfirst($morador->tipo) }}
                                                </span>
                                            </td>
                                            <td>{{ $morador->telefone ?? 'N/A' }}</td>
                                            <td>{{ $morador->email ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>Nenhum morador cadastrado neste imóvel.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Modal for Creating Unidade -->
<div class="modal fade" id="unidadeModal" tabindex="-1" aria-labelledby="unidadeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastro de Imóvel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @include('admin.unidade.cadastrar.index')
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

    function toggleDependenteFields(unidadeId) {
        const tipoSelect = document.getElementById(`tipo${unidadeId}`);
        const dependenteFields = document.getElementById(`dependenteFields${unidadeId}`);
        
        if (tipoSelect.value === 'dependente') {
            dependenteFields.style.display = 'block';
        } else {
            dependenteFields.style.display = 'none';
        }
    }

    // Clear form fields when modals are opened
    document.addEventListener('DOMContentLoaded', function() {
        // Clear morador modal forms when they are shown
        const moradorModals = document.querySelectorAll('.morador-modal');
        moradorModals.forEach(modal => {
            modal.addEventListener('show.bs.modal', function(event) {
                // Clear all form fields in this modal
                const form = this.querySelector('.morador-form');
                if (form) {
                    // Clear text inputs but keep the hidden unidade_id
                    const textInputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="date"]');
                    textInputs.forEach(input => {
                        input.value = '';
                    });
                    
                    // Reset selects to first option
                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.selectedIndex = 0;
                    });

                    // Hide dependente fields
                    const dependenteFields = form.querySelector('.dependente-fields');
                    if (dependenteFields) {
                        dependenteFields.style.display = 'none';
                    }
                }
            });
        });

        // Clear the main unidade modal
        const unidadeModal = document.getElementById('unidadeModal');
        if (unidadeModal) {
            unidadeModal.addEventListener('show.bs.modal', function(event) {
                const form = this.querySelector('form');
                if (form) {
                    form.reset();
                }
            });
        }
    });
</script>
@endsection