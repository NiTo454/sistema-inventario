@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="container py-5">
    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Crear Usuario</h1>
            <p class="text-muted mb-0">Complete el formulario para registrar un nuevo usuario.</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-secondary small">NOMBRE COMPLETO</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-0 shadow-none @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required placeholder="Ej: Juan Pérez">
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-secondary small">CORREO ELECTRÓNICO</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" class="form-control bg-light border-0 shadow-none @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}" required placeholder="nombre@empresa.com">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold text-secondary small">CONTRASEÑA</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-key text-muted"></i></span>
                                    <input type="password" class="form-control bg-light border-0 shadow-none @error('password') is-invalid @enderror"
                                           id="password" name="password" required>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-bold text-secondary small">CONFIRMAR CONTRASEÑA</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-check2-square text-muted"></i></span>
                                    <input type="password" class="form-control bg-light border-0 shadow-none"
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label for="role" class="form-label fw-bold text-secondary small">ROL DE USUARIO</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-shield-lock text-muted"></i></span>
                                    <select class="form-select bg-light border-0 shadow-none @error('role') is-invalid @enderror"
                                            id="role" name="role" required>
                                        <option value="">Seleccionar Rol...</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Gerente</option>
                                        <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Empleado</option>
                                    </select>
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-bold text-secondary small">TELÉFONO</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-telephone text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-0 shadow-none @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone') }}" placeholder="+51 999 999 999">
                                </div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 shadow-sm fw-bold">
                                <i class="bi bi-person-plus-fill me-2"></i>Crear Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
