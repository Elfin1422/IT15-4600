@extends('layouts.app')

@section('title', $supplier->supplier_name . ' - Canteen Inventory')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-truck me-2"></i>{{ $supplier->supplier_name }}
    </h1>
    <div>
        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<!-- Supplier Info Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card primary h-100">
            <div class="card-body">
                <div class="stat-label text-primary">Supplier Code</div>
                <div class="stat-value">{{ $supplier->supplier_code }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card info h-100">
            <div class="card-body">
                <div class="stat-label text-info">Contact Email</div>
                <div class="stat-value" style="font-size: 1rem;">{{ $supplier->contact_email }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card success h-100">
            <div class="card-body">
                <div class="stat-label text-success">Contact Number</div>
                <div class="stat-value" style="font-size: 1.25rem;">{{ $supplier->contact_number }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card warning h-100">
            <div class="card-body">
                <div class="stat-label text-warning">Products Supplied</div>
                <div class="stat-value">{{ $products->count() }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Products Section -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-box me-2"></i>Products Supplied
            </div>
            <div class="card-body p-0">
                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th class="text-center">Qty Delivered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->product_code }}</td>
                                        <td>
                                            <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                                                {{ $product->product_name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">
                                                {{ $productQuantities[$product->id] ?? 0 }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state py-5">
                        <i class="bi bi-box"></i>
                        <h6>No Products Yet</h6>
                        <p class="small">This supplier hasn't delivered any products yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delivery History Section -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Delivery History</span>
                <a href="{{ route('stock_entries.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Add Entry
                </a>
            </div>
            <div class="card-body p-0">
                @if($stockHistory->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Reference</th>
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stockHistory as $entry)
                                    <tr>
                                        <td>{{ $entry->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('stock_entries.show', $entry) }}" class="text-decoration-none">
                                                {{ $entry->delivery_reference }}
                                            </a>
                                        </td>
                                        <td>{{ $entry->product->product_name }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success">+{{ $entry->quantity }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($stockHistory->hasPages())
                        <div class="card-footer">
                            {{ $stockHistory->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-state py-5">
                        <i class="bi bi-clock-history"></i>
                        <h6>No Delivery History</h6>
                        <p class="small">No stock entries have been recorded yet.</p>
                        <a href="{{ route('stock_entries.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>Add Stock Entry
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
