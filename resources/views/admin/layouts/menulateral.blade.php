<section id="sidebar">
    <a href="#" class="brand">
        ______GESCONDO________
    </a>
    <ul class="side-menu">
@if(Auth::user()->tipo_usuario === 'admin')
        <li>
            <a href="{{ route('admin.home.index') }}" class="active">
                <i class="fas fa-home icon"></i>
                Dashboard
            </a>
        </li>
        <!-- Gestão de Propriedades -->
        <li class="divider" data-text="Gestão de Propriedades"></li>
        
        <li>
            <a href="#">
                <i class="fas fa-building icon"></i>
                Propriedades
                <i class="fas fa-angle-right icon-right"></i>
            </a>
            <ul class="side-dropdown">
                <!-- <li><a href="{{ route('admin.condominio.index') }}"><i class="fas fa-building icon"></i> Condomínio</a></li> -->
                <li><a href="{{ route('admin.bloco.index') }}"><i class="fas fa-th-large icon"></i> Blocos</a></li>
                <li><a href="{{ route('admin.edificio.index') }}"><i class="fas fa-building icon"></i> Edifícios</a></li>
                <li><a href="{{ route('admin.unidade.index') }}"><i class="fas fa-home icon"></i> Unidades</a></li>
                <li><a href="{{ route('admin.espaco-comum.index') }}"><i class="fas fa-vector-square icon"></i> Outros Espaços</a></li>
                <!-- <li><a href="{{ route('admin.espaco-reserva.index') }}"><i class="fas fa-calendar-check icon"></i> Reservas de Espaços</a></li> -->
            </ul>
        </li>
        
        <!-- Gestão de Pessoas -->
        <li class="divider" data-text="Gestão de Pessoas"></li>
        
        <li>
            <a href="#">
                <i class="fas fa-users icon"></i>
                Pessoas
                <i class="fas fa-angle-right icon-right"></i>
            </a>
            <ul class="side-dropdown">
                <li><a href="{{ route('admin.user.index') }}"><i class="fas fa-users-cog icon"></i> Usuários</a></li>
                <li><a href="{{ route('admin.departamento.index') }}"><i class="fas fa-sitemap icon"></i> Departamentos</a></li>
                <li><a href="{{ route('admin.funcionario.index') }}"><i class="fas fa-user-tie icon"></i> Funcionários</a></li>
                <li><a href="{{ route('admin.morador.index') }}"><i class="fas fa-users icon"></i> Pessoas</a></li>
                <li><a href="{{ route('admin.visitante.index') }}"><i class="fas fa-user-friends icon"></i> Visitantes</a></li>
                <li><a href="{{ route('admin.acesso.index') }}"><i class="fas fa-door-open icon"></i> Acessos</a></li>
            </ul>
        </li>
        
        <!-- Gestão Financeira -->
        <li class="divider" data-text="Gestão Financeira"></li>
        
        <li>
            <a href="#">
                <i class="fas fa-money-bill-wave icon"></i>
                Finanças
                <i class="fas fa-angle-right icon-right"></i>
            </a>
            <ul class="side-dropdown">
                <li><a href="{{ route('admin.factura.index') }}"><i class="fas fa-file-invoice-dollar icon"></i> Faturas</a></li>
                <li><a href="{{ route('admin.pagamento.index') }}"><i class="fas fa-hand-holding-usd icon"></i> Pagamentos</a></li>
                <li><a href="{{ route('admin.despesa.index') }}"><i class="fas fa-shopping-cart icon"></i> Despesas</a></li>
                <li><a href="{{ route('admin.conta.index') }}"><i class="fas fa-piggy-bank icon"></i> Contas</a></li>
                <!-- <li><a href="{{ route('admin.rupe.index') }}"><i class="fas fa-coins icon"></i> Rupe</a></li> -->
            </ul>
        </li>
        
        <!-- Votações e Comunicação -->
        <li class="divider" data-text="Votações e Comunicação"></li>
        
        <li>
            <a href="#">
                <i class="fas fa-vote-yea icon"></i>
                Votações
                <i class="fas fa-angle-right icon-right"></i>
            </a>
            <ul class="side-dropdown">
                <li><a href="{{ route('admin.votacao.index') }}"><i class="fas fa-vote-yea icon"></i> Votações</a></li>
                <li><a href="{{ route('admin.opcao-votacao.index') }}"><i class="fas fa-list-ul icon"></i> Opções de Votação</a></li>
                <li><a href="{{ route('admin.voto.index') }}"><i class="fas fa-ballot-check icon"></i> Votos</a></li>
            </ul>
        </li>

        <li>
            <a href="#">
                <i class="fas fa-comments icon"></i>
                Comunicação
                <i class="fas fa-angle-right icon-right"></i>
            </a>
            <ul class="side-dropdown">
                <li><a href="{{ route('admin.chat-post.index') }}"><i class="fas fa-comments icon"></i> Posts de Chat</a></li>
                <li><a href="{{ route('admin.chat-comentario.index') }}"><i class="fas fa-comment-dots icon"></i> Comentários</a></li>
                <!-- <li><a href="{{ route('admin.notificacao.index') }}"><i class="fas fa-bell icon"></i> Notificações</a></li> -->
            </ul>
        </li>

        <!-- Relatórios -->
        <li class="divider" data-text="Relatórios"></li>
        
        <li>
            <a href="#">
                <i class="fas fa-file-alt icon"></i>
                Relatórios
                <i class="fas fa-angle-right icon-right"></i>
            </a>
            <ul class="side-dropdown">
                <li><a href="{{ route('pdf.index') }}"><i class="fas fa-home icon"></i> Relatórios</a></li>
            </ul>
        </li>
        
@endif
@if(Auth::user()->tipo_usuario === 'funcionario')
    <!-- Gestão de Pessoas e Portaria -->
    <li class="divider" data-text="Gestão de Pessoas e Portaria"></li>
    
    <li>
        <a href="#">
            <i class="fas fa-users icon"></i>
            Pessoas
            <i class="fas fa-angle-right icon-right"></i>
        </a>
        <ul class="side-dropdown">
            <li><a href="{{ route('portaria.index') }}"><i class="fas fa-user-friends icon"></i> Portaria</a></li>
            <!-- <li><a href="{{ route('admin.visitante.index') }}"><i class="fas fa-user-friends icon"></i> Visitantes</a></li>
            <li><a href="{{ route('admin.acesso.index') }}"><i class="fas fa-door-open icon"></i> Acessos</a></li> -->
        </ul>
    </li>
@endif
    </ul>
</section>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>