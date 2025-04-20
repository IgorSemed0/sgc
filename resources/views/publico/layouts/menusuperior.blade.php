<nav>
    <i class="toggle-sidebar fas fa-bars icon" id="toggle-sidebar"></i>
    <form action="#">
        <div class="form-group">
            <input type="text" placeholder="Pesquisar">
            <i class="fas fa-search icon"></i>
        </div>
    </form>
    @if (auth()->user()->tipo_usuario == 'admin')
        <a href="{{ route('admin.notificacao.index') }}" class="nav-link">
            <i class="fas fa-bell icon"></i>
            @php
                $notificacoesNaoLidas = auth()->user()->notificacoes()->where('bl_estado', false)->orderBy('created_at', 'desc')->get();
            @endphp
            <span id="notification-counter" class="badge {{ $notificacoesNaoLidas->count() == 0 ? 'd-none' : '' }}">
                {{ $notificacoesNaoLidas->count() }}
            </span>
        </a>
    @elseif (auth()->user()->tipo_usuario == 'morador')
        <a href="{{ route('morador.feed') }}" class="nav-link">
            <i class="fas fa-rss icon"></i> Feed
        </a>
        <a href="{{ route('morador.votacao') }}" class="nav-link">
            <i class="fas fa-vote-yea icon"></i> Votações
        </a>
    @endif
    <div class="profile">
        @php
            $fotoPerfil = Auth::user()->vc_foto_perfil ? Storage::url(Auth::user()->vc_foto_perfil) : asset('assets/images/user.jpg');
        @endphp
        <img src="{{ $fotoPerfil }}" alt="Foto de perfil">
        <ul class="profile-link">
            <li><a href="{{ route('morador.perfil') }}"><i class="fas fa-user icon"></i> Perfil</a></li>
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt icon"></i> Sair</a></li>
        </ul>
    </div>
</nav>