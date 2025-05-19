<!DOCTYPE html>
<html lang="pt">

<!-- Head -->
@include('admin.layouts.head')

<body>
    <!-- Menu Lateral -->
    @include('admin.layouts.menulateral')
    
    <!-- Content Section -->
    <section id="content">
        <!-- Menu Superior -->
        @include('admin.layouts.menusuperior')
        
        <!-- Conteúdo Principal -->
        <main>
            @yield('conteudo')
            <footer>
                <p>&copy; 2025 GesCondo. Todos os direitos reservados.</p>
            </footer>
        </main>
    </section>

    <script>
        // SIDEBAR DROPDOWN
        const allDropdown = document.querySelectorAll('#sidebar .side-dropdown');
        const sidebar = document.getElementById('sidebar');

        allDropdown.forEach(item => {
            const a = item.parentElement.querySelector('a:first-child');
            a.addEventListener('click', function(e) {
                e.preventDefault();
                if (!this.classList.contains('active')) {
                    allDropdown.forEach(i => {
                        const aLink = i.parentElement.querySelector('a:first-child');
                        aLink.classList.remove('active');
                        i.classList.remove('show');
                    })
                }
                this.classList.toggle('active');
                item.classList.toggle('show');
            })
        });

        // SIDEBAR COLLAPSE
        const toggleSidebar = document.querySelector('nav .toggle-sidebar');
        const allSideDivider = document.querySelectorAll('#sidebar .divider');

        if (sidebar.classList.contains('hide')) {
            allSideDivider.forEach(item => {
                item.textContent = '_'
            })
        } else {
            allSideDivider.forEach(item => {
                item.textContent = item.dataset.text;
            })
        }

        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('hide');

            if (sidebar.classList.contains('hide')) {
                allSideDivider.forEach(item => {
                    item.textContent = '_'
                })
            } else {
                allSideDivider.forEach(item => {
                    item.textContent = item.dataset.text;
                })
            }
        });

        sidebar.addEventListener('mouseleave', function() {
            if (this.classList.contains('hide')) {
                allDropdown.forEach(item => {
                    const a = item.parentElement.querySelector('a:first-child');
                    a.classList.remove('active');
                    item.classList.remove('show');
                })
                allSideDivider.forEach(item => {
                    item.textContent = '_'
                })
            }
        });

        sidebar.addEventListener('mouseenter', function() {
            if (this.classList.contains('hide')) {
                allDropdown.forEach(item => {
                    const a = item.parentElement.querySelector('a:first-child');
                    a.classList.remove('active');
                    item.classList.remove('show');
                })
                allSideDivider.forEach(item => {
                    item.textContent = item.dataset.text;
                })
            }
        });

        // PROFILE DROPDOWN
        const profile = document.querySelector('nav .profile');
        const imgProfile = profile.querySelector('img');
        const dropdownProfile = profile.querySelector('.profile-link');

        imgProfile.addEventListener('click', function() {
            dropdownProfile.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target !== imgProfile) {
                if (e.target !== dropdownProfile) {
                    if (dropdownProfile.classList.contains('show')) {
                        dropdownProfile.classList.remove('show');
                    }
                }
            }
        });

        // Initialize Select2
        $(document).ready(function() {
            // Function to initialize Select2 in specific modal
            function initSelect2(modal) {
                $(modal).find('.select2').select2({
                    dropdownParent: $(modal),
                    placeholder: "Selecione uma opção",
                    allowClear: true,
                    width: '100%'
                });
            }

            // When any modal is opened, initialize Select2 inside it
            $('.modal').on('shown.bs.modal', function() {
                initSelect2(this);
            });

            let table = new DataTable('.myTable', {
                paging: true,
                searching: true,
                info: true,
                responsive: true,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                }
            });
        });
    </script>

    <script src="{{ asset('style/exibir.js') }}"></script>
    <script src="{{ asset('style/pesquisar.js') }}"></script>
</body>

</html>