@extends('admin.layouts.body')
@section('title', 'Listar Alocações')
@section('conteudo')
@if(Auth::user()->vc_tipo == 'admin')
    <h1 class="h3">Tabela de Alocações</h1>
    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#alocacaoModal">Nova Alocação</button>
        <div>
            <a href="{{ route('admin.alocacao.trash') }}" class="btn btn-secondary">
                <i class="fas fa-trash"></i> Lixeira
            </a>
        </div>
    </div>

    <div class="card p-4">
        <h5 class="card-title mt-4 mb-4">Pesquisar Alocações</h5>
        
        <table class="table table-striped myTable" id="pesquisaTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Especialidade</th>
                    <th>Local</th>
                    <th>Subsector</th>
                    <th>Unidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alocacaos as $alocacao)
                    <tr>
                        <td>{{ $alocacao->id }}</td>
                        <td>{{ $alocacao->especialidade->vc_nome ?? 'N/A' }}</td>
                        <td>{{ $alocacao->local->vc_nome }}</td>
                        <td>{{ $alocacao->subsector->vc_nome }}</td>
                        <td>{{ $alocacao->unidade->vc_nome }}</td>
                        <td>
                            <a class="btn btn-warning btn-sm edit-alocacao" data-bs-toggle="modal"
                                data-bs-target="#editar_modal{{ $alocacao->id }}">Editar</a>
                            <a class="btn btn-danger btn-sm"
                                href="{{ route('admin.alocacao.destroy', ['id' => $alocacao->id]) }}"
                                onclick="return confirm('Tem certeza que deseja excluir esta alocação?')">Deletar</a>
                        </td>
                    </tr>

                    <div class="modal fade" id="editar_modal{{ $alocacao->id }}" tabindex="-1"
                        aria-labelledby="editar_modal{{ $alocacao->id }}Label" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editar_modal{{ $alocacao->id }}Label">Editar Alocação</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @include('admin.alocacao.editar.index', ['alocacao' => $alocacao])
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        <div class="modal fade" id="alocacaoModal" tabindex="-1" aria-labelledby="alocacaoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alocacaoModalLabel">Cadastro de Alocação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @include('admin.alocacao.cadastrar.index')
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_alocacao" tabindex="-1" aria-labelledby="modal_alocacao" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Relatório de Alocações</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
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
@endif