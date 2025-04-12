@extends('admin.layouts.body')
@section('title', 'Alocações na Lixeira')
@section('conteudo')
    <h1 class="h3">Tabela de Alocações Apagadas</h1>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.alocacao.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    
    <div class="card p-4">
        <h5 class="card-title mt-4 mb-4">Pesquisar Alocações Apagadas</h5>
        
        <table class="table table-striped myTable" id="pesquisaTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Especialidade</th>
                    <th>Local</th>
                    <th>Subsector</th>
                    <th>Unidade</th>
                    <th>Data de Exclusão</th>
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
                        <td>{{ $alocacao->deleted_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.alocacao.restore', $alocacao->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                            </form>
                            <form action="{{ route('admin.alocacao.purge', $alocacao->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Tem certeza que deseja excluir permanentemente esta alocação?')">
                                    Excluir Permanentemente
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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