@extends('publico.layouts.body')
@section('title', 'Editar Ocorrência')
@section('conteudo')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="card-title mb-0">Editar Ocorrência</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('morador.ocorrencia.update', $ocorrencia->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('morador.ocorrencia._form')
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('morador.ocorrencia.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-warning">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsectio