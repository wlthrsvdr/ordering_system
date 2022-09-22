<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PLSP University Cafeteria Ordering System </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/v4-shims.min.css">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">

    <link rel="stylesheet" href={{ asset('assets/css/bootstrap-datepicker.min.css') }}>

    <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.css">

    <link rel="stylesheet" href="/assets/css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <style type="text/css">
        .input-daterange input {
            background: #fff !important;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>



            <ul class="navbar-nav ml-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-power-off"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header"></span>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item">
                            <form action="{{ route('admin.logout') }}">
                                <button type="submit" class="btn btn-danger btn-sm btn-lg" style="width:100%"><i
                                        class="fa fa-power-off"></i> Logout</button>
                            </form>
                        </a>

                        <div class="dropdown-divider"></div>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="index3.html" class="brand-link">
                <span class="brand-text font-weight-light">
                    <h5 align="center"><strong>PLSP University Cafeteria <br> Ordering System</strong></h5>
                </span>
            </a>


            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src={{ asset('assets/imgs/logo.png') }} class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Administrator</a>
                    </div>
                </div>


                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item has-treeview">
                            <a href="{{ route('admin.dashboard') }}"
                                class="{{ request()->is('admin') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="{{ route('admin.products.index') }}"
                                class="{{ request()->is('admin/topup') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fa fa-cutlery"></i>
                                <p>
                                    Products
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="{{ route('admin.categories.index') }}"
                                class="{{ request()->is('admin/topup') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fa fa-tag"></i>
                                <p>
                                    Categories
                                </p>
                            </a>
                        </li>

                        {{-- <li class="nav-item has-treeview">
                            <a href="{{ route('admin.order.index') }}"
                                class="{{ request()->is('admin/order') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fa fa-shopping-cart"></i>
                                <p>
                                    Orders
                                </p>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-money"></i>
                                <p>
                                    Wallet Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.wallet.topup') }}"
                                        class="{{ request()->is('admin/topup') ? 'nav-link active' : 'nav-link' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Add Wallet
                                        </p>
                                    </a>
                                </li>
                            </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.wallet.index') }}"
                                        class="{{ request()->is('admin/topup') ? 'nav-link active' : 'nav-link' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Card Registration
                                        </p>
                                    </a>
                                </li>
                            </ul> --}}
                        {{-- </li> --}}

                        {{-- <li class="nav-item has-treeview">
                            <a href="{{ route('admin.wallet.create') }}"
                                class="{{ request()->is('admin/topup') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fa fa-money"></i>
                                <p>
                                    Top Up
                                </p>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item has-treeview">
                            <a href="{{ route('admin.report.index') }}"
                                class="{{ request()->is('admin/report') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fa fa-file-excel-o"></i>
                                <p>
                                    Report
                                </p>
                            </a>
                        </li> --}}
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    User Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.admin.index') }}"
                                        class="{{ request()->is('admin/users') ? 'nav-link active' : 'nav-link' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Admin</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.customer.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Customer</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="nav-item has-treeview">
                            <a href="{{ route('admin.users') }}"
                                class="{{ request()->is('admin/users') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    User Management
                                </p>
                            </a>
                        </li> --}}
                    </ul>
                </nav>

            </div>

        </aside>


        <div class="content-wrapper">

            <section class="content">
                <div class="container-fluid">

                    @yield('content')


                </div>
            </section>

        </div>

        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline-block">

            </div>
        </footer>


        <aside class="control-sidebar control-sidebar-dark">

        </aside>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/jquery/jquery.min.js"></script>

    <script type="text/javascript" src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>


    {{-- <script type="text/javascript" src="/assets/js/{{ $js }}"></script> --}}
    {{-- <script type="text/javascript" src="/assets/js/UserManagement.js"></script> --}}
    {{-- <script type="text/javascript" src="/assets/js/Product.js"></script> --}}

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>

    {{-- <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script> --}}

    <script type="text/javascript">
        $(function() {
            $('.input-daterange').datepicker({
                format: "yyyy-mm-dd"
            });

        })
    </script>

    <script type="text/javascript" src={{ asset('assets/js/bootstrap-datepicker.min.js') }}></script>

    <script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="/assets/plugins/sparklines/sparkline.js"></script>

    <script type="text/javascript" src="/assets/plugins/jquery-knob/jquery.knob.min.js"></script>

    <script type="text/javascript" src="/assets/plugins/moment/moment.min.js"></script>

    <script type="text/javascript" src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
    </script>

    <script type="text/javascript" src="/assets/plugins/summernote/summernote-bs4.min.js"></script>

    <script type="text/javascript" src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script type="text/javascript" src="/assets/dist/js/adminlte.js"></script>

    <script type="text/javascript" src="/assets/dist/js/pages/dashboard.js"></script>

    <script type="text/javascript" src="/assets/js/{{ $js }}.js"></script>
    {{-- <script type="text/javascript" src="/assets/js/Topup.js"></script>

    <script type="text/javascript" src="/assets/js/Order.js"></script> --}}

    <script type="text/javascript" src="/assets/dist/js/demo.js"></script>


</body>

</html>
