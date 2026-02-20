@extends('layouts.app')
@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title">
                            <i class="bi bi-pencil-square"></i> Editar Usuario
                        </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('users.index') }}">Usuarios</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Editar
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('users.show', $user) }}" class="btn btn-info">
                                <i class="bi bi-eye"></i> Ver Detalles
                            </a>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil"></i> Formulario de Edición
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-uppercase text-muted mb-3">
                                    <i class="bi bi-person"></i> Información Personal
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label">
                                    Nombre Completo <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $user->name) }}"
                                           required
                                           placeholder="Ej: Juan Pérez">
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $user->email) }}"
                                           required
                                           placeholder="ejemplo@correo.com">
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">
                                    Teléfono
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', $user->phone) }}"
                                           placeholder="Ej: 809-555-1234">
                                </div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h6 class="text-uppercase text-muted mb-3">
                                    <i class="bi bi-shield-lock"></i> Información de Cuenta
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="role" class="form-label">
                                    Rol de Usuario <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <select class="form-select @error('role') is-invalid @enderror"
                                            id="role"
                                            name="role"
                                            required>
                                        <option value="">Seleccionar Rol...</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}
                                                data-description="Acceso completo al sistema">
                                            Administrador
                                        </option>
                                        <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}
                                                data-description="Puede gestionar productos y ventas">
                                            Gerente
                                        </option>
                                        <option value="employee" {{ old('role', $user->role) == 'employee' ? 'selected' : '' }}
                                                data-description="Solo puede registrar ventas">
                                            Empleado
                                        </option>
                                    </select>
                                </div>
                                <div class="form-text" id="roleDescription">
                                    @if($user->role == 'admin')
                                        Acceso completo al sistema
                                    @elseif($user->role == 'manager')
                                        Puede gestionar productos y ventas
                                    @elseif($user->role == 'employee')
                                        Solo puede registrar ventas
                                    @endif
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">
                                    Estado de la Cuenta
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                    <select class="form-select @error('is_active') is-invalid @enderror"
                                            id="status"
                                            name="is_active">
                                        <option value="1" {{ old('is_active', $user->is_active) == '1' ? 'selected' : '' }}>
                                            Activo - Puede iniciar sesión
                                        </option>
                                        <option value="0" {{ old('is_active', $user->is_active) == '0' ? 'selected' : '' }}>
                                            Inactivo - No puede iniciar sesión
                                        </option>
                                    </select>
                                </div>
                                @error('is_active')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h6 class="text-uppercase text-muted mb-3">
                                    <i class="bi bi-key"></i> Cambiar Contraseña
                                </h6>
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i>
                                    Deja estos campos en blanco si no deseas cambiar la contraseña.
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    Nueva Contraseña
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="Mínimo 8 caracteres">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="password-strength mt-2">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar" id="passwordStrength" style="width: 0%;"></div>
                                    </div>
                                    <small class="text-muted" id="passwordHelp"></small>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">
                                    Confirmar Nueva Contraseña
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                    <input type="password"
                                           class="form-control"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           placeholder="Repite la contraseña">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback" id="passwordMatch"></div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h6 class="text-uppercase text-muted mb-3">
                                    <i class="bi bi-pencil"></i> Notas Adicionales
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="notes" class="form-label">
                                    Notas sobre el usuario
                                </label>
                                <textarea class="form-control @error('notes') is-invalid @enderror"
                                          id="notes"
                                          name="notes"
                                          rows="3"
                                          placeholder="Información adicional, observaciones, etc.">{{ old('notes', $user->notes ?? '') }}</textarea>
                                @error('notes')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($user->id === auth()->id())
                                            <span class="badge bg-info">
                                                <i class="bi bi-info-circle"></i> Estás editando tu propio perfil
                                            </span>
                                        @endif
                                    </div>
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="bi bi-check-circle"></i> Actualizar Usuario
                                        </button>
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                                            <i class="bi bi-x-circle"></i> Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history"></i> Información del Registro
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Creado por:</small>
                            <strong>
                                @if($user->created_by)
                                    {{ $user->creator->name ?? 'Sistema' }}
                                @else
                                    Sistema
                                @endif
                            </strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Fecha de creación:</small>
                            <strong>{{ $user->created_at->format('d/m/Y H:i') }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Última actualización:</small>
                            <strong>{{ $user->updated_at->format('d/m/Y H:i') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle"></i> Zona de Peligro
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="text-danger">Eliminar Usuario</h6>
                            <p class="text-muted mb-0">
                                Una vez que elimines este usuario, no hay vuelta atrás.
                                Todos sus datos y registros asociados serán eliminados permanentemente.
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" class="btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <i class="bi bi-trash"></i> Eliminar Usuario
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás ABSOLUTAMENTE seguro de que deseas eliminar este usuario?</p>

                <div class="alert alert-warning">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="bi bi-person-circle fs-1"></i>
                        </div>
                        <div>
                            <strong>{{ $user->name }}</strong><br>
                            <small>{{ $user->email }}</small><br>
                            <span class="badge bg-{{
                                $user->role === 'admin' ? 'danger' :
                                ($user->role === 'manager' ? 'warning' : 'info')
                            }}">{{ ucfirst($user->role) }}</span>
                        </div>
                    </div>
                </div>

                <div class="alert alert-danger">
                    <i class="bi bi-info-circle"></i>
                    Esta acción eliminará permanentemente:
                    <ul class="mb-0 mt-2">
                        <li>El usuario y su información personal</li>
                        <li>Todos los registros de ventas asociados</li>
                        <li>Historial de actividad del usuario</li>
                    </ul>
                </div>

                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="confirmDelete">
                    <label class="form-check-label" for="confirmDelete">
                        Entiendo que esta acción no se puede deshacer
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <form action="{{ route('users.destroy', $user) }}" method="POST" id="deleteForm">
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="deleteButton" disabled>
                        <i class="bi bi-trash"></i> Eliminar Permanentemente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .page-title-box {
        padding: 20px 0;
    }

    .card {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card-header {
        font-weight: 500;
    }

    .password-strength .progress {
        border-radius: 3px;
        margin-top: 5px;
    }

    .is-valid {
        border-color: #28a745;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .btn-group {
        gap: 5px;
    }

    .border-danger {
        border-left: 4px solid #dc3545 !important;
    }

    .btn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    @media (max-width: 768px) {
        .btn-group {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .btn-group .btn {
            margin-bottom: 5px;
        }
    }
</style>
@endpush

@push('scripts')
<script>

    document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('password');
        const icon = this.querySelector('i');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
        const password = document.getElementById('password_confirmation');
        const icon = this.querySelector('i');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('passwordStrength');
        const helpText = document.getElementById('passwordHelp');

        let strength = 0;
        let message = '';

        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]+/)) strength += 25;
        if (password.match(/[A-Z]+/)) strength += 25;
        if (password.match(/[0-9]+/) || password.match(/[$@#&!]+/)) strength += 25;

        strengthBar.style.width = strength + '%';

        if (strength < 25) {
            strengthBar.className = 'progress-bar bg-danger';
            message = 'Muy débil';
        } else if (strength < 50) {
            strengthBar.className = 'progress-bar bg-warning';
            message = 'Débil';
        } else if (strength < 75) {
            strengthBar.className = 'progress-bar bg-info';
            message = 'Media';
        } else {
            strengthBar.className = 'progress-bar bg-success';
            message = 'Fuerte';
        }

        helpText.textContent = message;
    });

    // Ver que las contraseñas coincidan
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirm = this.value;
        const matchText = document.getElementById('passwordMatch');

        if (confirm.length > 0) {
            if (password === confirm) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                matchText.textContent = '✓ Las contraseñas coinciden';
                matchText.className = 'valid-feedback d-block';
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                matchText.textContent = '✗ Las contraseñas no coinciden';
                matchText.className = 'invalid-feedback d-block';
            }
        } else {
            this.classList.remove('is-valid', 'is-invalid');
            matchText.textContent = '';
        }
    });

    // Mostrar descripción rol
    document.getElementById('role').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const description = selected.getAttribute('data-description') || '';
        document.getElementById('roleDescription').textContent = description;
    });

    document.getElementById('confirmDelete').addEventListener('change', function() {
        document.getElementById('deleteButton').disabled = !this.checked;
    });

    // Validación antes eliminación
    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        if (!document.getElementById('confirmDelete').checked) {
            e.preventDefault();
            alert('Debes confirmar antes de borrar.');
        }
    });

    document.querySelector('form:not(#deleteForm)').addEventListener('submit', function(e) {
        const roleChanged = '{{ old('role', $user->role) }}' !== '{{ $user->role }}';
        const statusChanged = '{{ old('is_active', $user->is_active) }}' !== '{{ $user->is_active }}';

        if (roleChanged || statusChanged) {
            if (!confirm('¿Estás seguro de cambiar el rol o estado del usuario? Esto cambiara sus permisos inmediatamente.')) {
                e.preventDefault();
            }
        }
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endpush
