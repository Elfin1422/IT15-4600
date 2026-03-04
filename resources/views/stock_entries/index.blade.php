@extends('layouts.app')

@section('title', 'Stock Entries - Canteen Inventory')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-clipboard-data me-2"></i>Stock Entries
    </h1>
    <a href="{{ route('stock_entries.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Stock Entry
    </a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list me-2"></i>All Stock Entries</span>
        <span class="badge bg-primary">{{ $stockEntries->total() }} Total</span>
    </div>
    <div class="card-body p-0">
        @if($stockEntries->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Delivery Reference</th>
                            <th>Product</th>
                            <th>Supplier</th>
                            <th class="text-center">Quantity</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stockEntries as $entry)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ $entry->delivery_reference }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('products.show', $entry->product) }}" class="text-decoration-none">
                                        {{ $entry->product->product_name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('suppliers.show', $entry->supplier) }}" class="text-decoration-none">
                                        {{ $entry->supplier->supplier_name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">+{{ $entry->quantity }}</span>
                                </td>
                                <td>{{ $entry->created_at->format('M d, Y H:i') }}</td>
                                <td class="text-center action-btns">
                                    <a href="{{ route('stock_entries.show', $entry) }}" class="btn btn-sm btn-info" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('stock_entries.edit', $entry) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('stock_entries.destroy', $entry) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this stock entry? The product stock will be adjusted.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $stockEntries->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-clipboard-data"></i>
                <h5>No Stock Entries Found</h5>
                <p>Start by recording your first stock delivery.</p>
                <a href="{{ route('stock_entries.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Add Stock Entry
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
