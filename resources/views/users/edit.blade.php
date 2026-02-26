@extends('layouts.app')
@section('title', 'Editar Usuario')

@section('content')
<style>
    :root {
        --edit-primary: #4361ee;
        --edit-warning: #f59e0b;
        --edit-danger: #ef4444;
        --edit-bg: #f8fafc;
    }

    .edit-container { padding: 2rem; background: var(--edit-bg); min-height: 100vh; }
    
    /* Breadcrumbs & Title */
    .breadcrumb-item a { color: var(--edit-primary); text-decoration: none; font-weight: 500; }
    .page-title { font-weight: 800; color: #1e293b; letter-spacing: -1px; }

    /* Cards */
    .card-custom {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        background: white;
        margin-bottom: 2rem;
        overflow: hidden;
    }
    .card-header-custom {
        padding: 1.5rem;
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .header-icon {
        width: 40px;
        height: 40px;
        background: rgba(67, 97, 238, 0.1);
        color: var(--edit-primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Inputs Modernos */
    .input-group-text {
        background: #f8fafc;
        border-right: none;
        color: #94a3b8;
        border-radius: 12px 0 0 12px;
    }
    .form-control, .form-select {
        border-left: none;
        border-radius: 0 12px 12px 0;
        padding: 0.75rem 1rem;
        border-color: #e2e8f0;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: var(--edit-primary);
        background-color: #fff;
    }
    .input-group:focus-within .input-group-text {
        border-color: var(--edit-primary);
        color: var(--edit-primary);
    }

    /* Danger Zone */
    .danger-card { border: 1px solid #fee2e2; background: #fffafb; }
    .danger-badge { background: #fee2e2; color: var(--edit-danger); padding: 5px 15px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }

    /* Floating labels style labels */
    .label-custom { font-weight: 700; color: #475569; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.5rem; display: block; }
    
    .btn-rounded { border-radius: 12px; padding: 0.7rem 1.5rem; font-weight: 600; transition: all 0.3s; }
</style>

<div class="edit-container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                </ol>
            </nav>
            <h2 class="page-title"><i class="bi bi-pencil-square text-primary me-2"></i>Configuración de Perfil</h2>
        </div>
        <div class="col-md-5 text-md-end">
            <div class="btn-group shadow-sm rounded-4">
                <a href="{{ route('users.show', $user) }}" class="btn btn-white bg-white border"><i class="bi bi-eye me-1"></i> Detalle</a>
                <a href="{{ route('users.index') }}" class="btn btn-white bg-white border"><i class="bi bi-arrow-left me-1"></i> Lista</a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
            <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card card-custom">
                    <div class="card-header-custom">
                        <div class="d-flex align-items-center">
                            <div class="header-icon me-3"><i class="bi bi-person-bounding-box"></i></div>
                            <h5 class="mb-0 fw-bold text-dark">Información Personal</h5>
                        </div>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="label-custom">Nombre Completo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name) }}" required placeholder="Ej: Juan Pérez">
                                </div>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="label-custom">Correo Electrónico <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $user->email) }}" required>
                                </div>
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="label-custom">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="phone" id="phone" class="form-control" 
                                           value="{{ old('phone', $user->phone) }}" placeholder="Ej: 809-555-1234">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="label-custom">Rol de Usuario <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }} data-description="Acceso completo al sistema">Administrador</option>
                                        <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }} data-description="Puede gestionar productos y ventas">Gerente</option>
                                        <option value="employee" {{ old('role', $user->role) == 'employee' ? 'selected' : '' }} data-description="Solo puede registrar ventas">Empleado</option>
                                    </select>
                                </div>
                                <div class="form-text mt-2 text-primary" id="roleDescription">
                                    {{ $user->role == 'admin' ? 'Acceso completo al sistema' : ($user->role == 'manager' ? 'Puede gestionar productos y ventas' : 'Solo puede registrar ventas') }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="label-custom">Estado de la Cuenta</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-toggle2-on"></i></span>
                                    <select name="is_active" id="status" class="form-select">
                                        <option value="1" {{ old('is_active', $user->is_active) == '1' ? 'selected' : '' }}>Cuenta Activa</option>
                                        <option value="0" {{ old('is_active', $user->is_active) == '0' ? 'selected' : '' }}>Cuenta Inactiva</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-custom">
                    <div class="card-header-custom" style="background: #fffdf5;">
                        <div class="d-flex align-items-center">
                            <div class="header-icon me-3" style="background: rgba(245, 158, 11, 0.1); color: var(--edit-warning);"><i class="bi bi-shield-lock"></i></div>
                            <h5 class="mb-0 fw-bold text-dark">Seguridad de la Cuenta</h5>
                        </div>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="alert bg-warning bg-opacity-10 border-0 text-dark small mb-4 rounded-4 p-3 d-flex align-items-center">
                            <i class="bi bi-info-circle-fill fs-4 me-3 text-warning"></i>
                            <div>Deja los campos en blanco si no deseas modificar la contraseña actual.</div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="label-custom">Nueva Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••">
                                    <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword"><i class="bi bi-eye"></i></button>
                                </div>
                                <div class="password-strength mt-2">
                                    <div class="progress" style="height: 6px; border-radius: 10px;">
                                        <div id="passwordStrength" class="progress-bar" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted mt-1 d-block" id="passwordHelp"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="label-custom">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••">
                                    <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePasswordConfirm"><i class="bi bi-eye"></i></button>
                                </div>
                                <div id="passwordMatch" class="mt-1"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-custom">
                    <div class="card-body p-4">
                        <label class="label-custom">Notas y Observaciones</label>
                        <textarea name="notes" id="notes" class="form-control border-start border-1" rows="3" placeholder="Añadir comentarios sobre este perfil...">{{ old('notes', $user->notes ?? '') }}</textarea>
                        
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div class="mb-2">
                                @if($user->id === auth()->id())
                                    <span class="badge rounded-pill bg-info bg-opacity-10 text-info px-3 py-2 border border-info">
                                        <i class="bi bi-person-check me-1"></i> Mi Perfil
                                    </span>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-light btn-rounded">Cancelar</a>
                                <button type="submit" class="btn btn-primary btn-rounded shadow-sm px-5">
                                    <i class="bi bi-cloud-arrow-up me-2"></i> Actualizar Perfil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 rounded-4 bg-white">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem">Creado Por</small>
                        <span class="fw-bold">{{ $user->creator->name ?? 'Sistema' }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 rounded-4 bg-white">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem">Alta en Sistema</small>
                        <span class="fw-bold">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 rounded-4 bg-white">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem">Último Cambio</small>
                        <span class="fw-bold text-primary">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <div class="card card-custom danger-card">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <span class="danger-badge mb-3 d-inline-block">ZONA CRÍTICA</span>
                            <h5 class="fw-bold text-dark">Eliminar este usuario</h5>
                            <p class="text-muted small mb-0">Esta acción borrará permanentemente todos los registros asociados. No se puede revertir.</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button type="button" class="btn btn-outline-danger btn-rounded px-4" 
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <i class="bi bi-trash3 me-2"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-5">
            <div class="modal-body p-5 text-center">
                <div class="mb-4">
                    <i class="bi bi-exclamation-triangle display-1 text-danger"></i>
                </div>
                <h3 class="fw-bold mb-3">¿Confirmar eliminación?</h3>
                <p class="text-muted mb-4">Estás a punto de borrar a <strong>{{ $user->name }}</strong>. Todos sus datos y ventas desaparecerán permanentemente.</p>
                
                <div class="bg-light p-3 rounded-4 text-start mb-4 border">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirmDelete">
                        <label class="form-check-label small fw-bold" for="confirmDelete">
                            Confirmo que entiendo que esta acción es definitiva y no se puede recuperar.
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light btn-rounded flex-grow-1" data-bs-dismiss="modal">Mantener Usuario</button>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="flex-grow-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-rounded w-100" id="deleteButton" disabled>Confirmar Baja</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Toggle visibilidad contraseña
    function setupToggle(btnId, inputId) {
        document.getElementById(btnId).addEventListener('click', function() {
            const input = document.getElementById(inputId);
            const icon = this.querySelector('i');
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    }
    setupToggle('togglePassword', 'password');
    setupToggle('togglePasswordConfirm', 'password_confirmation');

    // Fortaleza de contraseña
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const bar = document.getElementById('passwordStrength');
        const help = document.getElementById('passwordHelp');
        let strength = 0;
        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
        if (password.match(/[0-9]/)) strength += 25;
        if (password.match(/[$@#&!]/)) strength += 25;

        bar.style.width = strength + '%';
        if (strength <= 25) { bar.className = 'progress-bar bg-danger'; help.innerText = 'Muy débil'; }
        else if (strength <= 50) { bar.className = 'progress-bar bg-warning'; help.innerText = 'Débil'; }
        else if (strength <= 75) { bar.className = 'progress-bar bg-info'; help.innerText = 'Media'; }
        else { bar.className = 'progress-bar bg-success'; help.innerText = 'Fuerte'; }
    });

    // Validar coincidencia
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const pass = document.getElementById('password').value;
        const match = document.getElementById('passwordMatch');
        if (this.value === pass && pass !== "") {
            this.classList.replace('is-invalid', 'is-valid') || this.classList.add('is-valid');
            match.innerHTML = '<small class="text-success"><i class="bi bi-check-circle-fill"></i> Las contraseñas coinciden</small>';
        } else if(this.value !== "") {
            this.classList.add('is-invalid');
            match.innerHTML = '<small class="text-danger"><i class="bi bi-x-circle-fill"></i> No coinciden</small>';
        } else {
            this.classList.remove('is-valid', 'is-invalid');
            match.innerHTML = '';
        }
    });

    // Descripción de rol
    document.getElementById('role').addEventListener('change', function() {
        const desc = this.options[this.selectedIndex].getAttribute('data-description');
        document.getElementById('roleDescription').innerText = desc;
    });

    // Confirmación de borrado
    document.getElementById('confirmDelete').addEventListener('change', function() {
        document.getElementById('deleteButton').disabled = !this.checked;
    });

    // Alerta de cambios sensibles
    document.querySelector('form:not(#deleteForm)').addEventListener('submit', function(e) {
        const originalRole = '{{ $user->role }}';
        const originalStatus = '{{ $user->is_active }}';
        if (document.getElementById('role').value !== originalRole || document.getElementById('status').value !== originalStatus) {
            if (!confirm('Has modificado el Rol o el Estado. Esto afectará los permisos del usuario inmediatamente. ¿Continuar?')) {
                e.preventDefault();
            }
        }
    });
</script>
@endpush