<style>
    .espaço {
        margin: 0 30px;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse espaço d-flex align-items-center" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                @if (Auth::user()->vc_tipo == 'admin')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell" aria-hidden="true"></i>

                            @php
                                $notificacoesNaoLidas = auth()
                                    ->user()
                                    ->notificacoes()
                                    ->where('bl_estado', false)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                            @endphp


                            <span id="notification-counter"
                                class="badge bg-danger {{ $notificacoesNaoLidas->count() == 0 ? 'd-none' : '' }}">
                                {{ $notificacoesNaoLidas->count() }}
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-2 rounded-3 "
                            style="width: 350px;" aria-labelledby="notificationsDropdown">
                            @forelse($notificacoesNaoLidas->take(5) as $notificacao)
                                <li class="dropdown-item px-3 py-2">
                                    <div class="d-flex align-items-start ">
                                        <!-- Ícone de notificação -->
                                        <div class="me-2">
                                            <i class="bi bi-bell-fill text-primary fs-5"></i>
                                        </div>

                                        <div class="flex-grow-1">
                                            <a href="{{ route('admin.notificacao.show', $notificacao->id) }}"
                                                class="text-primary medium" style="text-decoration: none;">
                                                <!-- Cabeçalho: Título + Data/Hora -->
                                                <div class="d-flex justify-content-between align-items-center">

                                                    <small class="text-muted">
                                                        {{ $notificacao->created_at->isToday() ? 'Hoje, às ' . $notificacao->created_at->format('H:i') : $notificacao->created_at->format('d/m/Y') }}
                                                    </small>
                                                </div>


                                                <!-- Corpo da Notificação -->
                                                <p class="mb-1 text-secondary text-truncate" style="max-width: 280px;">
                                                    {{ Str::limit($notificacao->txt_mensagem, 60, '...') }}
                                                </p>

                                                <!-- Link para visualizar a notificação -->
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @empty
                                <li><span class="dropdown-item text-center text-muted py-2">Sem notificações</span></li>
                            @endforelse

                            <!-- Link para ver todas as notificações -->
                            <li class="text-center">
                                <a class="dropdown-item fw-bold text-primary py-2"
                                    href="{{ route('admin.notificacao.index') }}">
                                    Ver todas as notificações
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif



                <!-- Informações do usuário -->
                <li class="nav-item dropdown user-info">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">

                        @php
                            $fotoPerfil = Auth::user()->vc_foto_perfil
                                ? Storage::url(Auth::user()->vc_foto_perfil)
                                : asset('assets/images/user.jpg');
                        @endphp

                        <img src="{{ $fotoPerfil }}" alt="Foto de perfil"
                            class="rounded-square border img-hm overflow-hidden"
                            style="width: 40px; height: 40px; object-fit: cover;">

                        <span class="ms-2">{{ auth()->user()->vc_pnome }}</span>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown"profile.show>

                        <!-- <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user"></i> -->
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i>
                                Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cogs"></i> Configurações</a></li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Sair
                                </button>
                            </li>
                        </form>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
