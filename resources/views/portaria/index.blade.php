@extends('admin.layouts.body')
@section('title', 'Portaria')
@section('conteudo')
    <div class="d-flex">
        <!-- Main Content -->
        <div class="flex-grow-1 me-3">
            <h1 class="h3 mb-4">Controle de Portaria</h1>

            <!-- Search Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <form id="searchForm" class="mb-3">
                        <div class="input-group">
                            <input type="text" id="bi" name="bi" class="form-control" placeholder="Digite o BI" required>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>
                    <div id="searchResult" class="mt-3"></div>
                </div>
            </div>

            <!-- Recent Accesses Table -->
            <div class="card">
                <div class="card-header">Últimos Acessos</div>
                <div class="card-body">
                    <table class="table table-striped myTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Tipo Pessoa</th>
                                <th>Tipo Acesso</th>
                                <th>Data/Hora</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($acessos as $acesso)
                                <tr>
                                    <td>{{ $acesso->id }}</td>
                                    <td>{{ $acesso->nome_completo }}</td>
                                    <td>{{ ucfirst($acesso->tipo_pessoa) }}</td>
                                    <td>{{ $acesso->tipo }}</td>
                                    <td>{{ $acesso->data_hora }}</td>
                                    <td>{{ $acesso->observacao ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar for Morador Search -->
        <div class="morador-sidebar" style="width: 300px; min-width: 300px;">
            <div class="card sticky-top">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-search me-2"></i>Buscar Morador
                </div>
                <div class="card-body">
                    <form id="moradorSearchForm">
                        <div class="mb-3">
                            <input type="text" id="moradorSearch" class="form-control" placeholder="Digite o nome do morador">
                        </div>
                    </form>
                    <div id="moradorResults" class="mt-3">
                        <!-- Moradores will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for New Visitor -->
    <div class="modal fade" id="visitanteModal" tabindex="-1" aria-labelledby="visitanteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visitanteModalLabel">Registrar Novo Visitante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('portaria.visitante.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="primeiro_nome">Primeiro Nome</label>
                                <input type="text" class="form-control" id="primeiro_nome" name="primeiro_nome" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nomes_meio">Nomes do Meio</label>
                                <input type="text" class="form-control" id="nomes_meio" name="nomes_meio">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ultimo_nome">Último Nome</label>
                                <input type="text" class="form-control" id="ultimo_nome" name="ultimo_nome" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bi">BI</label>
                                <input type="text" class="form-control" id="bi_visitante" name="bi" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefone">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="motivo_visita">Motivo da Visita</label>
                                <textarea class="form-control" id="motivo_visita" name="motivo_visita" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="unidade_id">Unidade</label>
                                <select class="form-control select2" id="unidade_id" name="unidade_id" required>
                                    <option value="">Selecione uma unidade</option>
                                    @foreach ($unidades as $unidade)
                                        <option value="{{ $unidade->id }}">{{ $unidade->numero }} - {{ $unidade->bloco }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar Visitante</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Registering Access -->
    <div class="modal fade" id="accessModal" tabindex="-1" aria-labelledby="accessModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accessModalLabel">Registrar Acesso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="accessForm" action="{{ route('portaria.access') }}" method="POST">
                        @csrf
                        <input type="hidden" id="entidade_id" name="entidade_id">
                        <input type="hidden" id="tipo_pessoa" name="tipo_pessoa">
                        <div class="mb-3">
                            <label for="nome_pessoa" class="form-label">Pessoa</label>
                            <input type="text" id="nome_pessoa" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Acesso</label>
                            <select id="tipo" name="tipo" class="form-control" required>
                                <option value="Entrada">Entrada</option>
                                <option value="Saida">Saída</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="observacao" class="form-label">Observação</label>
                            <textarea id="observacao" name="observacao" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Morador Contact -->
    <div class="modal fade" id="moradorContactModal" tabindex="-1" aria-labelledby="moradorContactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="moradorContactModalLabel">Contato do Morador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Nome:</strong> <span id="modalMoradorNome"></span>
                    </div>
                    <div class="mb-3">
                        <strong>Unidade:</strong> <span id="modalMoradorUnidade"></span>
                    </div>
                    <div class="mb-3">
                        <strong>Telefone:</strong> <span id="modalMoradorTelefone"></span>
                        <a href="#" id="modalMoradorTelefoneLink" class="btn btn-sm btn-primary ms-2">
                            <i class="fas fa-phone"></i> Ligar
                        </a>
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> <span id="modalMoradorEmail"></span>
                    </div>
                    <div class="mb-3">
                        <button id="confirmVisit" class="btn btn-success">
                            <i class="fas fa-check"></i> Confirmar Visita
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Search and Modals -->
    <script>
        $(document).ready(function() {
            // Original BI Search
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('portaria.search') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        bi: $('#bi').val()
                    },
                    success: function(response) {
                        $('#searchResult').empty();
                        if (response.type === 'not_found') {
                            $('#searchResult').html('<div class="alert alert-warning">' + response.message + '</div>');
                            $('#visitanteModal').modal('show');
                            $('#bi_visitante').val($('#bi').val());
                        } else {
                            var name = response.data.primeiro_nome + ' ' + (response.data.nomes_meio || '') + ' ' + response.data.ultimo_nome;
                            $('#searchResult').html('<div class="alert alert-success">Encontrado: ' + name + ' (' + response.type + ')</div>');
                            $('#entidade_id').val(response.data.id);
                            $('#tipo_pessoa').val(response.type);
                            $('#nome_pessoa').val(name);
                            $('#accessModal').modal('show');
                        }
                    },
                    error: function(xhr) {
                        $('#searchResult').html('<div class="alert alert-danger">Erro ao buscar: ' + xhr.responseJSON.message + '</div>');
                    }
                });
            });

            // Morador Search
            let searchTimer;
            $('#moradorSearch').on('keyup', function() {
                clearTimeout(searchTimer);
                const searchValue = $(this).val();
                
                if (searchValue.length < 3) {
                    $('#moradorResults').empty();
                    return;
                }
                
                searchTimer = setTimeout(function() {
                    $.ajax({
                        url: '{{ route('portaria.search.morador') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name: searchValue
                        },
                        success: function(response) {
                            $('#moradorResults').empty();
                            
                            if (response.moradores.length === 0) {
                                $('#moradorResults').html('<div class="alert alert-info">Nenhum morador encontrado</div>');
                                return;
                            }
                            
                            response.moradores.forEach(function(morador) {
                                let fullName = morador.primeiro_nome + ' ' + (morador.nomes_meio ? morador.nomes_meio + ' ' : '') + morador.ultimo_nome;
                                let moradorCard = `
                                    <div class="card mb-2">
                                        <div class="card-body p-2">
                                            <h6 class="mb-1">${fullName}</h6>
                                            <p class="small mb-1">Unidade: ${morador.unidade_info}</p>
                                            <button class="btn btn-sm btn-info contact-morador" 
                                                data-id="${morador.id}" 
                                                data-nome="${fullName}" 
                                                data-unidade="${morador.unidade_info}" 
                                                data-telefone="${morador.telefone || 'Não informado'}" 
                                                data-email="${morador.email || 'Não informado'}">
                                                <i class="fas fa-phone me-1"></i> Contato
                                            </button>
                                        </div>
                                    </div>
                                `;
                                $('#moradorResults').append(moradorCard);
                            });
                            
                            // Add event listeners to the newly created buttons
                            $('.contact-morador').on('click', function() {
                                const moradorId = $(this).data('id');
                                const moradorNome = $(this).data('nome');
                                const moradorUnidade = $(this).data('unidade');
                                const moradorTelefone = $(this).data('telefone');
                                const moradorEmail = $(this).data('email');
                                
                                $('#modalMoradorNome').text(moradorNome);
                                $('#modalMoradorUnidade').text(moradorUnidade);
                                $('#modalMoradorTelefone').text(moradorTelefone);
                                $('#modalMoradorEmail').text(moradorEmail);
                                
                                if (moradorTelefone && moradorTelefone !== 'Não informado') {
                                    $('#modalMoradorTelefoneLink').attr('href', 'tel:' + moradorTelefone).show();
                                } else {
                                    $('#modalMoradorTelefoneLink').hide();
                                }
                                
                                $('#confirmVisit').data('morador-id', moradorId);
                                $('#moradorContactModal').modal('show');
                            });
                        },
                        error: function(xhr) {
                            $('#moradorResults').html('<div class="alert alert-danger">Erro ao buscar moradores</div>');
                        }
                    });
                }, 500); // Delay for 500ms to avoid sending too many requests
            });
            
            // Confirm Visit button click
            $('#confirmVisit').on('click', function() {
                const moradorId = $(this).data('morador-id');
                
                $.ajax({
                    url: '{{ route('portaria.confirm.visit') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        morador_id: moradorId
                    },
                    success: function(response) {
                        $('#moradorContactModal').modal('hide');
                        Swal.fire({
                            title: "Sucesso!",
                            text: "Visita confirmada com o morador.",
                            icon: "success",
                            confirmButtonText: "OK"
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Erro!",
                            text: "Erro ao confirmar visita: " + xhr.responseJSON.message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                });
            });
        });
    </script>

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
@endsection