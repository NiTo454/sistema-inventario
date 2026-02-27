@extends('layouts.app')

@section('title', 'Registrar Venta')

@section('content')
<div class="container py-5">
    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Nueva Venta</h1>
            <p class="text-muted mb-0">Complete los detalles para registrar una transacción.</p>
        </div>
        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div>
                            <strong>¡Atención!</strong> Revisa los siguientes errores:
                            <ul class="mb-0 mt-1 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('sales.store') }}" method="POST" id="sale-form">
                @csrf
                <div class="row g-4">
                    {{-- Panel de Selección --}}
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                                <h5 class="fw-bold text-primary mb-0"><i class="bi bi-cart3 me-2"></i>Detalles del Producto</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <label for="product_id" class="form-label fw-bold text-secondary small">PRODUCTO</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                                        <select name="products[0][id]" id="product_id" 
                                                class="form-select bg-light border-0 shadow-none @error('products.0.id') is-invalid @enderror" required>
                                            <option value="" data-price="0">Seleccionar producto...</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                                    {{ $product->name }} (Stock: {{ $product->stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="quantity" class="form-label fw-bold text-secondary small">CANTIDAD</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-123 text-muted"></i></span>
                                            <input type="number" name="products[0][quantity]" id="quantity" 
                                                   class="form-control bg-light border-0 shadow-none fw-bold @error('products.0.quantity') is-invalid @enderror" 
                                                   min="1" placeholder="0" required>
                                        </div>
                                        <div id="stock-warning" class="text-danger small mt-2 d-none fw-bold">
                                            <i class="bi bi-exclamation-circle-fill"></i> Stock insuficiente.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-secondary small">PRECIO UNITARIO</label>
                                        <div class="p-3 bg-light rounded-3 text-end">
                                            <span id="unit-price" class="fw-bold fs-5 text-dark">$0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Panel de Resumen --}}
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
                            <div class="card-body p-4 d-flex flex-column">
                                <h5 class="fw-bold mb-4 border-bottom border-white border-opacity-25 pb-3">Resumen de Venta</h5>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-white-50">Cantidad Items</span>
                                    <span id="display-quantity" class="fs-5 fw-bold">0</span>
                                </div>
                                
                                <div class="mt-auto pt-4">
                                    <div class="text-white-50 small text-uppercase fw-bold mb-1">Total a Pagar</div>
                                    <div class="display-5 fw-bold mb-4" id="total-price">$0.00</div>
                                    
                                    <button type="submit" class="btn btn-light text-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                                        <i class="bi bi-check-lg me-2"></i>Confirmar Venta
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script para cálculo dinámico --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const unitPriceSpan = document.getElementById('unit-price');
        const totalPriceSpan = document.getElementById('total-price');
        const displayQtySpan = document.getElementById('display-quantity');
        const stockWarning = document.getElementById('stock-warning');

        function calculate() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const qty = parseInt(quantityInput.value) || 0;

            // Mostrar precio unitario
            unitPriceSpan.innerText = `$${price.toFixed(2)}`;
            displayQtySpan.innerText = qty;

            // Calcular total
            const total = price * qty;
            totalPriceSpan.innerText = `$${total.toFixed(2)}`;

            // Validar stock visualmente
            if (qty > stock) {
                stockWarning.classList.remove('d-none');
                quantityInput.classList.add('is-invalid');
            } else {
                stockWarning.classList.add('d-none');
                quantityInput.classList.remove('is-invalid');
            }
        }

        productSelect.addEventListener('change', calculate);
        quantityInput.addEventListener('input', calculate);
    });
</script>
@endsection