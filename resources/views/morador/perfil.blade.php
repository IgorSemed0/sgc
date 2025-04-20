@extends('publico.layouts.body')

@section('title', 'Perfil')

@section('conteudo')
    <h1 class="h3 mb-4">Perfil do Usuário</h1>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('morador.perfil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="primeiro_nome">Primeiro Nome</label>
                            <input type="text" name="primeiro_nome" class="form-control" value="{{ $user->primeiro_nome }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nomes_meio">Nomes do Meio</label>
                            <input type="text" name="nomes_meio" class="form-control" value="{{ $user->nomes_meio }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="ultimo_nome">Último Nome</label>
                            <input type="text" name="ultimo_nome" class="form-control" value="{{ $user->ultimo_nome }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Senha (deixe em branco para manter a atual)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="bi">BI</label>
                            <input type="text" name="bi" class="form-control" value="{{ $user->bi }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="{{ $user->telefone }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection