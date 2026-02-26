@extends('layouts.app')

@section('title', 'Directorio de Usuarios')

@section('content')
<style>
    /* Avatares Dinámicos */
    .avatar-wrapper {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-weight: bold;
        font-size: 1.1rem;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
    }

    /* Badges de Roles Modernos */
    .role-pill {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .role-admin { background: #fee2e2; color: #ef4444; border: 1px solid #fca5a5; }
    .role-manager { background: #fef3c7; color: #f59e0b; border: 1px solid #fcd34d; }
    .role-user { background: #eff6ff; color: #3b82f6; border: 1px solid #bfdbfe; }

    /* Estado Switch Visual */
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    /* Botones de Acción Estilo Minimal */
    .action-group .btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
        background: #f1f5f9;
        color: #475569;
    }
    .action-group .btn-view:hover { background: #e0e7ff; color: #4361ee; transform: translateY(-2px); }
    .action-group .btn-edit:hover { background: #fef3c7; color: #d97706; transform: translateY(-2px); }
    .action-group .btn-delete:hover { background: #fee2e2; color: #dc2626; transform: translateY(-2px); }

    /* Tabla Custom */
    .table-custom-card {
        border-radius: 20px;
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        border: none;
        overflow: hidden;
    }
    .table thead th {
        background: #f8fafc;
        padding: 1rem 1.2rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        color: #64748b;
        border-bottom: 2px solid #e2e8f0;
    }
    .table tbody td {
        padding: 1.2rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .user-row { transition: background-color 0.2s; }
    .user-row:hover { background-color: #f8fafc; }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Directorio de Usuarios</h2>
        <p class="text-muted small mb-0">Administra los accesos y privilegios de tu equipo de trabajo.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm fw-bold d-flex align-items-center gap-2">
        <i class="bi bi-person-plus-fill"></i> Registrar Usuario
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
    <div class="card-body p-3 px-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="input-group bg-light rounded-pill px-3 py-1 border border-light transition-all focus-within-border-primary">
                    <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInput" class="form-control border-0 bg-transparent shadow-none" placeholder="Buscar por nombre, email o rol...">
                </div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <span class="badge bg-light text-dark border px-3 py-2 fs-6 rounded-pill" id="userCountBadge">
                    Total: {{ $users->count() }} miembros
                </span>
            </div>
        </div>
    </div>
</div>

<div class="table-custom-card">
    <div class="table-responsive">
        <table class="table mb-0" id="usersTable">
            <thead>
                <tr>
                    <th class="ps-4">Identidad</th>
                    <th>Contacto</th>
                    <th class="text-center">Privilegios</th>
                    <th>Estado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="user-row">
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-wrapper me-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <span class="d-block fw-bold text-dark fs-6">{{ $user->name }}</span>
                                <span class="text-muted" style="font-size: 0.75rem;">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="small fw-semibold text-dark mb-1"><i class="bi bi-envelope text-muted me-1"></i> {{ $user->email }}</div>
                        <div class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-telephone text-muted me-1"></i> {{ $user->phone ?? 'No registrado' }}</div>
                    </td>
                    <td class="text-center">
                        @php
                            $roleClass = match($user->role) {
                                'admin' => 'role-admin',
                                'manager' => 'role-manager',
                                default => 'role-user',
                            };
                        @endphp
                        <span class="role-pill {{ $roleClass }}">
                            {{ strtoupper($user->role) }}
                        </span>
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                <span class="status-dot bg-success"></span> Activo
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-2">
                                <span class="status-dot bg-secondary"></span> Inactivo
                            </span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <div class="action-group d-flex justify-content-end gap-2">
                            <a href="{{ route('users.show', $user) }}" class="btn btn-view" data-bs-toggle="tooltip" title="Ver Perfil">
                                <i class="bi bi-person-lines-fill"></i>
                            </a>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-edit" data-bs-toggle="tooltip" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-delete btn-delete-trigger" data-bs-toggle="tooltip" title="Eliminar">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

                <tr id="emptyStateRow" style="display: none;">
                    <td colspan="5" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-search display-1 d-block mb-3 opacity-25"></i>
                            <h5 class="fw-bold text-dark">No se encontraron resultados</h5>
                            <p class="mb-0">No hay usuarios que coincidan con tu búsqueda "<span id="searchTermDisplay" class="fw-bold text-primary"></span>"</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inicializar Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // 2. Búsqueda en Tiempo Real (Live Search)
        const searchInput = document.getElementById('searchInput');
        const userRows = document.querySelectorAll('.user-row');
        const emptyStateRow = document.getElementById('emptyStateRow');
        const searchTermDisplay = document.getElementById('searchTermDisplay');
        const userCountBadge = document.getElementById('userCountBadge');

        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase().trim();
            let visibleCount = 0;

            userRows.forEach(row => {
                // Obtenemos todo el texto de la fila (Nombre, Email, Rol)
                const text = row.innerText.toLowerCase();
                
                if(text.includes(filter)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Actualizar el contador del badge
            userCountBadge.innerHTML = `<i class="bi bi-funnel-fill text-primary"></i> Mostrando ${visibleCount} de {{ $users->count() }}`;

            // Mostrar el estado vacío si no hay coincidencias
            if (visibleCount === 0 && filter !== '') {
                emptyStateRow.style.display = '';
                searchTermDisplay.textContent = this.value;
            } else {
                emptyStateRow.style.display = 'none';
            }
            
            // Si se borra la búsqueda, restaurar contador original
            if(filter === '') {
                userCountBadge.innerText = `Total: {{ $users->count() }} miembros`;
            }
        });

        // 3. Confirmación nativa refinada para botones de eliminar
        document.querySelectorAll('.btn-delete-trigger').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if(confirm('¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.')) {
                    this.closest('form').submit();
                }
            });
        });
    });
</script>
@endpush