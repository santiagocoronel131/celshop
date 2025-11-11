<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Celshop') }}</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="{{ asset('css/form-styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/product-styles.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <div id="app" class="flex-grow-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand font-weight-bold" href="{{ route('home') }}">
                    {{ config('app.name', 'Celshop') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Todos los Productos</a>
                        </li>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('products.category', $category->id) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <!-- Buscador en el centro -->
                    <form class="form-inline mx-auto my-2 my-lg-0" action="{{ route('products.search') }}" method="GET">
                        <input class="form-control mr-sm-2" type="search" placeholder="Buscar productos..." aria-label="Buscar" name="query">
                        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Buscar</button>
                    </form>

                    <!-- Links de la Derecha -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                Carrito
                                @if(session('cart') && count(session('cart')) > 0)
                                    <span class="badge badge-pill badge-danger">{{ count(session('cart')) }}</span>
                                @endif
                            </a>
                        </li>

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(Auth::user()->role == 'admin')
                                        <i class="fas fa-user-shield text-warning"></i>
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <div class="px-3 py-2 text-center">
                                        <small class="text-muted">{{ Auth::user()->email }}</small><br>
                                        <strong class="text-capitalize text-primary">{{ Auth::user()->role }}</strong>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="fas fa-id-card mr-2"></i>Mi Perfil</a>
                                    <a class="dropdown-item" href="{{ route('profile.orders') }}"><i class="fas fa-box-open mr-2"></i>Mis Órdenes</a>
                                    @if(Auth::user()->role == 'admin')
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt mr-2"></i>Panel de Admin</a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Salir
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                @endif
                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ session('info') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                @endif
            </div>
            @yield('content')
        </main>
    </div>

    <!-- El footer ahora se pega al final de la página -->
    <footer class="bg-dark text-light pt-5 pb-4">
        <!-- ... (tu código del footer aquí, está perfecto) ... -->
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @stack('scripts')
</body>
</html>