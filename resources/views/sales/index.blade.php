@extends('layouts.app')

@section('title', 'Gestión de Ventas')

@section('content')
<div class="container py-4">
    {{-- Encabezado y Botón de Acción --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Historial de Ventas</h1>
            <p class="text-muted small mb-0">Monitorea y gestiona las transacciones de tu negocio.</p>
        </div>
        <a href="{{ route('sales.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i>Nueva Venta
        </a>
    </div>

    {{-- Tarjetas de Resumen (KPIs) --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 small mb-1">Total de Ventas</h6>
                            <h3 class="mb-0 fw-bold">${{ number_format($sales->sum('total'), 2) }}</h3>
                        </div>
                        <i class="bi bi-cash-stack h1 mb-0 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-white">
                <div class="card-body text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small mb-1">Transacciones</h6>
                            <h3 class="mb-0 fw-bold text-primary">{{ $sales->count() }}</h3>
                        </div>
                        <i class="bi bi-receipt-cutoff h1 mb-0 text-light"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small mb-1">Última Actividad</h6>
                            <h3 class="mb-0 fs-5 fw-bold">{{ $sales->first() ? $sales->first()->created_at->diffForHumans() : '--' }}</h3>
                        </div>
                        <i class="bi bi-clock-history h1 mb-0 text-light"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas de Éxito --}}
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- Tabla Principal con Filtro --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Transacciones</h6>
            <div class="input-group input-group-sm w-25">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" id="salesSearch" class="form-control bg-light border-start-0 shadow-none" placeholder="Buscar venta...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="salesTable">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">ID Venta</th>
                            <th>Vendedor</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">#{{ $sale->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2 bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                        <i class="bi bi-person small"></i>
                                    </div>
                                    <span>{{ $sale->user ? $sale->user->name : 'Eliminado' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-success">${{ number_format($sale->total, 2) }}</span>
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'completed' => 'success',
                                        'pending' => 'warning',
                                        'cancelled' => 'danger'
                                    ][$sale->status] ?? 'secondary';
                                @endphp
                                <span class="badge rounded-pill bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} px-3">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ $sale->created_at->format('d M, Y') }}<br>
                                <span class="text-light-emphasis">{{ $sale->created_at->format('H:i A') }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-outline-info btn-sm rounded-circle me-1" title="Ver Detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    {{-- Botón para imprimir ticket opcional --}}
                                    <button class="btn btn-outline-secondary btn-sm rounded-circle" onclick="window.print()" title="Imprimir Ticket">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox h1 d-block mb-3 opacity-25"></i>
                                No se encontraron registros de ventas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script para Filtro de Búsqueda Dinámico --}}
<script>
    document.getElementById('salesSearch').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#salesTable tbody tr');
        
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>
@endsection