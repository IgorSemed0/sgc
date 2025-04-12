<!DOCTYPE html>
<html lang="pt">

<!-- Head -->
@include('admin.layouts.head')

<body>
    <!-- Menu Superior -->
    @include('admin.layouts.menusuperior')

    <!-- Menu Lateral -->
    @include('admin.layouts.menulateral')

    <!-- Conteúdo Principal -->
    <main class="main-content">
        @yield('conteudo')
        <footer>
            <p>&copy; 2025 CDCI. Todos os direitos reservados.</p>
        </footer>
    </main>


    <script src="{{ asset('style/exibir.js') }}"></script>
    <script src="{{ asset('style/pesquisar.js') }}"></script>

    <!-- Importação do jQuery e Select2 -->

    <script>
        $(document).ready(function() {
            // Função para inicializar o Select2 dentro de uma modal específica
            function initSelect2(modal) {
                $(modal).find('.select2').select2({
                    dropdownParent: $(modal),
                    placeholder: "Selecione uma opção",
                    allowClear: true,
                    width: '100%'
                });
            }

            // Quando qualquer modal for aberta, inicializa o Select2 dentro dela
            $('.modal').on('shown.bs.modal', function() {
                initSelect2(this);
            });

            let table = new DataTable('.myTable', {
                paging: true, // Paginação
                searching: true, // Barra de pesquisa
                info: true, // Informação do total de registros
                responsive: true, // Responsivo para mobile
                lengthMenu: [5, 10, 25, 50], // Quantidade de registros por página
                language: {
                    search: "Buscar:", // Personalizar rótulos
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                }
            });

        });
    </script>


</body>

</html>
