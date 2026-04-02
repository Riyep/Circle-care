<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/Logo.png') }}">
    <title>Circle Care</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">


</head>
<header
    style="
        height: 69px; 
        width: 100%; 
        position: fixed; 
        top: 0; 
        left: 0; 
        z-index: 1030; 
        color: white; 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        padding: 0 20px; 
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        background: linear-gradient(
            to right,
            #09213b,
            #044C86,
            #067DC1,
            #0CBDEC,
            #FDFDFD
        );
        overflow: hidden;
    ">

    <!-- Overlay diagonal kanan -->
    <div
        style="
        position: absolute;
        right: 0;
        top: 0;
        width: 200px;
        height: 100%;
        background: repeating-linear-gradient(
            135deg,
            rgba(128,128,128,0.15),
            rgba(128,128,128,0.15) 2px,
            transparent 2px,
            transparent 8px
        );
        pointer-events: none;
    ">
    </div>

    <h1 class="text-center font-weight-bold" style="margin: 0; position: relative; z-index: 1;"></h1>

    <div class="user-info" style="display: flex; align-items: center; position: relative; z-index: 1;">
        <span class="mr-2 text-dark bold">{{ auth()->user()->mt_username }}</span>
        <img class="img-profile rounded-circle" src="{{ asset('sb-admin/img/undraw_profile.svg') }}"
            alt="Profile Picture" style="width: 40px; height: 40px; object-fit: cover;">
    </div>

</header>

<body id="page-top">
    <style>
        #simpleSidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            overflow-y: auto;
            z-index: 1030;
            background: #0B2C4F;
        }

        #simpleSidebar::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;

            background: linear-gradient(135deg,
                    #0B2C4F,
                    #123e6b,
                    #0B2C4F);

            background-size: 200% 200%;
            animation: gradientMove 8s ease infinite;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .sidebar .nav-item .nav-link span {
            font-size: 1.15rem;
            font-weight: bold;
            color: #fff;
        }

        .sidebar .nav-item .nav-link {
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .sidebar .nav-item .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            padding-left: 18px;
        }

        .sidebar .nav-item .nav-link:active {
            transform: scale(0.96);
        }

        #content-wrapper {
            margin-left: 250px;
        }
    </style>


    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark" id="simpleSidebar">

            <div class="sidebar-brand-text mx-3">
                <img src="{{ asset('/assets/images/Logo App.png') }}" />
            </div>

            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('mt_issues') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/mt_issues') }}">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>MyThread</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('mt_issues/tag') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/mt_issues/tag') }}">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Tagged</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('mt_issues/create') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/mt_issues/create') }}">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Open Thread</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('panduan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/panduan') }}">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Panduan</span>
                </a>
            </li>

            <li
                class="nav-item 
                {{ request()->is('users') || request()->is('users/' . Auth::user()->id . '/edit') ? 'active' : '' }}">
                @if (optional(Auth::user()->role)->mt_roles_name === 'Admin')
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fas fa-fw fa-cogs"></i>
                        <span>Pengaturan Akun</span>
                    </a>
                @else
                    <a class="nav-link" href="{{ route('users.edit', Auth::user()->id) }}">
                        <i class="fas fa-fw fa-cogs"></i>
                        <span>Pengaturan Akun</span>
                    </a>
                @endif
            </li>

            @if (optional(Auth::user()->role)->mt_roles_name === 'Admin' || optional(Auth::user()->role)->mt_roles_name === 'Mod')
                <li class="nav-item {{ request()->is('pelaporan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pelaporan.index') }}">
                        <i class="fas fa-fw fa-file-download"></i>
                        <span>Pelaporan</span>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="nav-link btn btn-link text-decoration-none" type="submit">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

        </ul>

        <!-- End of Sidebar -->


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>


                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>
            </div>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>
                    <a href="https://www.instagram.com/ri.yep/">Rio Marcellino</a>
                </span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sb-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sb-admin/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('sb-admin/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('sb-admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('sb-admin/js/demo/chart-pie-demo.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script src="{{ asset('js/taggedUsers.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('tagged_users_input');
            const list = document.getElementById('tagged_users_list');
            const hiddenInput = document.getElementById('tagged_users_hidden');

            input.addEventListener('input', function() {
                const query = input.value;

                if (query.length >= 2) {
                    fetch(`/search?q=${query}`)
                        .then(response => response.json())
                        .then(users => {
                            list.innerHTML = '';

                            users.forEach(user => {
                                const listItem = document.createElement('button');
                                listItem.className = 'list-group-item list-group-item-action';
                                listItem.textContent = user.mt_username;
                                listItem.dataset.id = user.id;

                                listItem.addEventListener('click', function() {
                                    const existing = hiddenInput.value.split(',')
                                        .filter(Boolean);
                                    if (!existing.includes(user.id.toString())) {
                                        hiddenInput.value = [...existing, user.id].join(
                                            ',');
                                    }

                                    input.value = '';
                                    list.innerHTML = '';
                                });

                                list.appendChild(listItem);
                            });
                        });
                } else {
                    list.innerHTML = ''; // Kosongkan daftar jika input terlalu pendek
                }
            });
        });
    </script>


</body>

</html>
