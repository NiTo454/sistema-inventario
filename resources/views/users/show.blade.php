@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title">
                            <i class="bi bi-person-circle"></i> Detalles del Usuario
                        </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('users.index') }}">Usuarios</a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ $user->name }}
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="btn-group" role="group">
                            @can('admin')
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            @endcan
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
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar-xl mx-auto mb-3">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}"
                                 alt="{{ $user->name }}"
                                 class="rounded-circle img-thumbnail"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                 style="width: 150px; height: 150px;">
                                <i class="bi bi-person-circle text-white" style="font-size: 80px;"></i>
                            </div>
                        @endif
                    </div>

                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-2">{{ $user->email }}</p>

                    <div class="mb-3">
                        @if($user->is_active)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif

                        <span class="badge bg-{{
                            $user->role === 'admin' ? 'danger' :
                            ($user->role === 'manager' ? 'warning' : 'info')
                        }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    @if($user->id === auth()->id())
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> Este es tu perfil
                        </div>
                    @endif
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle"></i> Información de Contacto
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-envelope me-2"></i> Email:</span>
                            <span class="text-primary">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-telephone me-2"></i> Teléfono:</span>
                            <span>{{ $user->phone ?? 'No especificado' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-calendar me-2"></i> Miembro desde:</span>
                            <span>{{ $user->created_at->format('d/m/Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-clock me-2"></i> Última actualización:</span>
                            <span>{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            @can('admin')
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning"></i> Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Editar Usuario
                        </a>

                        @if($user->is_active)
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#toggleStatusModal">
                                <i class="bi bi-toggle-off"></i> Desactivar Usuario
                            </button>
                        @else
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#toggleStatusModal">
                                <i class="bi bi-toggle-on"></i> Activar Usuario
                            </button>
                        @endif

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <i class="bi bi-trash"></i> Eliminar Usuario
                        </button>
                    </div>
                </div>
            </div>
            @endcan
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Ventas Realizadas</h6>
                                    <h3 class="mb-0">0</h3>
                                </div>
                                <i class="bi bi-cart-check fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Total Vendido</h6>
                                    <h3 class="mb-0">10 peso</h3>
                                </div>
                                <i class="bi bi-cash-stack fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Productos Gestionados</h6>
                                    <h3 class="mb-0">Todos</h3>
                                </div>
                                <i class="bi bi-box-seam fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actividad reciente -->
            <div class="card mt-3">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="activityTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="sales-tab" data-bs-toggle="tab" href="#sales" role="tab">
                                <i class="bi bi-cart"></i> Últimas Ventas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="activity-tab" data-bs-toggle="tab" href="#activity" role="tab">
                                <i class="bi bi-activity"></i> Actividad
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="activityTabsContent">
                        <!-- Tab de ventas -->
                        <div class="tab-pane fade show active" id="sales" role="tabpanel">
                            @php
                                $recentSales = $user->sales()->with('customer')->latest()->take(5)->get();
                            @endphp

                            @if($recentSales->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Factura</th>
                                                <th>Cliente</th>
                                                <th>Fecha</th>
                                                <th>Total</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentSales as $sale)
                                            <tr>
                                                <td>
                                                    <strong>{{ $sale->invoice_number }}</strong>
                                                </td>
                                                <td>{{ $sale->customer->name ?? 'Cliente General' }}</td>
                                                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                                <td>${{ number_format($sale->total, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $sale->status === 'completed' ? 'success' : 'warning' }}">
                                                        {{ $sale->status_text }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if($user->sales->count() > 5)
                                <div class="text-center mt-3">
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        Ver todas las ventas
                                    </a>
                                </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-cart-x display-4 text-muted"></i>
                                    <p class="mt-2">No hay ventas registradas</p>
                                </div>
                            @endif
                        </div>

                        <!-- Tab de actividad -->
                        <div class="tab-pane fade" id="activity" role="tabpanel">
                            <div class="timeline">
                                @php
                                    $activities = collect();

                                    // Agregar creación del usuario
                                    $activities->push([
                                        'type' => 'user_created',
                                        'description' => 'Usuario creado',
                                        'date' => $user->created_at,
                                        'icon' => 'bi-person-plus',
                                        'color' => 'success'
                                    ]);

                                    // Agregar actualizaciones si existieran
                                    if ($user->updated_at != $user->created_at) {
                                        $activities->push([
                                            'type' => 'user_updated',
                                            'description' => 'Perfil actualizado',
                                            'date' => $user->updated_at,
                                            'icon' => 'bi-pencil',
                                            'color' => 'info'
                                        ]);
                                    }

                                    // Ordenar por fecha descendente
                                    $activities = $activities->sortByDesc('date')->take(10);
                                @endphp

                                @foreach($activities as $activity)
                                <div class="timeline-item pb-3">
                                    <div class="d-flex">
                                        <div class="timeline-icon me-3">
                                            <span class="bg-{{ $activity['color'] }} rounded-circle d-flex align-items-center justify-content-center"
                                                  style="width: 40px; height: 40px;">
                                                <i class="bi {{ $activity['icon'] }} text-white"></i>
                                            </span>
                                        </div>
                                        <div class="timeline-content flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1">{{ $activity['description'] }}</h6>
                                                <small class="text-muted">{{ $activity['date']->diffForHumans() }}</small>
                                            </div>
                                            <p class="text-muted mb-0">
                                                {{ $activity['date']->format('d/m/Y H:i:s') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-gear"></i> Configuración y Preferencias
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Información del Sistema</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td>ID de Usuario:</td>
                                    <td><strong>#{{ $user->id }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Verificado:</td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">Sí ({{ $user->email_verified_at->format('d/m/Y') }})</span>
                                        @else
                                            <span class="badge bg-warning">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Último login:</td>
                                    <td>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Permisos del Sistema</h6>
                            <ul class="list-unstyled">
                                @php
                                    $permissions = [
                                        'admin' => ['Gestionar usuarios', 'Gestionar productos', 'Gestionar ventas', 'Ver reportes'],
                                        'manager' => ['Gestionar productos', 'Gestionar ventas', 'Ver reportes'],
                                        'employee' => ['Registrar ventas', 'Ver productos']
                                    ];
                                @endphp

                                @foreach($permissions[$user->role] as $permission)
                                    <li>
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        {{ $permission }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación para Eliminar -->
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
                <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                <div class="alert alert-warning">
                    <strong>Usuario:</strong> {{ $user->name }}<br>
                    <strong>Email:</strong> {{ $user->email }}<br>
                    <strong>Rol:</strong> {{ ucfirst($user->role) }}
                </div>
                <p class="text-danger">
                    <i class="bi bi-info-circle"></i>
                    Esta acción no se puede deshacer. Se eliminarán permanentemente todos los datos asociados.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Eliminar Permanentemente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Cambiar Estado -->
@can('admin')
<div class="modal fade" id="toggleStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-{{ $user->is_active ? 'secondary' : 'success' }} text-white">
                <h5 class="modal-title">
                    <i class="bi bi-{{ $user->is_active ? 'toggle-off' : 'toggle-on' }}"></i>
                    {{ $user->is_active ? 'Desactivar' : 'Activar' }} Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas {{ $user->is_active ? 'desactivar' : 'activar' }} este usuario?</p>

                @if($user->is_active)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        Al desactivar el usuario, no podrá iniciar sesión en el sistema.
                    </div>
                @else
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i>
                        Al activar el usuario, podrá iniciar sesión nuevamente.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <input type="hidden" name="phone" value="{{ $user->phone }}">
                    <button type="submit" class="btn btn-{{ $user->is_active ? 'secondary' : 'success' }}">
                        <i class="bi bi-{{ $user->is_active ? 'toggle-off' : 'toggle-on' }}"></i>
                        {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-xl {
        width: 150px;
        height: 150px;
    }

    .timeline-item:not(:last-child) {
        border-left: 2px solid #e9ecef;
        padding-left: 20px;
        margin-left: 20px;
    }

    .timeline-icon {
        position: relative;
        left: -28px;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }

    .page-title-box {
        padding: 20px 0;
    }

    .card {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card-header {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    // Activar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Confirmación adicional para eliminar
    document.querySelectorAll('form[action*="destroy"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('¿Estás ABSOLUTAMENTE seguro? Esta acción es irreversible.')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
