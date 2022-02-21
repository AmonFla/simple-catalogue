<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <title>Panel</title>

    <link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="{{route('admin')}}">
                    <span class="align-middle">GOC</span>
                </a>

                <ul class="sidebar-nav">

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{route('admin')}}">
                            <i class="align-middle" data-feather="sliders"></i> <span
                                class="align-middle">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-header">
                        Sites
					</li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin-pages.index')}}">
                            <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Páginas</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin-products.index')}}">
                            <i class="align-middle" data-feather="cpu"></i> <span class="align-middle">Productos</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin-categories.index')}}">
                            <i class="align-middle" data-feather="list"></i> <span class="align-middle">Categorías</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin-associates.index')}}">
                            <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Representaciones</span>
                        </a>
                    </li>
                    <li class="sidebar-header">
                        Configuraciones
					</li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin-user-list')}}">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Usuarios</span>
                        </a>
                    </li>


                </ul>


            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle d-flex">
                    <i class="hamburger align-self-center"></i>
                </a>



                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">


                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                            <img src="{{asset('admin/img/avatars/undraw_profile.svg') }}" class="avatar img-fluid rounded mr-1"
                                alt="Charles Hall" /> <span class="text-dark">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                        </li>
                    </ul>
                </div>
            </nav>

            @yield('content')

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-left">
                            <p class="mb-0">
                                <a href="{{route('admin')}}" class="text-muted"><strong>AdminKit Demo</strong></a> &copy;
                            </p>
                        </div>
                        <div class="col-6 text-right">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Terms</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('admin/js/app.js') }}"></script>


</body>

</html>
