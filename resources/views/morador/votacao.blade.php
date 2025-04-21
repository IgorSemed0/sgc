@extends('publico.layouts.body')

@section('title', 'Votações')

@section('conteudo')
    <h1 class="h3 mb-4">Votações Ativas</h1>
    <div class="row">
        @foreach ($votacaos as $votacao)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">{{ $votacao->titulo }}</div>
                    <div class="card-body">
                        <p>{{ $votacao->descricao }}</p>
                        <form action="{{ route('morador.votacao.vote') }}" method="POST">
                            @csrf
                            <input type="hidden" name="votacao_id" value="{{ $votacao->id }}">
                            <div class="form-group mb-2">
                                <label for="opcao_id_{{ $votacao->id }}">Escolha uma opção</label>
                                <select name="opcao_id" id="opcao_id_{{ $votacao->id }}" class="form-control">
                                    @foreach ($votacao->opcaoVotacaos as $opcao)
                                        <option value="{{ $opcao->id }}">{{ $opcao->descricao }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Votar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection