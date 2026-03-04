@extends('layouts.app')

@section('title', 'Edit Product - Canteen Inventory')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">
                <i class="bi bi-box me-2"></i>Edit Product
            </h1>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil-square me-2"></i>Edit Product Information
            </div>
            <div class="card-body">
                <form action="{{ route('products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="product_code" class="form-label">Product Code <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('product_code') is-invalid @enderror" 
                               id="product_code" 
                               name="product_code" 
                               value="{{ old('product_code', $product->product_code) }}" 
                               placeholder="Enter unique product code"
                               required>
                        @error('product_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('product_name') is-invalid @enderror" 
                               id="product_name" 
                               name="product_name" 
                               value="{{ old('product_name', $product->product_name) }}" 
                               placeholder="Enter product name"
                               required>
                        @error('product_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price" class="form-label">Price (₱) <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control @error('price') is-invalid @enderror" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', $product->price) }}" 
                               placeholder="0.00"
                               step="0.01"
                               min="0"
                               required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Note:</strong> Current stock ({{ $product->current_stock }}) can only be modified through stock entries.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Update Product
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
