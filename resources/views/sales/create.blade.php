@extends('layouts.app')

@section('title', 'Registrar Venta')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-cart-plus-fill me-2"></i>Nueva Transacción de Venta
                    </h5>
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i> Volver al listado
                    </a>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <div class="d-flex">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    <strong>¡Atención!</strong> Por favor revisa los siguientes campos:
                                    <ul class="mb-0 mt-1">
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
                            {{-- Columna Izquierda: Selección --}}
                            <div class="col-md-7">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <h6 class="fw-bold mb-3">Detalles del Producto</h6>
                                    
                                    {{-- Selección de Producto --}}
                                    <div class="mb-4">
                                        <label for="product_id" class="form-label text-muted small fw-bold">SELECCIONAR PRODUCTO</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-box-seam"></i></span>
                                            <select name="products[0][id]" id="product_id" 
                                                    class="form-select border-start-0 shadow-none @error('products.0.id') is-invalid @enderror" required>
                                                <option value="" data-price="0">Buscar producto...</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                                        {{ $product->name }} (Stock: {{ $product->stock }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Cantidad --}}
                                    <div class="mb-0">
                                        <label for="quantity" class="form-label text-muted small fw-bold">CANTIDAD A VENDER</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-plus-minus"></i></span>
                                            <input type="number" name="products[0][quantity]" id="quantity" 
                                                   class="form-control border-start-0 shadow-none @error('products.0.quantity') is-invalid @enderror" 
                                                   min="1" placeholder="0" required>
                                        </div>
                                        <div id="stock-warning" class="text-danger small mt-1 d-none">
                                            <i class="bi bi-exclamation-circle"></i> La cantidad supera el stock disponible.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Columna Derecha: Resumen --}}
                            <div class="col-md-5">
                                <div class="card border-primary h-100">
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="fw-bold mb-4">Resumen de Venta</h6>
                                        
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Precio Unitario:</span>
                                            <span id="unit-price" class="fw-bold">$0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-4">
                                            <span class="text-muted">Cantidad:</span>
                                            <span id="display-quantity" class="fw-bold">0</span>
                                        </div>
                                        
                                        <hr class="mt-auto">
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <span class="h5 mb-0 text-muted">Total a Pagar:</span>
                                            <span id="total-price" class="h3 mb-0 text-success fw-bold">$0.00</span>
                                        </div>

                                        <button type="submit" class="btn btn-success btn-lg py-3 rounded-3 shadow-sm w-100">
                                            <i class="bi bi-check2-circle me-2"></i>Confirmar Venta
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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