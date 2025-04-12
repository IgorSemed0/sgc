<nav>
    <i class="toggle-sidebar fas fa-bars icon"></i>
    <form action="#">
        <div class="form-group">
            <input type="text" placeholder="Pesquisar">
            <i class="fas fa-search icon"></i>
        </div>
    </form>
    
    @if (Auth::user()->vc_tipo == 'admin')
        <a href="{{ route('admin.notificacao.index') }}" class="nav-link">
            <i class="fas fa-bell icon"></i>
            @php
                $notificacoesNaoLidas = auth()
                    ->user()
                    ->notificacoes()
                    ->where('bl_estado', false)
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp
            <span id="notification-counter" class="badge {{ $notificacoesNaoLidas->count() == 0 ? 'd-none' : '' }}">
                {{ $notificacoesNaoLidas->count() }}
            </span>
        </a>
    @endif
    
    <a href="#" class="nav-link">
        <i class="fas fa-envelope icon"></i>
        <span class="badge">3</span>
    </a>
    
    <span class="divider"></span>
    
    <div class="profile">
        @php
            $fotoPerfil = Auth::user()->vc_foto_perfil
                ? Storage::url(Auth::user()->vc_foto_perfil)
                : asset('assets/images/user.jpg');
        @endphp
        <img src="{{ $fotoPerfil }}" alt="Foto de perfil">
        <ul class="profile-link">
            <li>
                <a href="#">
                    <i class="fas fa-user icon"></i> Perfil
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-cog icon"></i> Configurações
                </a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt icon"></i> Sair
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>