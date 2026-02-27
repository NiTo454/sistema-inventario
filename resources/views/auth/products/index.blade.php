@extends('layouts.app')

@section('title', 'Gestión de Productos')

@section('content')
<style>
    :root {
        --inv-primary: #0d6efd;
        --inv-bg: #f8fafc;
        --inv-card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .inventory-wrapper { padding: 2rem; background: var(--inv-bg); min-height: 100vh; }
    
    /* KPI Cards */
    .stat-card {
        border: none;
        border-radius: 16px;
        transition: transform 0.2s ease;
    }
    .stat-card:hover { transform: translateY(-5px); }

    /* Estilo de la Tabla */
    .table-card {
        border: none;
        border-radius: 20px;
        box-shadow: var(--inv-card-shadow);
        overflow: hidden;
    }
    
    .product-table thead {
        background-color: #f1f5f9;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }

    .product-table th { border: none; padding: 1.2rem 1rem; color: #64748b; }
    .product-table td { padding: 1.2rem 1rem; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }

    /* Badges de Stock */
    .stock-badge {
        padding: 0.5em 1em;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .btn-action {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
    }
</style>

<div class="inventory-wrapper">
    {{-- Header & KPIs --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Gestión de Productos</h2>
            <p class="text-muted small mb-0">Administración general del catálogo de productos.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold">
            <i class="bi bi-plus-lg me-2"></i> Nuevo Producto
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card shadow-sm bg-white border-start border-primary border-4">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-0">Total Productos</h6>
                        <h4 class="fw-bold mb-0">{{ $products->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @php $lowStock = $products->where('stock', '<=', 5)->where('stock', '>', 0)->count(); @endphp
            <div class="card stat-card shadow-sm bg-white border-start border-warning border-4">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle me-3">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-0">Stock Bajo</h6>
                        <h4 class="fw-bold mb-0">{{ $lowStock }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @php $outOfStock = $products->where('stock', '<=', 0)->count(); @endphp
            <div class="card stat-card shadow-sm bg-white border-start border-danger border-4">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle me-3">
                        <i class="bi bi-x-circle fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-0">Agotados</h6>
                        <h4 class="fw-bold mb-0">{{ $outOfStock }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card table-card shadow-sm">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark">Listado de Inventario</h6>
            <div class="input-group w-25">
                <span class="input-group-text bg-light border-end-0 text-muted small"><i class="bi bi-search"></i></span>
                <input type="text" id="productSearch" class="form-control bg-light border-start-0 shadow-none form-control-sm" placeholder="Buscar...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table product-table mb-0" id="inventoryTable">
                    <thead>
                        <tr>
                            <th class="ps-4">Código / Nombre</th>
                            <th>Descripción</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Stock</th>
                            <th>Categoría / Marca</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $product->name }}</div>
                                <div class="text-muted small" style="font-size: 0.75rem;">{{ $product->code }}</div>
                            </td>
                            <td class="text-muted small text-truncate" style="max-width: 200px;">
                                {{ $product->description }}
                            </td>
                            <td class="text-center fw-bold text-dark">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="text-center">
                                @if($product->stock <= 0)
                                    <span class="stock-badge bg-danger bg-opacity-10 text-danger">Agotado</span>
                                @elseif($product->stock <= 5)
                                    <span class="stock-badge bg-warning bg-opacity-10 text-warning">{{ $product->stock }}</span>
                                @else
                                    <span class="stock-badge bg-success bg-opacity-10 text-success">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">{{ $product->category }}</div>
                                <div class="text-muted small" style="font-size: 0.75rem;">{{ $product->brand }}</div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('products.show', $product) }}" class="btn-action btn btn-outline-info border-0 bg-info bg-opacity-10 text-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" class="btn-action btn btn-outline-warning border-0 bg-warning bg-opacity-10 text-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn btn-outline-danger border-0 bg-danger bg-opacity-10 text-danger"
                                                onclick="return confirm('¿Está seguro de eliminar este producto?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('productSearch').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#inventoryTable tbody tr');
        
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>
@endsection
