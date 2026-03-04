@extends('layouts.app')

@section('title', 'Edit Stock Entry - Canteen Inventory')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">
                <i class="bi bi-clipboard-data me-2"></i>Edit Stock Entry
            </h1>
            <a href="{{ route('stock_entries.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil-square me-2"></i>Edit Stock Entry Information
            </div>
            <div class="card-body">
                <form action="{{ route('stock_entries.update', $stockEntry) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                        <select class="form-select @error('product_id') is-invalid @enderror" 
                                id="product_id" 
                                name="product_id" 
                                required>
                            <option value="">Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id', $stockEntry->product_id) == $product->id ? 'selected' : '' }}>
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
                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $stockEntry->supplier_id) == $supplier->id ? 'selected' : '' }}>
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
                               value="{{ old('quantity', $stockEntry->quantity) }}" 
                               placeholder="Enter quantity"
                               min="1"
                               required>
                        <div class="form-text">Current quantity: {{ $stockEntry->quantity }}. Changing this will adjust the product stock accordingly.</div>
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
                               value="{{ old('delivery_reference', $stockEntry->delivery_reference) }}" 
                               placeholder="Enter unique delivery reference"
                               required>
                        @error('delivery_reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> Changing the quantity will automatically adjust the product's current stock. Make sure this is intended.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Update Stock Entry
                        </button>
                        <a href="{{ route('stock_entries.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
