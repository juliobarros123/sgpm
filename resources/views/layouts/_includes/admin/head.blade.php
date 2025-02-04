<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Paper Dashboard by Creative Tim</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- Animation library for notifications -->
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" />

    <!-- Paper Dashboard core CSS -->
    <link href="{{ asset('assets/css/paper-dashboard.css') }}" rel="stylesheet" />

    <!-- CSS for Demo Purpose, don't include it in your project -->
    <link href="{{ asset('assets/css/demo.css') }}" rel="stylesheet" />

    <!-- Fonts and icons -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> --}}
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,300" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/themify-icons.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.css') }}">
    @livewireStyles

    <style>
        .modal-backdrop.in {
            opacity: 0;
        }

        .table-full-width {
            margin-left: 3px;
            margin-right: 3px;
        }

        /* CSS para o botão grupo */
        .btn-group {
            display: flex;
            gap: 5px;
            /* Ajuste o espaçamento entre os botões conforme necessário */
        }

        /* Ajuste a largura mínima da célula da tabela, se necessário */
        table td {
            vertical-align: middle;
        }

        /* Garantir que os botões não excedam a largura da célula */
        .btn {
            white-space: nowrap;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table td,
        .table th {
            padding: 8px;
            text-align: left;
            /* border: 1px solid #ddd; */
        }

        @media (max-width: 768px) {

            .table,
            .table thead,
            .table tbody,
            .table th,
            .table td,
            .table tr {
                display: block;
            }

            .table thead {
                display: none;
            }

            .table tr {
                margin-bottom: 10px;
                border-bottom: 1px solid #ddd;
            }

            .table td {
                position: relative;
                padding-left: 50%;
                text-align: right;
                white-space: nowrap;
                border-bottom: 1px solid #ddd;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 10px;
                font-weight: bold;
                text-align: left;
            }
        }
    </style>
</head>
