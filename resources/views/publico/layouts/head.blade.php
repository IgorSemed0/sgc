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

    <!-- Custom Admin CSS -->
    <style>
    

        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap');

        * {
            font-family: 'Open Sans', Sans-Serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --grey: #f1f0f6;
            --dark-grey: #8d8d8d;
            --light: #fff;
            --green: #81d4a3;
            --light-green: #e3ffcb;
            --blue: #1775f1;
            --light-blue: #d0e4ff;
            --dark-blue: #0c5fcd;
            --red: #fc3b56;
        }

        html, body {
            overflow-x: hidden;
            max-width: 100%;
            position: relative;
        }

        .container, .container-fluid, .row {
            max-width: 100%;
            padding-right: 0;
            padding-left: 0;
            margin-right: 0;
            margin-left: 0;
        }
        
        
        body {
            background: var(--grey);
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        a {
            text-decoration: none;
        }

        li {
            list-style: none;
        }

        /* NAV */
        nav {
            background: var(--light);
            height: 64px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            grid-gap: 28px;
            position: sticky;
            top: 0;
            left: 0;
            z-index: 100;
        }

        #content .icon {
            min-width: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 8px;
            margin-left: 8px;
        }

        nav .nav-link {
            position: relative;
        }

        nav .nav-link .icon {
            font-size: 18px;
            color: var(--dark);
        }

        nav .nav-link .badge {
            position: absolute;
            top: -12px;
            right: -12px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid var(--light);
            background: var(--red);
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--light);
            font-size: 10px;
            font-weight: 700;
        }

        nav .divider {
            width: 1px;
            background: var(--dark-blue);
            height: 12px;
            display: block;
        }

        nav .profile {
            position: relative;
        }

        nav .profile img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
        }

        nav .profile .profile-link {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: var(--light);
            padding: 10px 0;
            box-shadow: 4px 4px 16px rgba(0, 0, 0, .1);
            border-radius: 10px;
            width: 160px;
            opacity: 0;
            pointer-events: none;
            transition: all .3s ease;
        }

        nav .profile .profile-link.show {
            opacity: 1;
            pointer-events: visible;
            top: 100%;
        }

        nav .profile .profile-link a {
            padding: 10px 16px;
            display: flex;
            grid-gap: 10px;
            font-size: 14px;
            color: var(--dark);
            align-items: center;
            transition: all .3s ease;
        }

        nav .profile .profile-link a:hover {
            background: var(--grey);
        }

        /* MAIN */
        main {
            width: 100%;
            /* padding: 24px 20px; */
            margin: 0;
        }

        main .title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        main .breadcrumbs {
            display: flex;
            grid-gap: 6px;
        }

        main .breadcrumbs li,
        main .breadcrumbs li a {
            font-size: 14px;
        }

        main .breadcrumbs li a {
            color: var(--blue);
        }

        main .breadcrumbs li a.active,
        main .breadcrumbs li .divider {
            color: var(--dark-grey);
            pointer-events: none;
        }

        main .info-data {
            margin-top: 36px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            grid-gap: 20px;
        }

        /* Media Queries */
        /* Media Queries */
            @media (max-width: 768px) {
                body {
                    width: 100%;
                    max-width: 100vw;
                    overflow-x: hidden;
                }
                #content {
                    width: 100%;
                    max-width: 100%;
                    margin: 0;
                    padding: 0;
                }
                main {
                    width: 100%;
                    max-width: 100%;
                    margin: 0;
                    padding: 0;
                }
                nav {
                    width: 100%;
                    max-width: 100%;
                    padding: 0 10px;
                }
                nav form {
                    max-width: 100%;
                }

        main .content-1 {
            display: flex;
            grid-gap: 20px;
            margin-top: 20px;
            margin: 10px;
            flex-wrap: wrap;
        }

        main .content-1 .total {
            max-width: 150px;
            flex-grow: 1;
            flex-basis: 400px;
            padding: 20px;
            background: var(--light);
            border-radius: 10px;
            box-shadow: 4px 4px 16px rgba(0, 0, 0, .1);
        }

        main .content-1 .head {
            font-size: 9px;
        }

        main .data {
            display: flex;
            grid-gap: 20px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        main .data .content-data {
            max-width: 350px;
            flex-grow: 1;
            flex-basis: 400px;
            padding: 20px;
            background: var(--light);
            border-radius: 10px;
            box-shadow: 4px 4px 16px rgba(0, 0, 0, .1);
        }

        main .content-data .head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        main .content-data .head h3 {
            font-size: 20px;
            font-weight: 600;
        }

        main .content-data .head .menu {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        main .content-data .head .menu {
            cursor: pointer;
        }

        main .content-data .head .menu-link {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 140px;
            background: var(--light);
            border-radius: 10px;
            box-shadow: 4px 4px 16px rgba(0, 0, 0, .1);
            padding: 10px 0;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
        }

        main .content-data .head .menu-link a {
            display: block;
            padding: 6px 16px;
            font-size: 14px;
            color: var(--dark);
            transition: all .3s ease;
        }

        main .content-data .head .menu-link.show {
            top: 100%;
            opacity: 1;
            pointer-events: visible;
        }

        main .content-data .head .menu-link a:hover {
            background: var(--grey);
        }

        main .content-data .chart {
            width: 100%;
            max-width: 100%;
            overflow-y: auto;
        }

        main .content-data .chart::-webkit-scrollbar {
            display: none;
        }

        main .chat-box {
            width: 100%;
            max-height: 360px;
            overflow-y: auto;
            scrollbar-width: none;
        }

        main .chat-box::-webkit-scrollbar {
            display: none;
        }card

        main .content-data .card {
            padding: 2
            border-radius: 10px;
            background: var(--light);
            box-shadow: 4px 4px 16px rgba(0, 0, 0, .05);
        }

        main .card .head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        main .card .head h2 {
            font-size: 24px;
            font-weight: 600;
        }

        main .card .head p {
            font-size: 14px;
        }

        main .card .head .icon {
            font-size: 20px;
            color: var(--green);
        }

        main .card .head .icon.down {
            color: var(--red);
        }

        main .card .progress {
            display: block;
            margin-top: 24px;
            height: 10px;
            width: 100%;
            border-radius: 10px;
            background: var(--grey);
            overflow-y: hidden;
            position: relative;
            margin-bottom: 4px;
        }

        main .card .progress::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: var(--blue);
            width: var(--value);
        }

        main .card .label {
            font-size: 14px;
            font-weight: 700;
        }
        
        /* Select2 custom styling */
        .select2-container .select2-selection--single {
            height: 38px !important;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
            
        /* Dropdown menu background */
        .navbar .dropdown-menu {
            background-color: #ffffff; /* White background for dropdown */
            border: 1px solid #dee2e6; /* Light border for contrast */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional shadow for depth */
        }
        
        /* Non-hovered, non-selected nav items */
        .navbar-light .navbar-nav .nav-link {
            color: #333333; /* Dark gray for visibility against bg-light */
        }
        
        /* Hovered nav items */
        .navbar-light .navbar-nav .nav-link:hover {
            color: #007bff; /* Bootstrap primary blue for hover */
            background-color: #e9ecef; /* Light gray background on hover */
        }
        
        /* Active/selected nav items */
        .navbar-light .navbar-nav .nav-link.active {
            color: #0056b3; /* Darker blue for active state */
            font-weight: bold; /* Bold for emphasis */
            background-color: #e9ecef; /* Light gray background for active */
        }
        
        /* Dropdown menu items */
        .navbar .dropdown-menu .dropdown-item {
            color: #333333; /* Dark gray for dropdown items */
        }
        
        .navbar .dropdown-menu .dropdown-item:hover {
            color: #007bff; /* Blue for hovered dropdown items */
            background-color: #f8f9fa; /* Light background for hovered dropdown items */
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-type" content="{{ Auth::user()->vc_tipo }}">
    <script>
        window.REVERB_APP_ID = '{{ config('reverb.apps.0.id') }}';
        window.REVERB_APP_KEY = '{{ config('reverb.apps.0.key') }}';
    </script>
</head>