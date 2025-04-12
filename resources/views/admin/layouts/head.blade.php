<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Meu Site')</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('style/style.css') }}">
    <link rel="stylesheet" href="{{ asset('style/cdn/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- JS -->
    <script src="{{ asset('style/cdn/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('style/cdn/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('style/cdn/chart.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

    <!-- Importação do jQuery e Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
            /* Ajuste para a altura dos outros inputs */
            padding: 6px 12px;
            /* Mantém o espaçamento interno */
            border: 1px solid #ced4da;
            /* Mantém o mesmo estilo de borda */
            border-radius: 5px;
            /* Ajusta para um estilo mais arredondado */
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-type" content="{{ Auth::user()->vc_tipo }}">
    <script>
        window.REVERB_APP_ID = '{{ config('reverb.apps.0.id') }}';
        window.REVERB_APP_KEY = '{{ config('reverb.apps.0.key') }}';
    </script>
</head>
