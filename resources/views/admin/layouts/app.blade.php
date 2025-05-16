<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.layouts.head')
</head>
<body class="bg-light">
    <div class="container-fluid">
        @yield('content')
    </div>
    
    <!-- Footer -->
    <footer class="text-center py-4 mt-5 text-muted">
        <div class="container">
            <p>&copy; {{ date('Y') }} GesCondo - Sistema de Gestão de Condomínio. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Scripts personalizados -->
    <script>
        $(document).ready(function() {
            // Inicializa Select2 para selects
            $('.form-select').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        });
    </script>
</body>
</html>