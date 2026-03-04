@extends('layouts.app')

@section('title', 'Stock Entry - ' . $stockEntry->delivery_reference)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-clipboard-data me-2"></i>Stock Entry Details
    </h1>
    <div>
        <a href="{{ route('stock_entries.edit', $stockEntry) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('stock_entries.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Stock Entry Information
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="fw-semibold" style="width: 40%;">Delivery Reference</td>
                            <td>
                                <span class="badge bg-primary fs-6">{{ $stockEntry->delivery_reference }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Product</td>
                            <td>
                                <a href="{{ route('products.show', $stockEntry->product) }}" class="text-decoration-none">
                                    <i class="bi bi-box me-1"></i>
                                    {{ $stockEntry->product->product_name }}
                                </a>
                                <br>
                                <small class="text-muted">Code: {{ $stockEntry->product->product_code }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Supplier</td>
                            <td>
                                <a href="{{ route('suppliers.show', $stockEntry->supplier) }}" class="text-decoration-none">
                                    <i class="bi bi-truck me-1"></i>
                                    {{ $stockEntry->supplier->supplier_name }}
                                </a>
                                <br>
                                <small class="text-muted">Code: {{ $stockEntry->supplier->supplier_code }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Quantity</td>
                            <td>
                                <span class="badge bg-success fs-6">+{{ $stockEntry->quantity }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Created At</td>
                            <td>{{ $stockEntry->created_at->format('F d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Last Updated</td>
                            <td>{{ $stockEntry->updated_at->format('F d, Y h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>

                <hr>

                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Stock Impact:</strong> This entry added {{ $stockEntry->quantity }} units to {{ $stockEntry->product->product_name }}. 
                    Current stock is now {{ $stockEntry->product->current_stock }} units.
                </div>
            </div>
            <div class="card-footer">
                <form action="{{ route('stock_entries.destroy', $stockEntry) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this stock entry? The product stock will be adjusted.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash me-1"></i>Delete Stock Entry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
