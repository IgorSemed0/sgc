@extends('admin.layouts.body')
@section('title', 'Portaria')
@section('conteudo')
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

    <!-- JavaScript for Search and Modals -->
    <script>
        $(document).ready(function() {
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