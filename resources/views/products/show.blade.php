@extends('layouts.app')

@section('title', $product->product_name . ' - Canteen Inventory')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-box me-2"></i>{{ $product->product_name }}
    </h1>
    <div>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<!-- Product Info Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card primary h-100">
            <div class="card-body">
                <div class="stat-label text-primary">Product Code</div>
                <div class="stat-value">{{ $product->product_code }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card success h-100">
            <div class="card-body">
                <div class="stat-label text-success">Current Stock</div>
                <div class="stat-value">{{ $product->current_stock }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card info h-100">
            <div class="card-body">
                <div class="stat-label text-info">Price</div>
                <div class="stat-value">₱{{ number_format($product->price, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card warning h-100">
            <div class="card-body">
                <div class="stat-label text-warning">Total Delivered</div>
                <div class="stat-value">{{ $product->total_stock_delivered }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Suppliers Section -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-truck me-2"></i>Suppliers Who Delivered This Product
            </div>
            <div class="card-body p-0">
                @if($suppliers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Supplier Code</th>
                                    <th>Supplier Name</th>
                                    <th class="text-center">Total Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                    @php
                                        $totalQty = $supplier->pivot->sum('quantity');
                                    @endphp
                                    <tr>
                                        <td>{{ $supplier->supplier_code }}</td>
                                        <td>
                                            <a href="{{ route('suppliers.show', $supplier) }}" class="text-decoration-none">
                                                {{ $supplier->supplier_name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">
                                                {{ $product->stockEntries->where('supplier_id', $supplier->id)->sum('quantity') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state py-5">
                        <i class="bi bi-truck"></i>
                        <h6>No Suppliers Yet</h6>
                        <p class="small">No stock entries have been recorded for this product.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Stock History Section -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Stock History</span>
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
                                    <th>Supplier</th>
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
                                        <td>{{ $entry->supplier->supplier_name }}</td>
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
                        <h6>No Stock History</h6>
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
