@extends('publico.layouts.body')

@section('title', 'Perfil')

@section('conteudo')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">

        <h1 class="h3 mb-3 mb-md-0"><i class="fas fa-newspaper text-primary me-2"></i>Perfil</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <!-- Profile Information -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Informações do Perfil</h5>
                    <form action="{{ route('morador.perfil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="primeiro_nome">Primeiro Nome</label>
                            <input type="text" name="primeiro_nome" class="form-control" value="{{ $user->primeiro_nome }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomes_meio">Nomes do Meio</label>
                            <input type="text" name="nomes_meio" class="form-control" value="{{ $user->nomes_meio }}">
                        </div>
                        <div class="mb-3">
                            <label for="ultimo_nome">Último Nome</label>
                            <input type="text" name="ultimo_nome" class="form-control" value="{{ $user->ultimo_nome }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="bi">BI</label>
                            <input type="text" name="bi" class="form-control" value="{{ $user->bi }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="{{ $user->telefone }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Atualizar Senha</h5>
                    <form action="{{ route('morador.perfil.updatePassword') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password">Senha Atual</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password">Nova Senha</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation">Confirme a Nova Senha</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar Senha</button>
                    </form>
                </div>
            </div>

            <!-- Two-Factor Authentication -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Autenticação de Dois Fatores</h5>
                    @if ($user->two_factor_confirmed_at)
                        <p>Autenticação de dois fatores está ativada.</p>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#twoFactorModal">Gerenciar</button>
                    @else
                        <p>Autenticação de dois fatores não está ativada.</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#twoFactorModal">Ativar</button>
                    @endif
                </div>
            </div>

            <!-- Logout Other Sessions -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Sessões do Navegador</h5>
                    <p>Gerencie e saia das suas sessões ativas em outros navegadores e dispositivos.</p>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#logoutOtherSessionsModal">Sair de Outras Sessões</button>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Excluir Conta</h5>
                    <p>Exclua permanentemente sua conta.</p>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Excluir Conta</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Two-Factor Authentication Modal -->
<div class="modal fade" id="twoFactorModal" tabindex="-1" aria-labelledby="twoFactorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="twoFactorModalLabel">Autenticação de Dois Fatores</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($user->two_factor_confirmed_at)
                    <p>Autenticação de dois fatores está ativada.</p>
                    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#recoveryCodesModal">Mostrar Códigos de Recuperação</button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#disableTwoFactorModal">Desativar</button>
                @else
                    <p>Escaneie o código QR com seu aplicativo de autenticação e insira o código gerado.</p>
                    <div id="qrCodeContainer" class="mb-3"></div>
                    <form id="confirmTwoFactorForm" method="POST" action="{{ route('morador.perfil.confirmTwoFactor') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="code">Código</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recovery Codes Modal -->
<div class="modal fade" id="recoveryCodesModal" tabindex="-1" aria-labelledby="recoveryCodesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recoveryCodesModalLabel">Códigos de Recuperação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Insira sua senha para ver os códigos de recuperação.</p>
                <form id="showRecoveryCodesForm" method="POST" action="{{ route('morador.perfil.showRecoveryCodes') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="password">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Mostrar Códigos</button>
                </form>
                <div id="recoveryCodesContainer"></div>
            </div>
        </div>
    </div>
</div>

<!-- Disable Two-Factor Modal -->
<div class="modal fade" id="disableTwoFactorModal" tabindex="-1" aria-labelledby="disableTwoFactorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disableTwoFactorModalLabel">Desativar Autenticação de Dois Fatores</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Insira sua senha para desativar a autenticação de dois fatores.</p>
                <form id="disableTwoFactorForm" method="POST" action="{{ route('morador.perfil.disableTwoFactor') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="password">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Desativar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Logout Other Sessions Modal -->
<div class="modal fade" id="logoutOtherSessionsModal" tabindex="-1" aria-labelledby="logoutOtherSessionsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutOtherSessionsModalLabel">Sair de Outras Sessões</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Insira sua senha para sair de todas as outras sessões.</p>
                <form id="logoutOtherSessionsForm" method="POST" action="{{ route('morador.perfil.logoutOtherSessions') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="password">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Sair de Outras Sessões</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Excluir Conta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Insira sua senha para excluir permanentemente sua conta.</p>
                <form id="deleteAccountForm" method="POST" action="{{ route('morador.perfil.deleteAccount') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="password">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Excluir Conta</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Load QR code when two-factor modal is opened
    $('#twoFactorModal').on('show.bs.modal', function() {
        if (!{{ $user->two_factor_confirmed_at ? 'true' : 'false' }}) {
            $.ajax({
                url: '{{ route('morador.perfil.twoFactorQrCode') }}',
                method: 'GET',
                success: function(data) {
                    $('#qrCodeContainer').html(data);
                },
                error: function() {
                    alert('Erro ao carregar o código QR.');
                }
            });
        }
    });

    // Confirm Two-Factor Form
    $('#confirmTwoFactorForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    let codesHtml = '<p>Autenticação de dois fatores ativada. Guarde estes códigos de recuperação:</p><ul>';
                    response.recovery_codes.forEach(function(code) {
                        codesHtml += '<li>' + code + '</li>';
                    });
                    codesHtml += '</ul>';
                    $('#twoFactorModal .modal-body').html(codesHtml);
                } else {
                    alert('Código inválido.');
                }
            }
        });
    });

    // Show Recovery Codes
    $('#showRecoveryCodesForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.codes) {
                    let codesHtml = '<p>Códigos de Recuperação:</p><ul>';
                    response.codes.forEach(function(code) {
                        codesHtml += '<li>' + code + '</li>';
                    });
                    codesHtml += '</ul>';
                    $('#recoveryCodesContainer').html(codesHtml);
                    $('#showRecoveryCodesForm').hide();
                }
            },
            error: function() {
                alert('Senha incorreta.');
            }
        });
    });

    // Disable Two-Factor
    $('#disableTwoFactorForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function() {
                alert('Autenticação de dois fatores desativada.');
                location.reload();
            },
            error: function() {
                alert('Senha incorreta.');
            }
        });
    });

    // Logout Other Sessions
    $('#logoutOtherSessionsForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function() {
                alert('Outras sessões encerradas.');
                $('#logoutOtherSessionsModal').modal('hide');
            },
            error: function() {
                alert('Senha incorreta.');
            }
        });
    });

    // Delete Account
    $('#deleteAccountForm').on('submit', function(e) {
        e.preventDefault();
        if (confirm('Tem certeza que deseja excluir sua conta?')) {
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function() {
                    window.location.href = '/';
                },
                error: function() {
                    alert('Senha incorreta.');
                }
            });
        }
    });
});
</script>
@endpush
@endsection