<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Inventario</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            /* Paleta coherente con el dashboard */
            --login-primary: #4361ee;
            --login-secondary: #3f37c9;
            --login-bg: #f4f7fe;
            --login-gradient: linear-gradient(135deg, var(--login-primary) 0%, var(--login-secondary) 100%);
        }

        body {
            background-color: var(--login-bg);
            /* Fondo con patrón sutil y moderno */
            background-image: radial-gradient(rgba(67, 97, 238, 0.15) 2px, transparent 2px);
            background-size: 30px 30px;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            margin: 0;
            position: relative;
            overflow: hidden;
        }

        /* Formas decorativas (Blobs) */
        .shape-blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
        }
        .shape-1 {
            width: 400px;
            height: 400px;
            background: #4cc9f0;
            top: -100px;
            left: -100px;
            border-radius: 50%;
        }
        .shape-2 {
            width: 500px;
            height: 500px;
            background: var(--login-secondary);
            bottom: -150px;
            right: -100px;
            border-radius: 50%;
        }

        /* Tarjeta principal */
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            position: relative;
            z-index: 10;
        }

        /* Cabecera de la tarjeta */
        .login-header {
            padding: 40px 40px 10px;
            text-align: center;
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: var(--login-gradient);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2.5rem;
            box-shadow: 0 15px 30px rgba(67, 97, 238, 0.3);
            transform: rotate(-5deg);
        }

        .login-header h3 {
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.5px;
        }

        .login-body {
            padding: 20px 40px 40px;
        }

        /* Inputs estilos SaaS */
        .form-label {
            font-weight: 700;
            color: #475569;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .input-group-text {
            background-color: #f8fafc;
            border-right: none;
            color: #94a3b8;
            border-radius: 12px 0 0 12px;
            border-color: #e2e8f0;
        }

        .form-control {
            border-left: none;
            padding: 14px 14px 14px 0;
            border-radius: 0 12px 12px 0;
            background-color: #f8fafc;
            border-color: #e2e8f0;
            color: #1e293b;
            font-weight: 500;
        }

        .form-control::placeholder {
            color: #cbd5e1;
            font-weight: 400;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: var(--login-primary);
            box-shadow: none;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--login-primary);
            color: var(--login-primary);
            background-color: #fff;
        }
        
        .input-group:focus-within .form-control {
            border-color: var(--login-primary);
        }

        /* Botón de Submit */
        .btn-login {
            background: var(--login-gradient);
            border: none;
            color: white;
            padding: 15px;
            width: 100%;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.25);
            margin-top: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(67, 97, 238, 0.4);
            color: white;
        }

        /* Checkbox y Links */
        .form-check-input:checked {
            background-color: var(--login-primary);
            border-color: var(--login-primary);
        }

        .forgot-pass {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--login-primary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-pass:hover {
            color: var(--login-secondary);
            text-decoration: underline;
        }

        /* Caja de credenciales de prueba */
        .credenciales-box {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 15px;
            border: 1px dashed #cbd5e1;
            position: relative;
        }
        .credenciales-box::before {
            content: 'DEMO';
            position: absolute;
            top: -10px;
            right: 15px;
            background: var(--login-secondary);
            color: white;
            font-size: 0.65rem;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <div class="shape-blob shape-1"></div>
    <div class="shape-blob shape-2"></div>

    <div class="login-card">
        <div class="login-header">
            <div class="icon-box">
                <i class="bi bi-box-seam-fill" style="transform: rotate(5deg);"></i>
            </div>
            <h3>Inventario<span class="text-primary">.</span></h3>
            <p class="text-muted mb-0">Ingresa tus credenciales para continuar</p>
        </div>

        <div class="login-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10 text-success rounded-3 small" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 p-3">
                        <ul class="mb-0 ps-3 small fw-medium">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-at"></i></span>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email') }}" required autofocus placeholder="nombre@empresa.com">
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="password" class="form-label mb-0">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-pass">¿Olvidaste tu clave?</a>
                        @endif
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control border-end-0" id="password" name="password" 
                               required placeholder="••••••••">
                        <span class="input-group-text bg-white border-start-0 cursor-pointer" id="togglePassword" style="cursor: pointer;">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input shadow-none" id="remember" name="remember">
                    <label class="form-check-label text-muted small fw-medium" style="user-select: none; cursor: pointer;" for="remember">Mantener sesión iniciada</label>
                </div>

                <button type="submit" class="btn btn-login">
                    Acceder al Sistema <i class="bi bi-arrow-right ms-2"></i>
                </button>

                <div class="text-center mt-5">
                    <div class="credenciales-box text-start">
                        <p class="mb-1 fw-bold text-slate-700 small"><i class="bi bi-shield-lock text-muted me-1"></i> Credenciales de acceso rápido:</p>
                        <div class="d-flex justify-content-between align-items-center bg-white p-2 rounded border mt-2">
                            <code class="text-primary small fw-bold">admin@inventario.com</code>
                            <code class="text-muted small">admin123</code>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Funcionalidad para mostrar/ocultar contraseña
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>