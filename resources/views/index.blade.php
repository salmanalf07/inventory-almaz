<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PT. ALMAS DAYA SINERGI</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="assets/css/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/css/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="assets/css/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="assets/css/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="assets/css/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="assets/css/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="assets/css/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="assets/css/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="assets/css/daterangepicker/daterangepicker.css">
    <!-- tracking -->
    <link rel="stylesheet" href="assets/css/tracking.css">
    <style>
        #pageloader {
            background: rgba(255, 255, 255, 0.8);
            display: none;
            height: 100%;
            /* top: 0; */
            position: fixed;
            width: 100%;
            z-index: 9999;
        }

        #pageloader img {
            left: 50%;
            margin-left: -32px;
            margin-top: -32px;
            position: absolute;
            top: 50%;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed" onload="countdowntimes()">
    <div id="pageloader">
        <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />
    </div>
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake brand-image img-circle elevation-3" src="img/almaz.png" width="80">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <div class="nav-item">
                    <p class="nav-link" id="preview"></p>
                </div>
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user"></i>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <div class="nav-item">
                            <a href="user_edit" class="nav-link">
                                <i class="fas fa-pen mr-2"></i> Profile
                            </a>
                        </div>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <div class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                        this.closest('form').submit(); " role="button">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Log Out
                                </a>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="dashboard" class="brand-link">
                <img src="img/almaz.png" class="brand-image img-circle elevation-3" style="margin-left:0;margin-top:-9px;max-height: 48px;">
                <span class="brand-text font-weight-light" style="font-size: 12pt;">PT. ALMAS DAYA SINERGI</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel pb-3 mb-3 d-flex">
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item {{ request()->is('dashboard', 'r_partin','r_partoutt', 'r_partout','r_sumpart', 'r_order', 'r_invoice', 'rekap_inv','r_production','r_invsout','r_sumpo') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard & Report
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Business Highlight</p>
                                    </a>
                                </li>
                                <?php

                                $str = Auth::user()->phone;
                                $data = explode(",", $str);
                                ?>
                                @if($str)
                                <li class="nav-item {{ request()->is('r_partin','r_partoutt', 'r_partout','r_sumpart', 'r_order', 'r_invoice', 'rekap_inv','r_production','r_invsout','r_sumpo') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Report
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    @foreach($data as $dataa)
                                    @if($dataa == "r_partin" || $dataa == "ALL")
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="r_partin" class="nav-link {{ request()->is('r_partin') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Part In</p>
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                    @if($dataa == "r_partoutt" || $dataa == "ALL")
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="r_partoutt" class="nav-link {{ request()->is('r_partoutt') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Part Out</p>
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                    @if($dataa == "r_invsout" || $dataa == "ALL")
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="r_invsout" class="nav-link {{ request()->is('r_invsout') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>In VS Out</p>
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                    @if($dataa == "r_partout" || $dataa == "ALL")
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="r_partout" class="nav-link {{ request()->is('r_partout') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Summary By Cust</p>
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                    @if($dataa == "r_sumpart" || $dataa == "ALL")
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="r_sumpart" class="nav-link {{ request()->is('r_sumpart') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Summary By Part</p>
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                    @if($dataa == "r_sumpo" || $dataa == "ALL")
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="r_sumpo" class="nav-link {{ request()->is('r_sumpo') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Summary By PO</p>
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                    @if($dataa == "r_order" || $dataa == "ALL")
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="r_order" class="nav-link {{ request()->is('r_order') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Order</p>
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                    @if($dataa == "r_invoice" || $dataa == "ALL")
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="r_invoice" class="nav-link {{ request()->is('r_invoice') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Invoice</p>
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                    @if ($dataa == "r_production" || $dataa == "ALL")
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="r_production" class="nav-link {{ request()->is('r_production') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Production</p>
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                    @if($dataa == "rekap_inv" || $dataa == "ALL")
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="rekap_inv" class="nav-link {{ request()->is('rekap_inv') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Rekap Invoice</p>
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                    @endforeach
                                    @endif
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ request()->is('orders', 'invoices') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="fas fa-cart-arrow-down nav-icon"></i>
                                <p>
                                    Sales
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="orders" class="nav-link {{ request()->is('orders') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Order</p>
                                    </a>
                                </li>
                                @if(Auth::user()->role != "ADMIN")
                                <li class="nav-item">
                                    <a href="invoices" class="nav-link {{ request()->is('invoices') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Invoice</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item {{ request()->is('partin', 'sj', 'stock','process','packing','stockfg') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cubes"></i>
                                <p>
                                    Transactions
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="partin" class="nav-link {{ request()->is('partin') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Part In</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->is('stock','process','packing','stockfg') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Production
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="stock" class="nav-link  {{ request()->is('stock') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Early Stock</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="process" class="nav-link {{ request()->is('process') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Process</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="packing" class="nav-link {{ request()->is('packing') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Packing</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="stockfg" class="nav-link {{ request()->is('stockfg') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Stock FG</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="sj" class="nav-link {{ request()->is('sj') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Part Out</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ request()->is('customer', 'parts','hisparts') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Master data
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="customer" class="nav-link {{ request()->is('customer') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Customer</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->is('parts','hisparts') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Part
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="parts" class="nav-link  {{ request()->is('parts') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Master</p>
                                            </a>
                                        </li>
                                        @if(Auth::user()->role != "ADMIN")
                                        <li class="nav-item">
                                            <a href="hisparts" class="nav-link {{ request()->is('hisparts') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>History</p>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        @if(Auth::user()->role != "ADMIN")
                        <li class="nav-item {{ request()->is('user', 'car', 'driver','application') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Manajemen Sistem
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="user" class="nav-link {{ request()->is('user') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="car" class="nav-link {{ request()->is('car') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Car</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="driver" class="nav-link {{ request()->is('driver') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Driver</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="application" class="nav-link {{ request()->is('application') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Application</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <!-- <div class="content-wrapper"> -->
        @yield('konten')
        <!-- </div> -->
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 PT. ALMAS DAYA SINERGI</strong>
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="assets/css/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="assets/css/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="assets/css/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="assets/css/select2/js/select2.full.min.js"></script>
    <!-- ChartJS -->
    <script src="assets/css/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="assets/css/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="assets/css/jqvmap/jquery.vmap.min.js"></script>
    <script src="assets/css/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="assets/css/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="assets/css/moment/moment.min.js"></script>
    <script src="assets/css/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="assets/css/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="assets/css/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="assets/css/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="assets/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="assets/js/dashboard.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="assets/css/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/css/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/css/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/css/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="assets/css/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/css/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/css/jszip/jszip.min.js"></script>
    <script src="assets/css/pdfmake/pdfmake.min.js"></script>
    <script src="assets/css/pdfmake/vfs_fonts.js"></script>
    <script src="assets/css/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/css/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="assets/css/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="assets/css/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- date-range-picker -->
    <script src="assets/css/daterangepicker/daterangepicker.js"></script>
    <!-- Clock -->
    <script src="assets/js/clock.js"></script>
    <script src="assets/js/autoNumeric.min.js"></script>

    <script>
        $(function() {
            bsCustomFileInput.init();
            $('#part-in').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
            $('#prod-day').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>