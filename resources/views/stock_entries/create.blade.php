@extends('layouts.app')

@section('title', 'Add Stock Entry - Canteen Inventory')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">
                <i class="bi bi-clipboard-data me-2"></i>Add Stock Entry
            </h1>
            <a href="{{ route('stock_entries.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Stock Entry Information
            </div>
            <div class="card-body">
                @if($products->count() == 0 || $suppliers->count() == 0)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> You need to have at least one product and one supplier before creating a stock entry.
                    </div>
                    <div class="d-grid gap-2">
                        @if($products->count() == 0)
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>Add Product First
                            </a>
                        @endif
                        @if($suppliers->count() == 0)
                            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>Add Supplier First
                            </a>
                        @endif
                    </div>
                @else
                    <form action="{{ route('stock_entries.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                            <select class="form-select @error('product_id') is-invalid @enderror" 
                                    id="product_id" 
                                    name="product_id" 
                                    required>
                                <option value="">Select a product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->product_code }} - {{ $product->product_name }} (Stock: {{ $product->current_stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="supplier_id" class="form-label">Supplier <span class="text-danger">*</span></label>
                            <select class="form-select @error('supplier_id') is-invalid @enderror" 
                                    id="supplier_id" 
                                    name="supplier_id" 
                                    required>
                                <option value="">Select a supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->supplier_code }} - {{ $supplier->supplier_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('quantity') is-invalid @enderror" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="{{ old('quantity') }}" 
                                   placeholder="Enter quantity"
                                   min="1"
                                   required>
                            <div class="form-text">Quantity must be greater than zero.</div>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="delivery_reference" class="form-label">Delivery Reference <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('delivery_reference') is-invalid @enderror" 
                                   id="delivery_reference" 
                                   name="delivery_reference" 
                                   value="{{ old('delivery_reference') }}" 
                                   placeholder="Enter unique delivery reference"
                                   required>
                            <div class="form-text">This must be a unique reference number (e.g., DEL-2024-001).</div>
                            @error('delivery_reference')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Note:</strong> When you create this stock entry, the product's current stock will automatically increase by the quantity entered.
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Create Stock Entry
                            </button>
                            <a href="{{ route('stock_entries.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
