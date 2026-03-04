@extends('layouts.app')

@section('title', 'Dashboard - Canteen Inventory')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </h1>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card primary h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label text-primary">Total Products</div>
                        <div class="stat-value">{{ $totalProducts }}</div>
                    </div>
                    <i class="bi bi-box fs-1 text-primary opacity-25"></i>
                </div>
                <a href="{{ route('products.index') }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label text-success">Total Suppliers</div>
                        <div class="stat-value">{{ $totalSuppliers }}</div>
                    </div>
                    <i class="bi bi-truck fs-1 text-success opacity-25"></i>
                </div>
                <a href="{{ route('suppliers.index') }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card info h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label text-info">Stock Entries</div>
                        <div class="stat-value">{{ $totalStockEntries }}</div>
                    </div>
                    <i class="bi bi-clipboard-data fs-1 text-info opacity-25"></i>
                </div>
                <a href="{{ route('stock_entries.index') }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label text-warning">Total Delivered</div>
                        <div class="stat-value">{{ $totalStockDelivered }}</div>
                    </div>
                    <i class="bi bi-box-seam fs-1 text-warning opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Stock Entries -->
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Recent Stock Entries</span>
                <a href="{{ route('stock_entries.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Add Entry
                </a>
            </div>
            <div class="card-body p-0">
                @if($recentStockEntries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Product</th>
                                    <th>Supplier</th>
                                    <th class="text-center">Qty</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentStockEntries as $entry)
                                    <tr>
                                        <td>
                                            <a href="{{ route('stock_entries.show', $entry) }}" class="text-decoration-none fw-semibold">
                                                {{ $entry->delivery_reference }}
                                            </a>
                                        </td>
                                        <td>{{ $entry->product->product_name }}</td>
                                        <td>{{ $entry->supplier->supplier_name }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success">+{{ $entry->quantity }}</span>
                                        </td>
                                        <td>{{ $entry->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('stock_entries.index') }}" class="text-decoration-none">
                            View All Stock Entries <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                @else
                    <div class="empty-state py-5">
                        <i class="bi bi-clipboard-data"></i>
                        <h6>No Stock Entries Yet</h6>
                        <p class="small">Start by recording your first stock delivery.</p>
                        <a href="{{ route('stock_entries.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>Add Stock Entry
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-exclamation-triangle me-2"></i>Low Stock Alert</span>
                <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Add
                </a>
            </div>
            <div class="card-body p-0">
                @if($lowStockProducts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($lowStockProducts as $product)
                            <a href="{{ route('products.show', $product) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $product->product_name }}</h6>
                                    <span class="badge {{ $product->current_stock == 0 ? 'bg-danger' : 'bg-warning' }}">
                                        {{ $product->current_stock }} left
                                    </span>
                                </div>
                                <small class="text-muted">Code: {{ $product->product_code }}</small>
                            </a>
                        @endforeach
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('products.index') }}" class="text-decoration-none">
                            View All Products <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                @else
                    <div class="empty-state py-5">
                        <i class="bi bi-check-circle text-success"></i>
                        <h6>All Stock Levels Good</h6>
                        <p class="small">No products are running low on stock.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lightning me-2"></i>Quick Actions
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('products.create') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-box me-2"></i>Add New Product
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('suppliers.create') }}" class="btn btn-outline-success w-100 py-3">
                            <i class="bi bi-truck me-2"></i>Add New Supplier
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('stock_entries.create') }}" class="btn btn-outline-info w-100 py-3">
                            <i class="bi bi-clipboard-data me-2"></i>Add Stock Entry
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
