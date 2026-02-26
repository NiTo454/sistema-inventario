@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Variables locales del Dashboard */
    :root {
        --dash-primary: #4361ee;
        --dash-secondary: #3f37c9;
        --dash-success: #10b981;
        --dash-warning: #f59e0b;
        --dash-danger: #ef4444;
        --dash-info: #0ea5e9;
    }

    /* Banner de Bienvenida Moderno */
    .welcome-banner {
        background: linear-gradient(135deg, var(--dash-primary) 0%, var(--dash-secondary) 100%);
        border-radius: 24px;
        padding: 2.5rem 3rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 30px rgba(67, 97, 238, 0.2);
    }
    .welcome-banner::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }
    .welcome-banner::after {
        content: "";
        position: absolute;
        bottom: -30%;
        right: 20%;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }

    /* Tarjetas Generales */
    .card-modern {
        border: none;
        border-radius: 20px;
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Tarjetas de Estadísticas (KPIs) */
    .stat-card {
        height: 100%;
        padding: 1.5rem;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.06);
    }
    .stat-icon-wrapper {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Botones de Acceso Rápido */
    .quick-action-btn {
        background: white;
        border-radius: 16px;
        padding: 1.5rem 1rem;
        text-decoration: none !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 1px solid #f1f5f9;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .quick-action-btn:hover {
        background: #f8fafc;
        border-color: var(--dash-primary);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(67, 97, 238, 0.1);
    }
    .quick-action-btn i {
        font-size: 2rem;
        margin-bottom: 0.75rem;
        transition: transform 0.2s;
    }
    .quick-action-btn:hover i {
        transform: scale(1.1);
    }

    /* Estilo de Tablas Integrado */
    .table-custom th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #64748b;
        padding: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-custom td {
        padding: 1rem;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Badges Suaves */
    .badge-soft {
        padding: 0.5em 1em;
        font-weight: 600;
        border-radius: 50rem;
        font-size: 0.75rem;
    }
</style>

<div class="mb-4">
    <div class="welcome-banner mb-5">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-md-8">
                <h1 class="display-6 fw-bold mb-2 text-white" style="letter-spacing: -1px;">
                    Hola, {{ explode(' ', Auth::user()->name)[0] }}
                </h1>
                <p class="fs-5 opacity-75 mb-4 text-white font-weight-light">Aquí tienes el estado actual de tu negocio para hoy.</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-white bg-opacity-25 text-white p-2 px-3 border border-white border-opacity-25 rounded-pill shadow-sm">
                        <i class="bi bi-calendar3 me-2"></i> {{ date('d M, Y') }}
                    </span>
                    <span class="badge bg-white bg-opacity-25 text-white p-2 px-3 border border-white border-opacity-25 rounded-pill shadow-sm">
                        <i class="bi bi-shield-check me-2"></i> {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-end d-none d-md-block opacity-50">
                <i class="bi bi-graph-up-arrow" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-sm-6">
            <div class="card-modern stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Productos</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\Product::count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card-modern stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Ventas Totales</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\Sale::count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card-modern stat-card border-bottom border-danger border-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper bg-danger bg-opacity-10 text-danger me-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Stock Bajo</p>
                        <h3 class="fw-bold mb-0 text-danger">{{ \App\Models\Product::whereColumn('stock', '<=', 'min_stock')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card-modern stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper bg-info bg-opacity-10 text-info me-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Usuarios Activos</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\User::where('is_active', true)->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Accesos Rápidos</h5>
    </div>
    <div class="row g-3 mb-5">
        @if(Auth::user()->isAdmin())
        <div class="col-6 col-md-3">
            <a href="{{ route('users.index') }}" class="quick-action-btn">
                <i class="bi bi-person-gear text-primary"></i>
                <span class="fw-bold text-slate-700">Usuarios</span>
            </a>
        </div>
        @endif
        <div class="col-6 col-md-3">
            <a href="{{ route('products.index') }}" class="quick-action-btn">
                <i class="bi bi-archive-fill text-success"></i>
                <span class="fw-bold text-slate-700">Inventario</span>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('sales.create') }}" class="quick-action-btn border-warning">
                <i class="bi bi-cart-plus-fill text-warning"></i>
                <span class="fw-bold text-slate-700">Nueva Venta</span>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('sales.index') }}" class="quick-action-btn">
                <i class="bi bi-file-earmark-bar-graph-fill text-info"></i>
                <span class="fw-bold text-slate-700">Historial</span>
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-modern h-100">
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-receipt me-2 text-primary"></i>Ventas Recientes</h6>
                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-light text-primary fw-bold rounded-pill px-3">Ver Todo</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Nº Factura</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th class="pe-4 text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Sale::latest()->limit(5)->get() as $sale)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">#{{ $sale->invoice_number }}</td>
                                    <td class="small">{{ $sale->created_at->format('d/m/Y - H:i') }}</td>
                                    <td class="fw-bold text-dark">${{ number_format($sale->grand_total, 2) }}</td>
                                    <td class="pe-4 text-center">
                                        @if($sale->status == 'completed')
                                            <span class="badge-soft bg-success-subtle text-success border border-success-subtle">
                                                <i class="bi bi-check-circle me-1"></i> Completado
                                            </span>
                                        @else
                                            <span class="badge-soft bg-warning-subtle text-warning border border-warning-subtle">
                                                <i class="bi bi-clock-history me-1"></i> Pendiente
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                            <i class="bi bi-inboxes fs-3 text-muted"></i>
                                        </div>
                                        <p class="mb-0">No hay ventas registradas aún.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-modern h-100 border-top border-danger border-4">
                <div class="p-4 border-bottom text-center bg-danger bg-opacity-10">
                    <h6 class="fw-bold mb-0 text-danger"><i class="bi bi-exclamation-octagon-fill me-2"></i>Alertas de Stock</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse(\App\Models\Product::whereColumn('stock', '<=', 'min_stock')->limit(5)->get() as $product)
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-bottom">
                            <div>
                                <h6 class="mb-1 fw-bold text-dark fs-6">{{ $product->name }}</h6>
                                <small class="text-muted"><i class="bi bi-box me-1"></i> Mínimo requerido: {{ $product->min_stock }}</small>
                            </div>
                            <span class="badge rounded-pill {{ $product->stock < 3 ? 'bg-danger' : 'bg-warning text-dark' }} px-3 py-2 shadow-sm">
                                {{ $product->stock }} disp.
                            </span>
                        </li>
                        @empty
                        <li class="list-group-item text-center py-5 border-0">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-shield-check fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark">Inventario Saludable</h6>
                            <p class="text-muted small mb-0">Todos los productos tienen stock suficiente.</p>
                        </li>
                        @endforelse
                    </ul>
                </div>
                @if(\App\Models\Product::whereColumn('stock', '<=', 'min_stock')->count() > 5)
                <div class="card-footer bg-white text-center border-0 py-3">
                    <a href="{{ route('products.index') }}?filter=low_stock" class="text-danger fw-bold text-decoration-none small">
                        Ver todas las alertas <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection