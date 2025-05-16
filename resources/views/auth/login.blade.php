@extends('admin.layouts.app')

@section('title', 'Login | GesCondo')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <h1 class="fw-bold" style="font-size: 2.5rem; color: #1775f1;">
                    <i class="fas fa-building me-2"></i>GesCondo
                </h1>
                <!-- <p class="text-muted lead">Sistema de Gestão de Condomínio</p> -->
            </div>
            
            <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-primary text-white text-center py-4" style="background: linear-gradient(135deg, #1775f1, #0c5fcd) !important;">
                    <h3 class="mb-0">Bem-vindo de volta</h3>
                    <p class="mb-0 opacity-75">Acesse sua conta para continuar</p>
                </div>
                
                <div class="card-body p-5">
                    @if (session('status'))
                        <div class="alert alert-success mb-4 border-0 shadow-sm" style="border-radius: 10px;">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4 border-0 shadow-sm" style="border-radius: 10px;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text bg-white border-end-0" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                       style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;" 
                                       placeholder="seu@email.com" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                            </div>
                            @error('email')
                                <div class="text-danger mt-2 ps-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label fw-bold">Senha</label>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small" href="{{ route('password.request') }}">
                                        Esqueceu sua senha?
                                    </a>
                                @endif
                            </div>
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text bg-white border-end-0" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                       style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;" 
                                       placeholder="••••••••" name="password" required autocomplete="current-password">
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger mt-2 ps-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember_me" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember_me">Lembrar-me neste dispositivo</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, #1775f1, #0c5fcd);">
                                <i class="fas fa-sign-in-alt me-2"></i>Entrar
                            </button>
                        </div>
                    </form>
                    
                    <hr class="my-4" hidden>
                    
                    <div class="text-center" hidden>
                        <p>Não tem uma conta ainda? <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Cadastre-se</a></p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted small">
                    <i class="fas fa-shield-alt me-1"></i> Área segura | &copy; {{ date('Y') }} GesCondo
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
    
    // Add floating effect to login card
    const loginCard = document.querySelector('.card');
    loginCard.addEventListener('mousemove', function(e) {
        const rect = loginCard.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / loginCard.offsetWidth) - 0.5;
        const y = ((e.clientY - rect.top) / loginCard.offsetHeight) - 0.5;
        
        loginCard.style.transform = `perspective(1000px) rotateY(${x * 5}deg) rotateX(${y * -5}deg)`;
    });
    
    loginCard.addEventListener('mouseleave', function() {
        loginCard.style.transform = 'perspective(1000px) rotateY(0) rotateX(0)';
        loginCard.style.transition = 'transform 0.5s ease';
    });
});
</script>
@endsection