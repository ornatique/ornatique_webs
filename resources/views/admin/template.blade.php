<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Ornatique | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('public/assets/admin/images/ornatique.png') }}">

    <!-- DataTables -->
    <link href="{{ asset('public/assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- Responsive datatable -->
    <!-- <link href="{{ asset('public/assets/admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" /> -->

    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/jquery.multiselect.css') }}" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('public/assets/admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('public/assets/admin/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="{{ asset('public/assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('public/assets/admin/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Dark Mode Css-->
    <link href="{{ asset('public/assets/admin/css/dark-layout.min.css') }}" id="app-style" rel="stylesheet"
        type="text/css" />
    <script src="{{ asset('public/assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <link href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css">


</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    @php
                        $user_role = App\Models\User_access::where('user_id', Auth::id())->first();
                    @endphp
                    <div class="navbar-brand-box">
                        <a href="{{ url('admin/dashboard') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('public/assets/admin/images/logo-sm.png') }}" alt="logo-sm"
                                    height="25">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('public/assets/admin/images/logo-dark.png') }}" alt="logo-dark"
                                    height="40">
                            </span>
                        </a>

                        <a href="{{ url('admin/dashboard') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('public/assets/admin/images/logo-sm-light.png') }}"
                                    alt="logo-sm-light" height="25">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('public/assets/admin/images/002.png') }}" alt="logo-light"
                                    style="height:50px; width:120px;">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 vertinav-toggle header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                    <button type="button"
                        class="btn btn-sm px-3 font-size-16 horinav-toggle header-item waves-effect waves-light"
                        data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                            aria-label="Recipient's username">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (Auth::user()->image)
                                <img class="rounded-circle header-profile-user"
                                    src="{{ asset('public/assets/images/users') . '/' . Auth::user()->image }}">
                            @else
                                <img class="rounded-circle header-profile-user"
                                    src="{{ asset('public/assets/admin/images/users/avatar-1.jpg') }}"
                                    alt="Header Avatar">
                            @endif
                            <span class="d-none d-xl-inline-block ms-1">{{ ucfirst(Auth::User()->name) }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome {{ ucfirst(Auth::user()->name) }}</h6>
                            <!-- <a class="dropdown-item" href="#"><i
                                    class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span
                                    class="align-middle" key="t-profile">Profile</span></a> -->

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                    class="fa fa-sign-out-alt pe-2"></i> <span class="align-middle"
                                    key="t-logout">Logout</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" key="t-menu">Main Menu</li>

                        <!-- Dashboard -->
                        @if ($user_role->dashboard != 0)
                            <li>
                                <a href="{{ url('admin/dashboard') }}" class="waves-effect">
                                    <i class="bx bx-home-circle"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        @endif

                        <!-- User Management -->
                        <li class="menu-title" key="t-menu">User Management</li>
                        @if ($user_role->user_list != 0)
                            <li>
                                <a href="{{ url('admin/user/list') }}" class="waves-effect">
                                    <i class="bx bx-user"></i>
                                    <span>Users</span>
                                </a>
                            </li>
                        @endif

                        @if ($user_role->user_role != 0)
                            <li>
                                <a href="{{ url('admin/user/role') }}" class="waves-effect">
                                    <i class="bx bx-user-check"></i>
                                    <span>User Roles</span>
                                </a>
                            </li>
                        @endif

                        <!-- Customer Management -->
                        <li class="menu-title" key="t-menu">Customer Management</li>
                        @if ($user_role->customers_list != 0)
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-user-circle"></i>
                                    <span>Customers</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="{{ url('admin/custumer/list') }}">
                                            <i class="bx bx-user"></i>
                                            <span>All Customers</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/custumer/new-list') }}">
                                            <i class="bx bx-user-plus"></i>
                                            <span>New Customers</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <!-- Product Management -->
                        <li class="menu-title" key="t-menu">Product Management</li>
                        @if ($user_role->category_list != 0)
                            <li>
                                <a href="{{ url('admin/category/list') }}" class="waves-effect">
                                    <i class="bx bx-grid-alt"></i>
                                    <span>Categories</span>
                                </a>
                            </li>
                        @endif

                        @if ($user_role->subcategory_list != 0)
                            <li>
                                <a href="{{ route('admin_subcategory_list') }}" class="waves-effect">
                                    <i class="bx bx-grid"></i>
                                    <span>Sub Categories</span>
                                </a>
                            </li>
                        @endif

                        @if ($user_role->products_list != 0)
                            <li>
                                <a href="{{ url('admin/product/list') }}" class="waves-effect">
                                    <i class="bx bx-package"></i>
                                    <span>Products</span>
                                </a>
                            </li>
                        @endif

                        <!-- Estimate Management -->
                        <li class="menu-title" key="t-menu">Estimate Management</li>
                        @if ($user_role->order_list != 0)
                            <li>
                                <a href="{{ url('admin/order/list') }}" class="waves-effect">
                                    <i class="bx bx-receipt"></i>
                                    <span>Estimates</span>
                                </a>
                            </li>
                        @endif

                        @if ($user_role->customize_order != 0)
                            <li>
                                <a href="{{ url('admin/custum/list') }}" class="waves-effect">
                                    <i class="bx bx-edit-alt"></i>
                                    <span>Custom Estimates</span>
                                </a>
                            </li>
                        @endif

                        <!-- Marketing & Advertising -->
                        <li class="menu-title" key="t-menu">Marketing</li>
                        @if ($user_role->new_advertisment != 0)
                            <li>
                                <a href="{{ url('admin/banners/list') }}" class="waves-effect">
                                    <i class="bx bx-bullseye"></i>
                                    <span>Popup Ads</span>
                                </a>
                            </li>
                        @endif

                        @if ($user_role->product_advertisment != 0)
                            <li>
                                <a href="{{ url('admin/product/banners') }}" class="waves-effect">
                                    <i class="bx bx-images"></i>
                                    <span>Banner Ads</span>
                                </a>
                            </li>
                        @endif

                        @if ($user_role->social != 0)
                            <li>
                                <a href="{{ url('admin/social/list') }}" class="waves-effect">
                                    <i class="bx bxl-facebook-circle"></i>
                                    <span>Social Media</span>
                                </a>
                            </li>
                        @endif

                        <!-- Content Management -->
                        @if (Auth::user()->admin == 1)
                            <li class="menu-title" key="t-menu">Content Management</li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-photo-album"></i>
                                    <span>Media</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="{{ url('admin/media/list') }}">
                                            <i class="bx bx-photo-album"></i>
                                            <span>Media Library</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/comment/list') }}">
                                            <i class="bx bx-conversation"></i>
                                            <span>Media Comments</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{ url('admin/collection/list') }}" class="waves-effect">
                                    <i class="bx bx-collection"></i>
                                    <span>Top Collections</span>
                                </a>
                            </li>

                            <!-- Settings & Configuration -->
                            <li class="menu-title" key="t-menu">Settings</li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-cog"></i>
                                    <span>Configuration</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="{{ url('admin/essential/list') }}">
                                            <i class="bx bx-cog"></i>
                                            <span>Essentials</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/store/list') }}">
                                            <i class="bx bx-store"></i>
                                            <span>Store Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/heading/list') }}">
                                            <i class="bx bx-text"></i>
                                            <span>Headings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/privacy-policy') }}">
                                            <i class="bx bx-shield-alt"></i>
                                            <span>Privacy Policy</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-layout"></i>
                                    <span>Layouts</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="{{ url('admin/layout-names/list') }}">
                                            <i class="bx bx-layout"></i>
                                            <span>Inside App Layout</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/layouts') }}">
                                            <i class="bx bx-desktop"></i>
                                            <span>App Layouts</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                             @if ($user_role->custom_notification != 0)
                            <li>
                                <a href="{{ url('admin/custom/notificaion') }}" class="waves-effect">
                                    <i class="bx bx-bell"></i>
                                    <span>Custom Notifications</span>
                                </a>
                            </li>
                             @endif
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <!-- Left Sidebar End -->

        <div class="main-content">
            <div class="page-content">
                @yield('main')
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Ornatique.
                        </div>
                        <div class="col-sm-6 d-none">
                            {{-- <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by <a target="_blank" href="https://pxmatrix.com/">PixelMatrix
                                    Solution LLP</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    <!-- JAVASCRIPT -->
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                 order: [[0, 'asc']],
            });
        });
    </script>
    <script src="{{ asset('public/assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/js/jquery.multiselect.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('public/assets/admin/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js">
        < script >

            <
            !--Responsive examples-- >
            <
            !-- < script src =
            "{{ asset('public/assets/admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}" >
    </script>
    <script src="{{ asset('public/assets/admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script> -->

    <!-- Datatable init js -->
    <script src="{{ asset('public/assets/admin/js/pages/datatables.init.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('public/assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    <script src="{{ asset('public/assets/admin/js/pages/dashboard.init.js') }}"></script>
    <!-- form advanced init -->
    <script src="{{ asset('public/assets/admin/js/pages/form-advanced.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('public/assets/admin/js/app.js') }}"></script>

</body>

</html>
