<section id="sidebar">
    <a href="#" class="brand ">
        <!-- <i class="icon logo">
            <img src="{{ asset('assets/images/logo.jpg') }}" class="logo" alt="Logo">
        </i> -->
        PIGC
    </a>
    <ul class="side-menu">
        <li>
            <a href="#" class="active">
                <i class="fas fa-home icon"></i>
                Dashboard
            </a>
        </li>
        
        <li class="divider" data-text="Condomínios">Condomínio</li>
        <li>
            <a href="#">
                <i class="fas fa-building icon"></i>
                Condomínios
                <i class="fas fa-angle-right icon-right"></i>
            </a>
            <ul class="side-dropdown">
                <li><a href="{{ route('admin.condominio.index') }}">Listar</a></li>
            </ul>
        </li>

        <li>
            <a href="{{ route('admin.bloco.index') }}">
                <i class="fas fa-th-large icon"></i>
                Blocos
            </a>
        </li>

        <li>
            <a href="{{ route('admin.edificio.index') }}">
                <i class="fas fa-building icon"></i>
                Edifícios
            </a>
        </li>

        <li>
            <a href="{{ route('admin.unidade.index') }}">
                <i class="fas fa-home icon"></i>
                Unidades
            </a>
        </li>
        <!-- You can add more menu items based on your system requirements -->
        <li class="divider" data-text="Usuários">Usuários</li>
        <li>
            <a href="#">
                <i class="fas fa-users icon"></i>
                Usuários
                <i class="fas fa-angle-right icon-right"></i>
            </a>
            <ul class="side-dropdown">
                <li><a href="#">Cadastrar</a></li>
                <li><a href="#">Listar</a></li>
            </ul>
        </li>
        
        <li class="divider" data-text="Administração">Administração</li>
        <li>
            <a href="#">
                <i class="fas fa-cogs icon"></i>
                Configurações
                <i class="fas fa-angle-right icon-right"></i>
            </a>
            <ul class="side-dropdown">
                <li><a href="#">Sistema</a></li>
                <li><a href="#">Permissões</a></li>
            </ul>
        </li>
    </ul>
    
    <div class="ads">
        <div class="wrapper">
            <a href="#" class="btn-upgrade">Ver mais</a>
            <p>Todas as informações sobre o <span>SGC</span> que o <span>Admin</span> precisa saber</p>
        </div>
    </div>
</section>