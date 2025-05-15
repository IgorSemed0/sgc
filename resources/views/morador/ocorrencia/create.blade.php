@extends('publico.layouts.body')
@section('title', 'Nova Ocorrência')
@section('conteudo')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Registrar Nova Ocorrência</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('morador.ocorrencia.store') }}" method="POST">
                        @csrf
                        {{$ocorrencia=null}}
                        @include('morador.ocorrencia._form')
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('morador.ocorrencia.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection