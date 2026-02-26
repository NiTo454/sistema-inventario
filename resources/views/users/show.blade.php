@extends('layouts.app')

@section('title', 'Perfil de ' . $user->name)

@section('content')
<style>
    :root {
        --profile-primary: #4361ee;
        --profile-bg: #f4f7fe;
    }

    .profile-wrapper { padding: 1.5rem; background: var(--profile-bg); min-height: 100vh; }
    
    /* Tarjetas Modernas */
    .card-modern {
        border: none;
        border-radius: 20px;
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    .card-header-modern {
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        padding: 1.25rem 1.5rem;
    }

    /* Perfil Hero */
    .profile-cover {
        height: 120px;
        background: linear-gradient(135deg, #00146d 0%, #4361ee 100%);
        position: relative;
    }
    .profile-avatar-container {
        margin-top: -60px;
        text-align: center;
        position: relative;
        z-index: 1;
    }
    .avatar-wrapper {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 5px solid white;
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .avatar-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-placeholder { font-size: 3rem; color: var(--profile-primary); font-weight: bold; }

    /* Tarjetas de Estadísticas */
    .stat-card {
        border-radius: 16px;
        padding: 1.5rem;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); }
    .bg-gradient-primary { background: linear-gradient(135deg, #4361ee, #4895ef); }
    .bg-gradient-success { background: linear-gradient(135deg, #2ec4b6, #80ffdb); color: #004b49;}
    .bg-gradient-info { background: linear-gradient(135deg, #4cc9f0, #4361ee); }

    /* Tabs Estilizados */
    .nav-pills-custom { gap: 0.5rem; padding: 0.5rem 1.5rem; }
    .nav-pills-custom .nav-link {
        border-radius: 10px;
        color: #64748b;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
    }
    .nav-pills-custom .nav-link.active {
        background-color: var(--profile-primary);
        color: white;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.25);
    }

    /* Timeline Moderno */
    .modern-timeline { position: relative; padding-left: 2.5rem; margin-top: 1rem; }
    .modern-timeline::before {
        content: '';
        position: absolute;
        left: 0.75rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }
    .timeline-item { position: relative; margin-bottom: 1.5rem; }
    .timeline-dot {
        position: absolute;
        left: -2.5rem;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid white;
        z-index: 2;
    }
    .timeline-dot i { font-size: 0.75rem; color: white; }

    /* Listas de Detalles */
    .detail-list { padding: 0; margin: 0; list-style: none; }
    .detail-list li {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
    }
    .detail-list li:last-child { border-bottom: none; }
    .detail-icon {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        background: #f1f5f9;
        color: var(--profile-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }

    .btn-rounded { border-radius: 10px; font-weight: 600; padding: 0.5rem 1.2rem; }
</style>

<div class="profile-wrapper">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">Perfil de Usuario</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">Usuarios</a></li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('users.index') }}" class="btn btn-light btn-rounded shadow-sm border">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            @can('admin')
            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-rounded shadow-sm text-dark">
                <i class="bi bi-pencil-square me-1"></i> Editar Perfil
            </a>
            @endcan
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card-modern text-center">
                <div class="profile-cover"></div>
                <div class="profile-avatar-container">
                    <div class="avatar-wrapper">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                        @else
                            <div class="avatar-placeholder bg-light w-100 h-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-person text-primary"></i>
                            </div>
                        @endif
                    </div>
                    <div class="px-4 pb-4 mt-3">
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                        <p class="text-muted small mb-3">{{ $user->email }}</p>
                        
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}-subtle text-{{ $user->is_active ? 'success' : 'secondary' }} border rounded-pill px-3 py-2">
                                <i class="bi bi-{{ $user->is_active ? 'check-circle' : 'dash-circle' }} me-1"></i>
                                {{ $user->is_active ? 'Cuenta Activa' : 'Cuenta Inactiva' }}
                            </span>
                            <span class="badge bg-primary-subtle text-primary border rounded-pill px-3 py-2 text-uppercase">
                                {{ $user->role }}
                            </span>
                        </div>

                        @if($user->id === auth()->id())
                            <div class="alert alert-info border-0 rounded-3 py-2 small mb-0 mt-3 d-inline-block">
                                <i class="bi bi-person-badge me-1"></i> Estás viendo tu propio perfil
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-modern">
                <div class="card-header-modern">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-address-book me-2 text-primary"></i>Datos de Contacto</h6>
                </div>
                <ul class="detail-list">
                    <li>
                        <div class="detail-icon"><i class="bi bi-envelope"></i></div>
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Correo Electrónico</small>
                            <span class="fw-semibold text-dark">{{ $user->email }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="detail-icon"><i class="bi bi-telephone"></i></div>
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Teléfono</small>
                            <span class="fw-semibold text-dark">{{ $user->phone ?? 'No especificado' }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="detail-icon"><i class="bi bi-calendar-event"></i></div>
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Fecha de Registro</small>
                            <span class="fw-semibold text-dark">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="detail-icon"><i class="bi bi-clock-history"></i></div>
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Última Actualización</small>
                            <span class="fw-semibold text-dark">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </li>
                </ul>
            </div>

            @can('admin')
            <div class="card-modern border border-warning border-opacity-25">
                <div class="card-header-modern bg-warning bg-opacity-10">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Gestión Administrativa</h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        @if($user->is_active)
                            <button type="button" class="btn btn-outline-secondary btn-rounded" data-bs-toggle="modal" data-bs-target="#toggleStatusModal">
                                <i class="bi bi-person-lock me-2"></i> Suspender Acceso
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-success btn-rounded" data-bs-toggle="modal" data-bs-target="#toggleStatusModal">
                                <i class="bi bi-person-check me-2"></i> Reactivar Acceso
                            </button>
                        @endif

                        <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModal" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <i class="bi bi-trash3 me-2"></i> Eliminar Usuario
                        </button>
                    </div>
                </div>
            </div>
            @endcan
        </div>

        <div class="col-lg-8">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card bg-gradient-primary">
                        <div>
                            <p class="mb-1 fw-bold opacity-75 text-uppercase" style="font-size: 0.75rem;">Ventas Realizadas</p>
                            <h3 class="fw-bold mb-0">0</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-cart-check fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-gradient-success">
                        <div>
                            <p class="mb-1 fw-bold opacity-75 text-uppercase" style="font-size: 0.75rem;">Total Vendido</p>
                            <h3 class="fw-bold mb-0">10 peso</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-cash-stack fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-gradient-info">
                        <div>
                            <p class="mb-1 fw-bold opacity-75 text-uppercase" style="font-size: 0.75rem;">Productos Gestionados</p>
                            <h3 class="fw-bold mb-0">Todos</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-modern">
                <div class="card-header bg-white border-bottom pt-3 pb-0 px-0">
                    <ul class="nav nav-pills nav-pills-custom mb-3" id="activityTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="sales-tab" data-bs-toggle="pill" href="#sales" role="tab">
                                <i class="bi bi-receipt me-2"></i>Historial de Ventas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="activity-tab" data-bs-toggle="pill" href="#activity" role="tab">
                                <i class="bi bi-activity me-2"></i>Registro de Actividad
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body p-0">
                    <div class="tab-content" id="activityTabsContent">
                        
                        <div class="tab-pane fade show active p-4" id="sales" role="tabpanel">
                            @php
                                $recentSales = $user->sales()->with('customer')->latest()->take(5)->get();
                            @endphp

                            @if($recentSales->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light text-muted small text-uppercase">
                                            <tr>
                                                <th class="border-0 rounded-start">Factura</th>
                                                <th class="border-0">Cliente</th>
                                                <th class="border-0">Fecha</th>
                                                <th class="border-0">Total</th>
                                                <th class="border-0 text-center">Estado</th>
                                                <th class="border-0 rounded-end text-end">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentSales as $sale)
                                            <tr>
                                                <td class="fw-bold text-primary">#{{ $sale->invoice_number }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width:30px; height:30px; font-size: 0.8rem;">
                                                            <i class="bi bi-person-fill"></i>
                                                        </div>
                                                        <span class="fw-semibold text-dark">{{ $sale->customer->name ?? 'Cliente General' }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-muted small">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                                <td class="fw-bold">${{ number_format($sale->total, 2) }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-{{ $sale->status === 'completed' ? 'success' : 'warning' }}-subtle text-{{ $sale->status === 'completed' ? 'success' : 'warning' }} px-3 rounded-pill">
                                                        {{ $sale->status_text }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-light border btn-rounded text-primary">
                                                        Ver detalle
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($user->sales->count() > 5)
                                    <div class="text-center mt-4">
                                        <a href="#" class="btn btn-outline-primary btn-rounded px-4">Ver historial completo</a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-5">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-cart-x text-muted fs-1"></i>
                                    </div>
                                    <h5 class="text-dark fw-bold">Sin transacciones</h5>
                                    <p class="text-muted">Este usuario aún no ha registrado ninguna venta en el sistema.</p>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade p-4" id="activity" role="tabpanel">
                            @php
                                $activities = collect();
                                $activities->push([
                                    'type' => 'user_created',
                                    'description' => 'Alta de usuario en el sistema',
                                    'date' => $user->created_at,
                                    'icon' => 'bi-person-plus-fill',
                                    'color' => 'success'
                                ]);
                                if ($user->updated_at != $user->created_at) {
                                    $activities->push([
                                        'type' => 'user_updated',
                                        'description' => 'Actualización de perfil / permisos',
                                        'date' => $user->updated_at,
                                        'icon' => 'bi-pencil-square',
                                        'color' => 'primary'
                                    ]);
                                }
                                $activities = $activities->sortByDesc('date')->take(10);
                            @endphp

                            <div class="modern-timeline">
                                @foreach($activities as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-dot bg-{{ $activity['color'] }}">
                                        <i class="bi {{ $activity['icon'] }}"></i>
                                    </div>
                                    <div class="card border-0 bg-light rounded-4 p-3 shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="fw-bold mb-0 text-dark">{{ $activity['description'] }}</h6>
                                            <span class="badge bg-white text-muted border shadow-sm">{{ $activity['date']->diffForHumans() }}</span>
                                        </div>
                                        <small class="text-muted"><i class="bi bi-calendar-event me-1"></i> {{ $activity['date']->format('d M Y, H:i:s') }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-modern mb-0">
                <div class="card-header-modern">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-shield-check me-2 text-primary"></i>Configuración y Permisos</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="bg-light rounded-4 p-4 h-100 border">
                                <h6 class="fw-bold text-dark mb-3">Estado de Autenticación</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <span class="text-muted small fw-bold text-uppercase">Verificación Email</span>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success-subtle text-success"><i class="bi bi-check2-circle me-1"></i>Verificado</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning"><i class="bi bi-exclamation-circle me-1"></i>Pendiente</span>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small fw-bold text-uppercase">Último Acceso</span>
                                    <span class="fw-semibold text-dark small">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca ingresó' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-4 p-4 h-100 border">
                                <h6 class="fw-bold text-dark mb-3">Capacidades del Rol: <span class="text-primary">{{ ucfirst($user->role) }}</span></h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @php
                                        $permissions = [
                                            'admin' => ['Gestión Usuarios', 'Gestión Productos', 'Gestión Ventas', 'Reportes Avanzados'],
                                            'manager' => ['Gestión Productos', 'Gestión Ventas', 'Ver Reportes'],
                                            'employee' => ['Registrar Ventas', 'Ver Inventario']
                                        ];
                                    @endphp

                                    @foreach($permissions[$user->role] as $permission)
                                        <span class="badge bg-white text-dark border shadow-sm px-2 py-2">
                                            <i class="bi bi-check2 text-success me-1"></i> {{ $permission }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@can('admin')
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-5 text-center">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                    <i class="bi bi-exclamation-triangle-fill display-4"></i>
                </div>
                <h3 class="fw-bold mb-3">Eliminar Usuario</h3>
                <p class="text-muted mb-4">¿Estás seguro de que deseas eliminar permanentemente a <strong>{{ $user->name }}</strong>? Esta acción destruirá todos sus datos y ventas asociadas.</p>
                
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light btn-rounded flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="flex-grow-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-rounded w-100">Eliminar Definitivamente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="toggleStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-5 text-center">
                <div class="bg-{{ $user->is_active ? 'warning' : 'success' }} bg-opacity-10 text-{{ $user->is_active ? 'warning' : 'success' }} rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-{{ $user->is_active ? 'lock' : 'check' }} display-4"></i>
                </div>
                <h3 class="fw-bold mb-3">{{ $user->is_active ? 'Suspender' : 'Reactivar' }} Acceso</h3>
                
                @if($user->is_active)
                    <p class="text-muted mb-4">Al suspender a <strong>{{ $user->name }}</strong>, no podrá iniciar sesión ni usar el sistema hasta que lo reactives.</p>
                @else
                    <p class="text-muted mb-4">Al reactivar a <strong>{{ $user->name }}</strong>, recuperará su acceso al sistema con los permisos de su rol.</p>
                @endif

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light btn-rounded flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('users.update', $user) }}" method="POST" class="flex-grow-1">
                        @csrf @method('PUT')
                        <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="role" value="{{ $user->role }}">
                        <input type="hidden" name="phone" value="{{ $user->phone }}">
                        <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }} btn-rounded w-100 text-{{ $user->is_active ? 'dark' : 'white' }}">
                            {{ $user->is_active ? 'Sí, Suspender' : 'Sí, Reactivar' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan

@endsection

@push('scripts')
<script>
    // Activar tooltips si existen
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Confirmación adicional para eliminar nativa (opcional por seguridad extra)
    document.querySelectorAll('form[action*="destroy"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            // El modal ya confirma visualmente, pero se deja por seguridad
        });
    });
</script
>
@endpush