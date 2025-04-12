@extends('admin.layouts.body')
@section('title', 'Listar Associados Apagados')
@section('conteudo')
    <h1 class="h3">Tabela de Associados Apagados</h1>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.associado.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    
    <div class="card p-4">
        <h5 class="card-title mt-4 mb-4">Pesquisar Associado</h5>
        
        <table class="table table-striped myTable" id="pesquisaTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Processo</th>
                    <th>Email</th>
                    <th>Telefone</th>
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
                        <td>
                            <form action="{{ route('admin.associado.restore', $associado->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                            </form>
                            <form action="{{ route('admin.associado.purge', $associado->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Tem certeza que deseja excluir permanentemente este associado?')">
                                    Excluir Permanentemente
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <ul class="pagination" id="pagination"></ul>
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