@extends('layouts.app')

@section('title', 'Products - Canteen Inventory')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-box me-2"></i>Products
    </h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add New Product
    </a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list me-2"></i>All Products</span>
        <span class="badge bg-primary">{{ $products->total() }} Total</span>
    </div>
    <div class="card-body p-0">
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th class="text-end">Price</th>
                            <th class="text-center">Current Stock</th>
                            <th class="text-center">Stock Entries</th>
                            <th class="text-center">Total Delivered</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ $product->product_code }}</span>
                                </td>
                                <td>{{ $product->product_name }}</td>
                                <td class="text-end">₱{{ number_format($product->price, 2) }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $product->current_stock > 0 ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $product->current_stock }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $product->stock_entries_count }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $product->stock_entries_sum_quantity ?? 0 }}</span>
                                </td>
                                <td class="text-center action-btns">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
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
                {{ $products->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-box"></i>
                <h5>No Products Found</h5>
                <p>Start by adding your first product to the inventory.</p>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Add Product
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
