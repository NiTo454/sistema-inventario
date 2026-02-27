@extends('layouts.app')

@section('title', 'Factura #' . ($sale->invoice_number ?? $sale->id))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            {{-- Botones de Acción Superiores (Solo se ven en pantalla) --}}
            <div class="d-flex justify-content-between align-items-center mb-4 no-print">
                <a href="{{ route('sales.index') }}" class="btn btn-link text-decoration-none text-muted p-0">
                    <i class="bi bi-chevron-left"></i> Volver al historial
                </a>
                <div class="d-flex gap-2">
                    <button onclick="window.print()" class="btn btn-primary shadow-sm px-4">
                        <i class="bi bi-printer-fill me-2"></i>Imprimir Factura
                    </button>
                    {{-- Botón opcional para enviar por correo --}}
                    <button class="btn btn-outline-secondary shadow-sm">
                        <i class="bi bi-envelope"></i>
                    </button>
                </div>
            </div>

            {{-- Contenedor de la Factura --}}
            <div class="card border-0 shadow-lg overflow-hidden invoice-container">
                {{-- Barra Lateral de Color según Estado --}}
                <div class="bg-{{ $sale->status === 'completed' ? 'success' : 'warning' }}" style="height: 6px;"></div>

                <div class="card-body p-5">
                    {{-- Encabezado: Logo y Número de Factura --}}
                    <div class="d-flex justify-content-between align-items-start mb-5">
                        <div>
                            <h2 class="fw-bold text-primary mb-1">MI EMPRESA S.A.</h2>
                            <p class="text-muted small mb-0">NIT: 123.456.789-0<br>Calle Falsa 123, Ciudad<br>Tel: (123) 456-7890</p>
                        </div>
                        <div class="text-end">
                            <h3 class="text-uppercase fw-light text-muted mb-0">Factura</h3>
                            <h4 class="fw-bold mb-1">#{{ $sale->invoice_number ?? str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</h4>
                            <span class="badge rounded-pill bg-{{ $sale->status === 'completed' ? 'success' : 'warning' }} bg-opacity-10 text-{{ $sale->status === 'completed' ? 'success' : 'warning' }} px-3">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </div>
                    </div>

                    <hr class="my-5 opacity-10">

                    {{-- Bloques de Información --}}
                    <div class="row mb-5">
                        <div class="col-sm-4 mb-4 mb-sm-0">
                            <h6 class="text-muted text-uppercase small fw-bold mb-3">Vendido por:</h6>
                            <p class="mb-1 fw-bold">{{ $sale->user->name ?? 'Sistema' }}</p>
                            <p class="text-muted small mb-0">{{ $sale->user->email ?? '' }}</p>
                        </div>
                        <div class="col-sm-4 mb-4 mb-sm-0">
                            <h6 class="text-muted text-uppercase small fw-bold mb-3">Cliente:</h6>
                            <p class="mb-1 fw-bold">{{ $sale->customer->name ?? 'Consumidor Final' }}</p>
                            <p class="text-muted small mb-0">{{ $sale->customer->phone ?? 'Sin teléfono' }}</p>
                        </div>
                        <div class="col-sm-4 text-sm-end">
                            <h6 class="text-muted text-uppercase small fw-bold mb-3">Fecha de Emisión:</h6>
                            <p class="mb-1 fw-bold">{{ $sale->created_at->format('d \d\e F, Y') }}</p>
                            <p class="text-muted small mb-0">{{ $sale->created_at->format('h:i A') }}</p>
                        </div>
                    </div>

                    {{-- Tabla de Productos --}}
                    <div class="table-responsive mb-5">
                        <table class="table table-borderless">
                            <thead class="border-bottom border-top">
                                <tr>
                                    <th class="py-3 text-muted small text-uppercase" style="width: 50%">Descripción</th>
                                    <th class="py-3 text-center text-muted small text-uppercase">Cant.</th>
                                    <th class="py-3 text-end text-muted small text-uppercase">Precio Unit.</th>
                                    <th class="py-3 text-end text-muted small text-uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="border-bottom">
                                @foreach($sale->products as $product)
                                <tr>
                                    <td class="py-4">
                                        <div class="fw-bold text-dark">{{ $product->name }}</div>
                                        <div class="text-muted small">SKU: {{ $product->code }}</div>
                                    </td>
                                    <td class="py-4 text-center">{{ $product->pivot->quantity }}</td>
                                    <td class="py-4 text-end text-muted">${{ number_format($product->pivot->price_at_sale, 2) }}</td>
                                    <td class="py-4 text-end fw-bold">${{ number_format($product->pivot->quantity * $product->pivot->price_at_sale, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Resumen de Totales --}}
                    <div class="row justify-content-end">
                        <div class="col-md-5 col-lg-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal:</span>
                                <span class="fw-bold">${{ number_format($sale->subtotal ?? ($sale->total / 1.16), 2) }}</span>
                            </div>
                            @if(($sale->tax ?? 0) > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">IVA (16%):</span>
                                <span class="fw-bold">${{ number_format($sale->tax, 2) }}</span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <span class="h5 mb-0 fw-bold">TOTAL:</span>
                                <span class="h4 mb-0 fw-bold text-primary">${{ number_format($sale->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Nota al pie --}}
                    <div class="mt-5 pt-5 border-top text-center">
                        <p class="text-muted small italic">Gracias por su compra. Esta es una factura generada electrónicamente.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos generales para pantalla */
    body { background-color: #f8f9fa; }
    .invoice-container { border-radius: 15px; }
    
    /* Estilos específicos para Impresión */
    @media print {
        .no-print, .navbar, footer { display: none !important; }
        body { background-color: white !important; }
        .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        .card-body { padding: 0 !important; }
        .text-primary { color: black !important; }
        .invoice-container { border-radius: 0 !important; }
        @page { margin: 1.5cm; }
    }
</style>
@endsection