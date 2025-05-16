@extends('admin.layouts.app')

@section('title', 'Registro')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-white text-center py-4">
                    <h1>GesCondo</h1>
                    <h4 class="mb-0">Criar Conta</h4>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="primeiro_nome" class="form-label">Primeiro Nome</label>
                                <input id="primeiro_nome" type="text" class="form-control @error('primeiro_nome') is-invalid @enderror" name="primeiro_nome" value="{{ old('primeiro_nome') }}" required autofocus autocomplete="given-name">
                                @error('primeiro_nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="nomes_meio" class="form-label">Nomes do Meio (Opcional)</label>
                                <input id="nomes_meio" type="text" class="form-control @error('nomes_meio') is-invalid @enderror" name="nomes_meio" value="{{ old('nomes_meio') }}" autocomplete="additional-name">
                                @error('nomes_meio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ultimo_nome" class="form-label">Último Nome</label>
                                <input id="ultimo_nome" type="text" class="form-control @error('ultimo_nome') is-invalid @enderror" name="ultimo_nome" value="{{ old('ultimo_nome') }}" required autocomplete="family-name">
                                @error('ultimo_nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Nome de Usuário</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">
                                </div>
                                @error('username')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="bi" class="form-label">BI (Documento)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input id="bi" type="text" class="form-control @error('bi') is-invalid @enderror" name="bi" value="{{ old('bi') }}" required>
                                </div>
                                @error('bi')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone (Opcional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input id="telefone" type="tel" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone') }}" autocomplete="tel">
                                </div>
                                @error('telefone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_usuario" class="form-label">Tipo de Usuário</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-users-cog"></i></span>
                                <select id="tipo_usuario" name="tipo_usuario" class="form-select @error('tipo_usuario') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('tipo_usuario') ? '' : 'selected' }}>Selecione...</option>
                                    <option value="admin" {{ old('tipo_usuario') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="morador" {{ old('tipo_usuario') == 'morador' ? 'selected' : '' }}>Morador</option>
                                    <option value="funcionario" {{ old('tipo_usuario') == 'funcionario' ? 'selected' : '' }}>Funcionário</option>
                                    <option value="outro" {{ old('tipo_usuario') == 'outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>
                            @error('tipo_usuario')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" name="terms" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    {!! __('Eu concordo com os :terms_of_service e :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-decoration-none">Termos de Serviço</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-decoration-none">Política de Privacidade</a>',
                                    ]) !!}
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Registrar
                            </button>
                        </div>

                        <div class="mt-3 text-center">
                            <p>Já tem uma conta? <a href="{{ route('login') }}" class="text-decoration-none">Faça login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection