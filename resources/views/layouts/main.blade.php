<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('img/big_brew_logo.png') }}">
    <title>
        Big Brew Store
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />

    <style>
        .colored-toast.swal2-icon-success {
            background-color: #a5dc86 !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
        }

        .colored-toast.swal2-icon-warning {
            background-color: #f8bb86 !important;
        }

        .colored-toast.swal2-icon-info {
            background-color: #3fc3ee !important;
        }

        .colored-toast.swal2-icon-question {
            background-color: #87adbd !important;
        }

        .colored-toast .swal2-title {
            color: white;
        }

        .colored-toast .swal2-close {
            color: white;
        }

        .colored-toast .swal2-html-container {
            color: white;
        }

        /* Apply the class only on mobile view */
        @media (max-width: 768px) {
            .pagination {
                margin-bottom: 100px;
                align-content: center;
            }
        }

        @media (min-width: 768px) {
            .custom-modal {
                margin-left: 30%;
            }

            .imageModal {
                margin-left: 25%;
                margin-right: 5%;
            }
        }
    </style>
</head>

<body class="g-sidenav-show" style="background-color: #EEEEEE">
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Add these CDN links in your HTML head section -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>

    <!--  End Core JS Files   -->


    <div class="min-height-300 position-absolute w-100" style="background-color: #1C1C1C"></div>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="  " target="_blank">
                <img src="{{ asset('img/big_brew_logo.png') }}" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold">Big Brew Store</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">

                @if (Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('dashboard*') ? ' active' : '' }} " href="{{ route('dashboard') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                @endif

                @if (Auth::user()->role == 0 || Auth::user()->role == 2 || Auth::user()->role == 3)
                <li class="nav-item">
                    <a class="nav-link {{Route::is('pos') ? ' active' : '' }} " href="{{route('pos')}}">

                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-cash-register text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">POS</span>
                    </a>
                </li>
                @endif


                @if (Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('inventory') || Route::is('inventoryAddOns') || Route::is('inventoryMaterials') ? ' active' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInv" aria-expanded="false" aria-controls="collapseInv">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-box text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Inventory</span>
                    </a>
                    <div class="collapse mx-5" id="collapseInv">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('inventory') ? ' active' : '' }}" href="{{ route('inventory') }}">
                                    <span class="nav-link-text ms-1">Ingredients</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('inventoryAddOns') ? ' active' : '' }}" href="{{ route('inventoryAddOns') }}">
                                    <span class="nav-link-text ms-1">Add Ons</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('inventoryMaterials') ? ' active' : '' }}" href="{{ route('inventoryMaterials') }}">
                                    <span class="nav-link-text ms-1">Materials</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif


                @if (Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('product*') ? ' active' : '' }} " href="{{ route('product') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-bag-shopping text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Product</span>
                    </a>
                </li>
                @endif


                @if (Auth::user()->role == 3 || Auth::user()->role == 2)
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('account*') ? ' active' : '' }} " href="{{ route('account') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-user me-sm-1 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Accounts</span>
                    </a>
                </li>
                @endif

            </ul>
        </div>
    </aside>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid py-1 px-3 pt-3">

                @yield('breadcrumb')
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item dropdown pe-2 d-flex align-items-center" id="logoutDropdownContainer">
                            <a href="javascript:;" class="nav-link text-white p-0 font-weight-bold"
                                id="dropdownMenuLogout" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                                aria-labelledby="dropdownMenuLogout">
                                <li>
                                    <a class="dropdown-item border-radius-md" href="{{ route('logout') }}">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">

                                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16"
                                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path
                                                        d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z" />
                                                </svg>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p hre class="text-sm font-weight-bold mb-1 text-dark">
                                                    Log Out
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer" style="display: none"></i>
                            </a>
                        </li>
                        {{-- <?php
                                use App\Models\Employee;
                                use Illuminate\Support\Facades\Auth;

                                $notifications = Employee::with(['ticketRequest', 'star'])
                                    ->where('Status_id', 2)
                                    ->where('email', Auth::user()->email)
                                    ->orderBy('EmployeeId', 'desc')
                                    ->get();

                                $notificationsCount = $notifications->filter(function($notif) {
                                    return !$notif->star || !$notif->star->rate;
                                })->count();

                        ?> --}}
                        <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuNotif"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                                {{-- @if($notificationsCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $notificationsCount }}
                                </span>
                                @endif --}}
                            </a>
                            {{-- <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                                        aria-labelledby="dropdownMenuNotif">
                                        <h5>Notification</h5>

                                        @forelse ($notifications as $notif)
                                            @php
                                                $hasRatings = $notif->star && $notif->star->rate;
                                            @endphp

                                            @if (!$hasRatings)
                                                <li class="mb-2">
                                                    <a class="dropdown-item border-radius-md" href="{{ url('Home/Survey/') }}/{{ $notif->EmployeeId }}" target="_blank">
                                                        <div class="d-flex py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h5 class="text-sm font-weight-normal mb-1">
                                                                    Ticket {{ $notif->ticketRequest->ticket_number }} click this link for the survey
                                                                </h5>
                                                                <p class="text-sm text-primary mb-0">
                                                                    Click to survey
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif

                                        @empty
                                        <li class="mb-2">
                                            <span class="dropdown-item">No notifications</span>
                                        </li>
                                        @endforelse
                                </li>
                            </ul> --}}
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        @yield('main')
    </main>
    <!-- Start Setting -->
    <div class="fixed-plugin" style="display: none">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="fa fa-cog py-2"> </i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3 ">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">App Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0 overflow-auto">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between 2 different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white"
                        onclick="sidebarType(this)">White</button>
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default"
                        onclick="sidebarType(this)">Dark</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
                <hr class="horizontal dark my-sm-4">
                <div class="mt-2 mb-5 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Start Setting -->

    <!--   Core JS Files   -->
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }

            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    {{-- <script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script> --}}
    <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
</body>

</html>
