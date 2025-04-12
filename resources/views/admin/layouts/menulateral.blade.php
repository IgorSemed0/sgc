<style>
    .custom-scroll::-webkit-scrollbar {
        width: 2px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background-color: #0066ff;
        border-radius: 4px;
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background-color: #00c8ff;
    }

    /* Styles from HEAD - Kept */
    .sidebar-heading {
        padding: 10px 15px;
        font-size: 0.9em;
        font-weight: bold;
        color: #cccccc; /* Lighter color for headings */
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 15px;
    }
    .sidebar-heading:first-child {
        margin-top: 0;
    }
     .sidebar ul li a {
        padding: 8px 15px; /* Slightly reduced padding */
        font-size: 0.95em; /* Slightly smaller font */
    }
    .sidebar ul i.fas {
        width: 20px; /* Ensure icons align */
        text-align: center;
        margin-right: 8px;
    }
</style>

<aside class="sidebar custom-scroll" style="overflow-y: scroll;">
    <h2 class="hm">SG DIKANZA</h2>
    <nav>
        <ul class="list-unstyled">
            <li>
                <a href="{{ route('admin.home.index') }}" class="link1">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>

            {{-- =================== ADMIN ONLY SECTION =================== --}}
            @if (Auth::user()->vc_tipo == 'admin')
                <div class="sidebar-heading">Gestão de Acessos</div>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="link2">
                        <i class="fas fa-user"></i> Utilizadores
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.notificacao.index') }}" class="link2">
                        <i class="fas fa-bell"></i> Notificações
                    </a>
                </li>

                <div class="sidebar-heading">Estrutura Organizacional</div>
                 <li>
                    <a href="{{ route('admin.ministerio.index') }}" class="link2">
                        <i class="fas fa-building"></i> Ministério
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.proveniencia.index') }}" class="link2">
                        <i class="fas fa-map-signs"></i> Proveniência
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.funcao.index') }}" class="link2">
                        <i class="fas fa-user-tie"></i> Função
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.associado.index') }}" class="link2">
                        <i class="fas fa-users"></i> Pacientes
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.especialidade.index') }}" class="link2">
                        <i class="fas fa-stethoscope"></i> Especialidades Médicas
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.especialidade_funcionario.index') }}" class="link2">
                        <i class="fas fa-user-md"></i> Funcionário/Especialidade
                    </a>
                </li>


                <div class="sidebar-heading">Configurações Gerais</div>
                 <li>
                    <a href="{{ route('admin.endereco.index') }}" class="link2">
                        <i class="fas fa-map-marker-alt"></i> Endereços
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.local.index') }}" class="link2">
                        <i class="fas fa-map-pin"></i> Locais Físicos
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.sector.index') }}" class="link2">
                        <i class="fas fa-vector-square"></i> Sectores
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.subsector.index') }}" class="link2"> {{-- Assuming subsetores is the same as subsector --}}
                        <i class="fas fa-sitemap"></i> Subsectores
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.turno.index') }}" class="link2">
                        <i class="fas fa-clock"></i> Turnos
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.unidade.index') }}" class="link2">
                        <i class="fas fa-ruler-combined"></i> Unidades Medida
                    </a>
                </li>

                <div class="sidebar-heading">Farmácia e Stock</div>
                 <li>
                    <a href="{{ route('admin.fornecedor.index') }}" class="link2">
                        <i class="fas fa-truck"></i> Fornecedores
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.categoria_produto.index') }}" class="link2">
                        <i class="fas fa-layer-group"></i> Categoria de Produtos
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.produto.index') }}" class="link2">
                        <i class="fas fa-box-open"></i> Produtos (Geral)
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.categoria_medicamentos.index') }}" class="link2">
                        <i class="fas fa-pills"></i> Categoria Medicamentos
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.medicamento.index') }}" class="link2">
                        <i class="fas fa-capsules"></i> Medicamentos
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.entrada.index') }}" class="link2">
                        <i class="fas fa-arrow-down"></i> Entradas Stock
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.saida.index') }}" class="link2">
                        <i class="fas fa-arrow-up"></i> Saídas Stock
                    </a>
                </li>
                <li> {{-- Uncommented based on route existence --}}
                    <a href="{{ route('admin.estoque_medicamento.index') }}" class="link2">
                        <i class="fas fa-warehouse"></i> Estoque Medicamentos
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.estoque_produto.index') }}" class="link2">
                        <i class="fas fa-dolly-flatbed"></i> Estoque Produtos
                    </a>
                </li>
                 <li> {{-- Uncommented based on route existence --}}
                    <a href="{{ route('admin.item_venda.index') }}" class="link2">
                        <i class="fas fa-list-ol"></i> Itens de Venda (Log)
                    </a>
                </li>

                <div class="sidebar-heading">Gestão Clínica</div>
                 <li>
                    <a href="{{ route('admin.escala.index') }}" class="link2">
                        <i class="fas fa-calendar-alt"></i> Escalas Trabalho
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.prioridades.index') }}" class="link2"> {{-- Renamed for clarity --}}
                        <i class="fas fa-exclamation-circle"></i> Níveis de Prioridade
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.triagem_prioridades.index') }}" class="link2">
                        <i class="fas fa-route"></i> Prioridade por Triagem
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.consulta_prioridade.index') }}" class="link2">
                        <i class="fas fa-notes-medical"></i> Prioridade por Consulta
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.marcacao_consulta.index') }}" class="link2">
                        <i class="fas fa-calendar-check"></i> Marcação Consultas
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.medico_consulta.index') }}" class="link2">
                        <i class="fas fa-user-md"></i> Médico p/ Consulta
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.consulta.index') }}" class="link2">
                        <i class="fas fa-file-medical-alt"></i> Consultas (Registo)
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.prescricao_entidade.index') }}" class="link2">
                        <i class="fas fa-hospital"></i> Entidades Prescrição
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.triagem.index') }}" class="link2"> {{-- This links to the Admin CRUD --}}
                        <i class="fas fa-heartbeat"></i> Triagens (Registo)
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.enfermeiro_triagem.index') }}" class="link2"> {{-- Maybe rename route/controller later? --}}
                        <i class="fas fa-user-nurse"></i> Enfermeiro/Triagem Assoc.
                    </a>
                </li>

                 <div class="sidebar-heading">Laboratório e Exames</div>
                 <li>
                    <a href="{{ route('admin.categoria_exame.index') }}" class="link2">
                        <i class="fas fa-vials"></i> Categorias de Exames
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.exame_metodo.index') }}" class="link2">
                        <i class="fas fa-flask"></i> Métodos de Exames
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.exame.index') }}" class="link2">
                        <i class="fas fa-microscope"></i> Exames Laboratoriais
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.parametro.index') }}" class="link2">
                        <i class="fas fa-sliders-h"></i> Parâmetros de Exame
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.exame_solicitado.index') }}" class="link2">
                        <i class="fas fa-clipboard-list"></i> Exames Solicitados
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.parametro_resultado.index') }}" class="link2">
                        <i class="fas fa-chart-bar"></i> Resultados de Parâmetros
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.exame_solicitado_resultado.index') }}" class="link2">
                        <i class="fas fa-clipboard-check"></i> Resultados de Exames
                    </a>
                </li>

                 <div class="sidebar-heading">Alocação Recursos</div>
                 <li>
                    <a href="{{ route('admin.alocacao.index') }}" class="link2">
                        <i class="fas fa-people-arrows"></i> Alocações (Geral)
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.alocacao_material.index') }}" class="link2">
                        <i class="fas fa-boxes"></i> Materiais Alocados
                    </a>
                </li>

                {{-- Relatórios section from HEAD - Kept and correctly placed --}}
                <div class="sidebar-heading">Relatórios</div>
                <li>
                    <a href="#" class="link2 dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#pdfSubmenu" aria-expanded="false">
                        <i class="fas fa-file-pdf"></i> Listagens PDF
                    </a>
                    <ul class="collapse list-unstyled" id="pdfSubmenu">
                       <li><a href="{{ route('pdf.funcionario.index') }}" class="link3"><i class="fas fa-angle-right"></i> Funcionários</a></li>
                       <li><a href="{{ route('pdf.fornecedor.index') }}" class="link3"><i class="fas fa-angle-right"></i> Fornecedores</a></li>
                       <li><a href="{{ route('pdf.associado.index') }}" class="link3"><i class="fas fa-angle-right"></i> Associados</a></li>
                       <li><a href="{{ route('pdf.dependente.index') }}" class="link3"><i class="fas fa-angle-right"></i> Dependentes</a></li>
                       <li><a href="{{ route('pdf.medicamento.index') }}" class="link3"><i class="fas fa-angle-right"></i> Medicamentos (Geral)</a></li>
                       <li><a href="{{ route('pdf.medicamento.selecionar_categoria') }}" class="link3"><i class="fas fa-angle-right"></i> Medicamentos (Categoria)</a></li>
                       <li><a href="{{ route('pdf.saida.selecionar') }}" class="link3"><i class="fas fa-angle-right"></i> Saídas Stock</a></li>
                       <li><a href="{{ route('pdf.entrada.selecionar') }}" class="link3"><i class="fas fa-angle-right"></i> Entradas Stock</a></li>
                       <li><a href="{{ route('pdf.estoque.selecionar') }}" class="link3"><i class="fas fa-angle-right"></i> Estado Estoque</a></li>
                       <li><a href="{{ route('pdf.marcacao_consulta') }}" class="link3"><i class="fas fa-angle-right"></i> Marcações Consulta</a></li>
                       <li><a href="{{ route('pdf.consulta') }}" class="link3"><i class="fas fa-angle-right"></i> Consultas Realizadas</a></li>
                       <li><a href="{{ route('pdf.triagem') }}" class="link3"><i class="fas fa-angle-right"></i> Triagens Realizadas</a></li>
                       <li><a href="{{ route('pdf.exame_solicitado') }}" class="link3"><i class="fas fa-angle-right"></i> Exames Solicitados</a></li>
                       <li><a href="{{ route('pdf.medico_consulta') }}" class="link3"><i class="fas fa-angle-right"></i> Médico/Consulta</a></li>
                       <li><a href="{{ route('pdf.triagem_prioridade') }}" class="link3"><i class="fas fa-angle-right"></i> Triagem/Prioridade</a></li>
                       <li><a href="{{ route('pdf.escala') }}" class="link3"><i class="fas fa-angle-right"></i> Escalas (Geral)</a></li>
                       <li><a href="{{ route('pdf.escala.selecionar') }}" class="link3"><i class="fas fa-angle-right"></i> Escalas (Funcionário)</a></li>
                       {{-- Add other PDF links as needed --}}
                    </ul>
                </li>

            @endif
            {{-- ================= END ADMIN ONLY SECTION ================== --}}

            {{-- =================== ANALISTA ONLY SECTION =================== --}}
            @if (Auth::user()->vc_tipo == 'analista')

                {{-- You might want a heading for the section --}}
                <li class="nav-header">ANALISTA</li>

                {{-- Link to the Analyst Dashboard/Index --}}
                <li class="nav-item">
                    <a href="{{ route('subsector.analista.index') }}" class="nav-link {{ request()->routeIs('subsector.analista.index*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i> {{-- Example icon --}}
                        <p>
                            Painel Analista
                            {{-- You could add badges here if needed, e.g., for pending items --}}
                            {{-- <span class="badge badge-info right">6</span> --}}
                        </p>
                    </a>
                </li>

                {{-- Link to the Analyst History --}}
                <li class="nav-item">
                    <a href="{{ route('subsector.analista.history') }}" class="nav-link {{ request()->routeIs('subsector.analista.history*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i> {{-- Example icon --}}
                        <p>
                            Histórico de Análises
                        </p>
                    </a>
                </li>

                {{-- Add more analyst-specific menu items here if needed --}}

            @endif
            {{-- ================= END ANALISTA ONLY SECTION ================= --}}

            {{-- ================= END ADMIN ONLY SECTION ================== --}}
            
            {{-- ============= FARMACEUTICO (+ Admin) SECTION ============== --}}
            @if (Auth::user()->vc_tipo == 'farmaceutico' || Auth::user()->vc_tipo == 'admin')
                <div class="sidebar-heading">Farmácia</div>
                <li>
                    <a href="{{ route('admin.venda.index') }}" class="link2">
                        <i class="fas fa-shopping-cart"></i> Vendas Balcão
                    </a>
                </li>
                 {{-- Add other farmaceutico specific links here if any --}}
                 @if (Auth::user()->vc_tipo == 'farmaceutico') {{-- Show stock links if not admin --}}
                    <li>
                        <a href="{{ route('admin.estoque_medicamento.index') }}" class="link2">
                            <i class="fas fa-warehouse"></i> Estoque Medicamentos
                        </a>
                    </li>
                     <li>
                        <a href="{{ route('admin.entrada.index') }}" class="link2">
                            <i class="fas fa-arrow-down"></i> Entradas Stock
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.saida.index') }}" class="link2">
                            <i class="fas fa-arrow-up"></i> Saídas Stock
                        </a>
                    </li>
                 @endif
            @endif
            {{-- ============= END FARMACEUTICO SECTION =================== --}}


            {{-- ================== MEDICO (+ Admin) SECTION ================= --}}
            @if (Auth::user()->vc_tipo == 'medico' || Auth::user()->vc_tipo == 'admin')
                 <div class="sidebar-heading">Área Médica</div>
                 <li> {{-- Link to Doctor's specific consultation interface --}}
                    <a href="{{ route('subsector.consulta.index') }}" class="link2">
                        <i class="fas fa-user-md"></i> Atender Consultas
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.prescricao.index') }}" class="link2"> {{-- Link to general prescription CRUD --}}
                        <i class="fas fa-file-prescription"></i> Gerir Prescrições
                    </a>
                </li>
                 {{-- Add other medico specific links here if any --}}
            @endif
            {{-- ================== END MEDICO SECTION ==================== --}}

             {{-- =============== RECEPCIONISTA (+ Admin) SECTION ============ --}}
            @if (Auth::user()->vc_tipo == 'recepcionista' || Auth::user()->vc_tipo == 'admin')
                <div class="sidebar-heading">Recepção</div>
                <li> {{-- Link to Receptionist's specific interface --}}
                    <a href="{{ route('subsector.recepcao.index') }}" class="link2">
                        <i class="fas fa-concierge-bell"></i> Atendimento Recepção
                    </a>
                </li>
                 @if (Auth::user()->vc_tipo == 'recepcionista') {{-- Show marking link if not admin --}}
                     <li>
                        <a href="{{ route('admin.marcacao_consulta.index') }}" class="link2">
                            <i class="fas fa-calendar-check"></i> Marcar Consulta
                        </a>
                    </li>
                 @endif
                 {{-- Add other recepcionista specific links here if any --}}
            @endif
            {{-- ============= END RECEPCIONISTA SECTION ================== --}}


            {{-- ================ ENFERMEIRO (+ Admin) SECTION ============== --}}
            {{-- This section was kept from HEAD --}}
            @if (Auth::user()->vc_tipo == 'enfermeiro' || Auth::user()->vc_tipo == 'admin')
                 <div class="sidebar-heading">Enfermagem</div>
                 <li> {{-- Link to Nurse's specific triage interface --}}
                    <a href="{{ route('subsector.triagem.index') }}" class="link2">
                        <i class="fas fa-procedures"></i> Realizar Triagem
                    </a>
                </li>
                 <li> {{-- Link to general triage CRUD (maybe only useful for admin?)--}}
                    <a href="{{ route('admin.triagem.index') }}" class="link2">
                        <i class="fas fa-heartbeat"></i> Gerir Triagens
                    </a>
                </li>
                 {{-- Add other enfermeiro specific links here if any --}}
            @endif
            {{-- ================ END ENFERMEIRO SECTION ================== --}}

            {{-- The conflicting Relatorio section from 41177a2c... was removed here --}}

        </ul>
    </nav>
</aside>
