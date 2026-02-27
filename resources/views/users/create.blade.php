@extends('layouts.app')

@section('title', 'Añadir Producto')

@section('content')
<style>
    :root {
        --inv-primary: #059669; /* Verde Esmeralda */
        --inv-secondary: #064e3b;
        --inv-bg: #f8fafc;
        --inv-card-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .create-container { padding: 2rem; background: var(--inv-bg); min-height: 100vh; font-family: 'Inter', sans-serif; }
    
    /* Card Animada */
    .form-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: var(--inv-card-shadow);
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    /* Header con Estilo Glassmorphism */
    .form-header-modern {
        background: linear-gradient(135deg, var(--inv-primary) 0%, var(--inv-secondary) 100%);
        padding: 2rem;
        color: white;
        position: relative;
    }

    /* Estilo de Inputs "Floating-ish" */
    .input-wrapper {
        background: #f1f5f9;
        border-radius: 12px;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
        border: 2px solid transparent;
    }

    .input-wrapper:focus-within {
        background: white;
        border-color: var(--inv-primary);
        box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
    }

    .input-wrapper label {
        font-size: 0.7rem;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 0;
    }

    .input-wrapper input, .input-wrapper textarea, .input-wrapper select {
        background: transparent;
        border: none;
        padding: 0.2rem 0;
        font-weight: 600;
        width: 100%;
        outline: none;
    }

    /* Vista Previa */
    .preview-card {
        border-radius: 20px;
        background: white;
        border: 2px dashed #e2e8f0;
        padding: 1.5rem;
        position: sticky;
        top: 2rem;
    }

    .btn-generate {
        font-size: 0.75rem;
        padding: 0.2rem 0.6rem;
        border-radius: 8px;
        text-transform: none;
    }

    .btn-create-pro {
        background: var(--inv-primary);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 14px;
        font-weight: 700;
        box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.3);
        transition: all 0.2s;
    }

    .btn-create-pro:hover {
        background: var(--inv-secondary);
        transform: translateY(-2px);
        color: white;
    }
</style>

<div class="create-container">
    <div class="row justify-content-center">
        <div class="col-xl-11">
            <div class="row">
                {{-- Columna del Formulario --}}
                <div class="col-lg-8 mb-4">
                    <div class="form-card">
                        <div class="form-header-modern">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 backdrop-blur">
                                        <i class="bi bi-plus-square-fill fs-2 text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0 fw-bold">Nuevo Producto</h3>
                                        <p class="mb-0 text-white-50">Ingresa la información técnica para el inventario.</p>
                                    </div>
                                </div>
                                <a href="{{ route('products.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4 p-md-5">
                            <form method="POST" action="{{ route('products.store') }}" id="productForm">
                                @csrf
                                
                                <div class="row g-4">
                                    <div class="col-md-5">
                                        <div class="input-wrapper">
                                            <div class="d-flex justify-content-between">
                                                <label for="code">Código / SKU</label>
                                                <button type="button" class="btn btn-link btn-generate p-0 text-primary fw-bold" onclick="generateSKU()">Generar</button>
                                            </div>
                                            <input type="text" name="code" id="code" value="{{ old('code') }}" required placeholder="AUT-001">
                                        </div>
                                        @error('code') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-7">
                                        <div class="input-wrapper">
                                            <label for="name">Nombre Comercial</label>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Ej: Laptop Gamer Nitro 5">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="input-wrapper">
                                            <label for="description">Descripción Detallada</label>
                                            <textarea name="description" id="description" rows="2" placeholder="Describe brevemente el producto...">{{ old('description') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <label for="price">Precio de Venta</label>
                                            <div class="d-flex align-items-center">
                                                <span class="me-1 text-muted">$</span>
                                                <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <label for="stock">Stock Inicial</label>
                                            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required placeholder="0">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <label for="category">Categoría</label>
                                            <input type="text" name="category" id="category" value="{{ old('category') }}" placeholder="Ej: Tecnología">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <label for="brand">Marca</label>
                                            <input type="text" name="brand" id="brand" value="{{ old('brand') }}" placeholder="Ej: Acer">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 d-flex gap-3">
                                    <button type="submit" class="btn btn-create-pro px-5">
                                        <i class="bi bi-cloud-arrow-up-fill me-2"></i> Registrar Producto
                                    </button>
                                    <a href="{{ route('products.index') }}" class="btn btn-light border-0 px-4 py-3 rounded-4 fw-bold text-muted">Descartar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Columna de Vista Previa --}}
                <div class="col-lg-4">
                    <div class="preview-card shadow-sm">
                        <h6 class="text-uppercase fw-800 text-muted mb-4 small">Vista Previa de Tarjeta</h6>
                        
                        <div class="product-preview-box text-center">
                            <div class="bg-light rounded-4 mb-3 d-flex align-items-center justify-content-center" style="height: 180px; border: 1px solid #f1f5f9;">
                                <i class="bi bi-image text-muted opacity-25" style="font-size: 4rem;"></i>
                            </div>
                            <h5 id="preview-name" class="fw-bold text-dark mb-1">Nombre del Producto</h5>
                            <p id="preview-category" class="text-muted small mb-3">Categoría</p>
                            
                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-4">
                                <div class="text-start">
                                    <small class="text-muted d-block">Precio</small>
                                    <span id="preview-price" class="h5 fw-bold text-success mb-0">$ 0.00</span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Stock</small>
                                    <span id="preview-stock" class="badge bg-dark rounded-pill">0 uds</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-3 rounded-4 border bg-info bg-opacity-10 text-info small">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Este producto será visible inmediatamente en el módulo de ventas tras su registro.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function generateSKU() {
        const codeInput = document.getElementById('code');
        const randomStr = Math.random().toString(36).substring(2, 5).toUpperCase();
        const randomNum = Math.floor(100 + Math.random() * 900);
        codeInput.value = `PROD-${randomStr}${randomNum}`;
        // Trigger visual update
        codeInput.dispatchEvent(new Event('input'));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const priceInput = document.getElementById('price');
        const stockInput = document.getElementById('stock');
        const categoryInput = document.getElementById('category');

        const pName = document.getElementById('preview-name');
        const pPrice = document.getElementById('preview-price');
        const pStock = document.getElementById('preview-stock');
        const pCat = document.getElementById('preview-category');

        // Escuchadores para actualizar la vista previa
        nameInput.addEventListener('input', (e) => pName.innerText = e.target.value || 'Nombre del Producto');
        priceInput.addEventListener('input', (e) => pPrice.innerText = `$ ${parseFloat(e.target.value || 0).toFixed(2)}`);
        stockInput.addEventListener('input', (e) => pStock.innerText = `${e.target.value || 0} uds`);
        categoryInput.addEventListener('input', (e) => pCat.innerText = e.target.value || 'Categoría');
    });
</script>
@endpush