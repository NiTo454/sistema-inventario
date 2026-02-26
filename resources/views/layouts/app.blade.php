<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistema de Inventario</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <style>
        :root {
            --app-bg: #f4f7fe;
            --app-primary: #4361ee;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--app-bg);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        /* Navbar Estilo Cristal (Glassmorphism) */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 30px rgba(0,0,0,0.03);
            padding: 0.8rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--text-main) !important;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 600;
            color: var(--text-muted) !important;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s;
            margin: 0 0.2rem;
        }

        .nav-link:hover {
            color: var(--app-primary) !important;
            background: rgba(67, 97, 238, 0.05);
        }

        .nav-item.active .nav-link {
            color: var(--app-primary) !important;
            background: rgba(67, 97, 238, 0.1);
        }

        /* Avatar de usuario en el menú */
        .nav-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #4361ee, #3f37c9);
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: bold;
            margin-right: 8px;
        }

        /* Dropdown Customizado */
        .dropdown-menu-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            padding: 0.5rem;
            margin-top: 10px;
        }
        .dropdown-item {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.6rem 1rem;
            color: var(--text-main);
            transition: all 0.2s;
        }
        .dropdown-item:hover {
            background-color: #f8fafc;
        }
        .dropdown-item.text-danger:hover {
            background-color: #fef2f2;
            color: #ef4444 !important;
        }

        /* Alertas Flotantes (Toasts style) */
        .alert-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        .alert-custom .btn-close {
            filter: drop-shadow(0px 0px 0px rgba(0,0,0,0));
        }

        /* Scrollbar estilizado (Opcional pero recomendado) */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                Inventario<span class="text-primary">.</span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-1 text-dark"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-4">
                    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2 me-1"></i> Dashboard</a>
                    </li>
                    
                    @can('admin')
                    <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.index') }}"><i class="bi bi-people me-1"></i> Usuarios</a>
                    </li>
                    @endcan
                    
                    <li class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('products.index') }}"><i class="bi bi-box me-1"></i> Productos</a>
                    </li>
                    
                    <li class="nav-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('sales.index') }}"><i class="bi bi-receipt me-1"></i> Ventas</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto mt-3 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="nav-avatar shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="fw-bold text-dark">{{ explode(' ', Auth::user()->name)[0] }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom" aria-labelledby="navbarDropdown">
                            <li class="px-3 py-2 border-bottom mb-2 bg-light rounded-top">
                                <small class="text-muted d-block" style="font-size: 0.7rem; text-transform: uppercase; font-weight: 700;">Conectado como</small>
                                <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ Auth::user()->email }}</span>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-custom alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill fs-5 me-3"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-custom alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 me-3"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>