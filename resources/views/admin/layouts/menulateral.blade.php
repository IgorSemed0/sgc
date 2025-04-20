<section id="sidebar">
    <a href="#" class="brand ">
        <!-- <i class="icon logo">
            <img src="{{ asset('assets/images/logo.jpg') }}" class="logo" alt="Logo">
        </i> -->
        PIGC
    </a>
    <ul class="side-menu">
        <li>
            <a href="{{ route('admin.home.index') }}" class="active">
                <i class="fas fa-home icon"></i>
                Dashboard
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.condominio.index') }}">
                <i class="fas fa-building icon"></i>
                Condomínio
            </a>
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

        <li>
            <a href="{{ route('admin.departamento.index') }}">
                <i class="fas fa-sitemap icon"></i>
                Departamentos
            </a>
        </li>

        <li>
            <a href="{{ route('admin.funcionario.index') }}">
                <i class="fas fa-user-tie icon"></i>
                Funcionários
            </a>
        </li>

        <li>
            <a href="{{ route('admin.morador.index') }}">
                <i class="fas fa-users icon"></i>
                Moradores
            </a>
        </li>

        <li>
            <a href="{{ route('admin.visitante.index') }}">
                <i class="fas fa-user-friends icon"></i>
                Visitantes
            </a>
        </li>

        <li>
            <a href="{{ route('admin.acesso.index') }}">
                <i class="fas fa-door-open icon"></i>
                Acessos
            </a>
        </li>

        <li>
            <a href="{{ route('admin.factura.index') }}">
                <i class="fas fa-file-invoice-dollar icon"></i>
                Faturas
            </a>
        </li>

        <li>
            <a href="{{ route('admin.factura-item.index') }}">
                <i class="fas fa-file-invoice icon"></i>
                Itens de Fatura
            </a>
        </li>

        <li>
            <a href="{{ route('admin.pagamento.index') }}">
                <i class="fas fa-money-bill-wave icon"></i>
                Pagamentos
            </a>
        </li>
        <li>
            <a href="{{ route('admin.despesa.index') }}">
                <i class="fas fa-shopping-cart icon"></i>
                Despesas
            </a>
        </li>
        <li>
            <a href="{{ route('admin.conta.index') }}">
                <i class="fas fa-piggy-bank icon"></i>
                Contas
            </a>
        </li>
        <li>
            <a href="{{ route('admin.movimento.index') }}">
                <i class="fas fa-exchange-alt icon"></i>
                Movimentos
            </a>
        </li>
        <li>
            <a href="{{ route('admin.rupe.index') }}">
                <i class="fas fa-coins icon"></i>
                Receitas
            </a>
        </li>
        <li>
            <a href="{{ route('admin.votacao.index') }}">
                <i class="fas fa-vote-yea icon"></i>
                Votações
            </a>
        </li>
        <li>
            <a href="{{ route('admin.opcao-votacao.index') }}">
                <i class="fas fa-list-ul icon"></i>
                Opções de Votação
            </a>
        </li>
        <li>
            <a href="{{ route('admin.voto.index') }}">
                <i class="fas fa-ballot icon"></i>
                Votos
            </a>
        </li>
        <li>
            <a href="{{ route('admin.espaco-comum.index') }}">
                <i class="fas fa-building icon"></i>
                Espaços Comuns
            </a>
        </li>
        <li>
            <a href="{{ route('admin.espaco-reserva.index') }}">
                <i class="fas fa-calendar-check icon"></i>
                Reservas de Espaços
            </a>
        </li>
        <li>
            <a href="{{ route('admin.chat-post.index') }}">
                <i class="fas fa-comments icon"></i>
                Posts de Chat
            </a>
        </li>
        <li>
            <a href="{{ route('admin.chat-comentario.index') }}">
                <i class="fas fa-comment-dots icon"></i>
                Comentários de Chat
            </a>
        </li>
        <li>
            <a href="{{ route('admin.notificacao.index') }}">
                <i class="fas fa-bell icon"></i>
                Notificações
            </a>
        </li>
</section>