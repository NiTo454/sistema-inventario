@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="bi bi-speedometer2"></i> Dashboard
                    <small class="text-muted">Bienvenido, {{ Auth::user()->name }}!</small>
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Sistema de Inventario y Ventas</h5>
                            <p class="card-text mb-0">
                                Rol: <span class="badge bg-light text-primary">{{ ucfirst(Auth::user()->role) }}</span>
                            </p>
                        </div>
                        <div class="avatar-lg">
                            <div class="avatar-title bg-light rounded-circle">
                                <i class="bi bi-person-circle display-5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="text-muted fw-normal mt-0">Total Productos</h5>
                            <h3 class="my-2">{{ \App\Models\Product::count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-box-seam display-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="text-muted fw-normal mt-0">Total Ventas</h5>
                            <h3 class="my-2">{{ \App\Models\Sale::count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-cart-check display-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="text-muted fw-normal mt-0">Stock Bajo</h5>
                            <h3 class="my-2">{{ \App\Models\Product::whereColumn('stock', '<=', 'min_stock')->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-exclamation-triangle display-4 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="text-muted fw-normal mt-0">Usuarios Activos</h5>
                            <h3 class="my-2">{{ \App\Models\User::where('is_active', true)->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people display-4 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(Auth::user()->isAdmin())
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-people me-2"></i> Gestionar Usuarios
                            </a>
                        </div>
                        @endif

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-success w-100">
                                <i class="bi bi-box me-2"></i> Ver Productos
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('sales.create') }}" class="btn btn-outline-warning w-100">
                                <i class="bi bi-cart-plus me-2"></i> Nueva Venta
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('sales.index') }}" class="btn btn-outline-info w-100">
                                <i class="bi bi-receipt me-2"></i> Ver Ventas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Últimas Ventas</h5>
                </div>
                <div class="card-body">
                    @php
                        $latestSales = \App\Models\Sale::with('user')
                            ->latest()
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($latestSales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Factura</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestSales as $sale)
                                    <tr>
                                        <td>{{ $sale->invoice_number }}</td>
                                        <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                                        <td>${{ number_format($sale->grand_total, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $sale->status == 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($sale->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No hay ventas registradas.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Productos con Stock Bajo</h5>
                </div>
                <div class="card-body">
                    @php
                        $lowStockProducts = \App\Models\Product::whereColumn('stock', '<=', 'min_stock')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($lowStockProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Stock</th>
                                        <th>Mínimo</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockProducts as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td class="{{ $product->stock < 5 ? 'text-danger fw-bold' : 'text-warning' }}">
                                            {{ $product->stock }}
                                        </td>
                                        <td>{{ $product->min_stock }}</td>
                                        <td>
                                            <span class="badge bg-{{ $product->stock < 5 ? 'danger' : 'warning' }}">
                                                {{ $product->stock < 5 ? 'Crítico' : 'Bajo' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-success text-center">Todos los productos tienen stock suficiente.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
