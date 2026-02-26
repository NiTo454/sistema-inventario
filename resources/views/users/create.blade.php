@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<style>
    :root {
        --create-primary: #4361ee;
        --create-secondary: #3f37c9;
        --create-bg: #f8fafc;
    }

    .create-container { padding: 1.5rem; background: var(--create-bg); min-height: 100vh; }
    
    /* Breadcrumbs & Title */
    .breadcrumb-item a { color: var(--create-primary); text-decoration: none; font-weight: 500; }
    .page-title { font-weight: 800; color: #1e293b; letter-spacing: -0.5px; }

    /* Form Card */
    .form-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        border: none;
        overflow: hidden;
    }
    
    .form-header-modern {
        background: linear-gradient(135deg, var(--create-primary) 0%, var(--create-secondary) 100%);
        padding: 2.5rem 2rem;
        color: white;
        position: relative;
    }
    
    .form-header-modern::after {
        content: "";
        position: absolute;
        top: -50px;
        right: -20px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    /* Inputs Estilo SaaS */
    .label-custom {
        font-weight: 700;
        color: #475569;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        display: block;
    }

    .input-group-text {
        background-color: #f8fafc;
        border-right: none;
        color: #94a3b8;
        border-radius: 12px 0 0 12px;
        border-color: #e2e8f0;
    }
    
    .form-control, .form-select {
        border-left: none;
        padding: 0.75rem 1rem;
        border-radius: 0 12px 12px 0;
        border-color: #e2e8f0;
        font-weight: 500;
        color: #1e293b;
    }
    
    .form-control::placeholder { color: #cbd5e1; font-weight: 400; }
    
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: var(--create-primary);
        background-color: #ffffff;
    }
    
    .input-group:focus-within .input-group-text {
        border-color: var(--create-primary);
        color: var(--create-primary);
        background-color: #ffffff;
    }

    /* Botones */
    .btn-create {
        background: linear-gradient(135deg, var(--create-primary) 0%, var(--create-secondary) 100%);
        border: none;
        padding: 0.8rem 1.5rem;
        font-weight: 700;
        border-radius: 12px;
        transition: all 0.3s;
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
    }
    
    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
        color: white;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.2s;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
        color: #475569;
    }
</style>

<div class="create-container">
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
                    <li class="breadcrumb-item active">Nuevo Registro</li>
                </ol>
            </nav>
            <h2 class="page-title"><i class="bi bi-person-plus text-primary me-2"></i>Registrar Nuevo Usuario</h2>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="form-card">
                <div class="form-header-modern d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 rounded-4 p-3 me-4 backdrop-blur shadow-sm">
                        <i class="bi bi-person-vcard fs-1 text-white"></i>
                    </div>
                    <div style="z-index: 2;">
                        <h3 class="mb-1 fw-bold text-white">Datos de la Cuenta</h3>
                        <p class="mb-0 text-white-50 small">Completa los campos obligatorios (*) para generar el acceso.</p>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('users.store') }}" id="createUserForm">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="name" class="label-custom">Nombre Completo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required placeholder="Ej: Juan Pérez">
                                </div>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="label-custom">Correo Electrónico <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required placeholder="juan@ejemplo.com">
                                </div>
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="role" class="label-custom">Rol de Usuario <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Seleccionar rol...</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Gerente</option>
                                        <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Empleado</option>
                                    </select>
                                </div>
                                @error('role') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="label-custom">Teléfono (Opcional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone') }}" placeholder="Ej: +52 55 1234 5678">
                                </div>
                                @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 my-2">
                                <hr class="text-muted opacity-25">
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="label-custom">Contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control border-end-0 @error('password') is-invalid @enderror"
                                           id="password" name="password" required placeholder="••••••••">
                                    <button class="btn btn-outline-secondary border-start-0 border-top border-bottom border-end bg-white" type="button" id="togglePassword" style="border-color: #e2e8f0; border-radius: 0 12px 12px 0;">
                                        <i class="bi bi-eye text-muted"></i>
                                    </button>
                                </div>
                                <div class="progress mt-2" style="height: 5px; border-radius: 10px;">
                                    <div id="passwordStrength" class="progress-bar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted mt-1 d-block" id="passwordHelp">Mínimo 8 caracteres</small>
                                @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="label-custom">Confirmar Contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control border-end-0"
                                           id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
                                    <button class="btn btn-outline-secondary border-start-0 border-top border-bottom border-end bg-white" type="button" id="togglePasswordConfirm" style="border-color: #e2e8f0; border-radius: 0 12px 12px 0;">
                                        <i class="bi bi-eye text-muted"></i>
                                    </button>
                                </div>
                                <div id="passwordMatch" class="small mt-1"></div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-3 mt-5 pt-3 border-top">
                            <a href="{{ route('users.index') }}" class="btn btn-cancel px-4">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-create text-white px-5">
                                <i class="bi bi-check-circle me-2"></i> Crear Cuenta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Funcionalidad para mostrar/ocultar contraseña
        function setupToggle(btnId, inputId) {
            document.getElementById(btnId).addEventListener('click', function() {
                const input = document.getElementById(inputId);
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        }
        
        setupToggle('togglePassword', 'password');
        setupToggle('togglePasswordConfirm', 'password_confirmation');

        // Lógica del Medidor de Fuerza de Contraseña
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        
        passwordInput.addEventListener('input', function() {
            const val = this.value;
            const bar = document.getElementById('passwordStrength');
            const help = document.getElementById('passwordHelp');
            let strength = 0;
            
            if(val.length >= 8) strength += 25;
            if(/[A-Z]/.test(val)) strength += 25;
            if(/[0-9]/.test(val)) strength += 25;
            if(/[^A-Za-z0-9]/.test(val)) strength += 25;
            
            bar.style.width = strength + '%';
            
            if(val.length === 0) {
                bar.className = 'progress-bar';
                help.innerText = 'Mínimo 8 caracteres';
                help.className = 'text-muted mt-1 d-block small';
            } else if (strength < 50) { 
                bar.className = 'progress-bar bg-danger'; 
                help.innerText = 'Contraseña débil';
                help.className = 'text-danger mt-1 d-block small fw-bold';
            } else if (strength < 100) { 
                bar.className = 'progress-bar bg-warning'; 
                help.innerText = 'Contraseña moderada';
                help.className = 'text-warning mt-1 d-block small fw-bold';
            } else { 
                bar.className = 'progress-bar bg-success'; 
                help.innerText = 'Contraseña fuerte';
                help.className = 'text-success mt-1 d-block small fw-bold';
            }

            checkMatch(); // Re-chequear coincidencia si cambia la original
        });

        // Lógica de coincidencia de contraseñas
        function checkMatch() {
            const pass = passwordInput.value;
            const confirm = confirmInput.value;
            const matchText = document.getElementById('passwordMatch');

            if (confirm.length > 0) {
                if (pass === confirm) {
                    confirmInput.style.borderColor = '#10b981'; // Success green
                    matchText.innerHTML = '<span class="text-success"><i class="bi bi-check-circle-fill me-1"></i> Las contraseñas coinciden</span>';
                } else {
                    confirmInput.style.borderColor = '#ef4444'; // Danger red
                    matchText.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle-fill me-1"></i> Las contraseñas no coinciden</span>';
                }
            } else {
                confirmInput.style.borderColor = '#e2e8f0'; // Default
                matchText.innerHTML = '';
            }
        }

        confirmInput.addEventListener('input', checkMatch);
        
        // Prevenir submit si no coinciden (Opcional, Laravel lo valida en backend, pero es buena UX)
        document.getElementById('createUserForm').addEventListener('submit', function(e) {
            if (passwordInput.value !== confirmInput.value) {
                e.preventDefault();
                alert('Por favor asegúrate de que las contraseñas coincidan antes de continuar.');
                confirmInput.focus();
            }
        });
    });
</script>
@endpush