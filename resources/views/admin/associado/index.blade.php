@extends('admin.layouts.body')
@section('title', 'Listar Pacientes')
@section('conteudo')
    <h1 class="h3">Tabela de Pacientes</h1>
    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#associadoModal">Novo Pacientes</button>
        <div>
            <a href="{{ route('pdf.associado.index') }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Gerar Relatório
            </a>  
            <a href="{{ route('admin.associado.trash') }}" class="btn btn-secondary">
                <i class="fas fa-trash"></i> Lixeira
            </a>
        </div>
    </div>
    <div class="card p-4">
        <h5 class="card-title mt-4 mb-4">Pesquisar Paciente</h5>
        
        <table class="table table-striped myTable" id="pesquisaTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Processo</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Gênero</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($associados as $associado)
                    <tr>
                        <td>{{ $associado->id }}</td>
                        <td>{{ $associado->vc_pnome }} {{ $associado->vc_unome }}</td>
                        <td>{{ $associado->vc_tipo }}</td>
                        <td>{{ $associado->vc_processo }}</td>
                        <td>{{ $associado->vc_email }}</td>
                        <td>{{ $associado->vc_telefone }}</td>
                        <td>{{ $associado->vc_genero }}</td>
                        <td>
                            <a class="btn btn-warning btn-sm edit-associado" data-bs-toggle="modal"
                                data-bs-target="#editar_modal{{ $associado->id }}">Editar</a>
                            <form action="{{ route('admin.associado.delete', ['id' => $associado->id]) }}"
                                  method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Deletar</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editar_modal{{ $associado->id }}" tabindex="-1"
                        aria-labelledby="editar_modal" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editar_modal">Editar Associado</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                @include('admin.associado.editar.index', ['associado' => $associado])
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        <ul class="pagination" id="pagination"></ul>
        <div class="modal fade" id="associadoModal" tabindex="-1" aria-labelledby="associadoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="associadoModalLabel">Cadastro de Pacientes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @include('admin.associado.cadastrar.index')
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
@endsection