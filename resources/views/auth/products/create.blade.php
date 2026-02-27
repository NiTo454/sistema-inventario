@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="container py-5">
    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Crear Nuevo Producto</h1>
            <p class="text-muted mb-0">Rellena los campos para añadir un item al inventario.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Volver al listado
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf

                        <div class="row g-4">
                            {{-- Código del Producto --}}
                            <div class="col-md-6">
                                <label for="code" class="form-label fw-bold text-secondary small">CÓDIGO (SKU)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-upc-scan text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-0 shadow-none @error('code') is-invalid @enderror"
                                           id="code" name="code" value="{{ old('code') }}" required>
                                </div>
                                @error('code')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nombre --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold text-secondary small">NOMBRE DEL PRODUCTO</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-box-seam text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-0 shadow-none @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="col-12">
                                <label for="description" class="form-label fw-bold text-secondary small">DESCRIPCIÓN</label>
                                <textarea class="form-control bg-light border-0 shadow-none @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Precio --}}
                            <div class="col-md-4">
                                <label for="price" class="form-label fw-bold text-secondary small">PRECIO DE VENTA</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-currency-dollar text-muted"></i></span>
                                    <input type="number" step="0.01" class="form-control bg-light border-0 shadow-none @error('price') is-invalid @enderror"
                                           id="price" name="price" value="{{ old('price') }}" required>
                                </div>
                                @error('price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Stock --}}
                            <div class="col-md-4">
                                <label for="stock" class="form-label fw-bold text-secondary small">STOCK INICIAL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-boxes text-muted"></i></span>
                                    <input type="number" class="form-control bg-light border-0 shadow-none @error('stock') is-invalid @enderror"
                                           id="stock" name="stock" value="{{ old('stock') }}" required>
                                </div>
                                @error('stock')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Stock Mínimo --}}
                            <div class="col-md-4">
                                <label for="min_stock" class="form-label fw-bold text-secondary small">STOCK MÍNIMO</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-exclamation-triangle text-muted"></i></span>
                                    <input type="number" class="form-control bg-light border-0 shadow-none @error('min_stock') is-invalid @enderror"
                                           id="min_stock" name="min_stock" value="{{ old('min_stock', 0) }}" required>
                                </div>
                                @error('min_stock')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Categoría --}}
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-bold text-secondary small">CATEGORÍA</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-0 shadow-none @error('category') is-invalid @enderror"
                                           id="category" name="category" value="{{ old('category') }}">
                                </div>
                                @error('category')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Marca --}}
                            <div class="col-md-6">
                                <label for="brand" class="form-label fw-bold text-secondary small">MARCA</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-building text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-0 shadow-none @error('brand') is-invalid @enderror"
                                           id="brand" name="brand" value="{{ old('brand') }}">
                                </div>
                                @error('brand')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 shadow-sm fw-bold">
                                <i class="bi bi-check-circle-fill me-2"></i>Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection