@extends('layouts.app')

@section('title', 'Add Product - Canteen Inventory')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">
                <i class="bi bi-box me-2"></i>Add New Product
            </h1>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Product Information
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="product_code" class="form-label">Product Code <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('product_code') is-invalid @enderror" 
                               id="product_code" 
                               name="product_code" 
                               value="{{ old('product_code') }}" 
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
                               value="{{ old('product_name') }}" 
                               placeholder="Enter product name"
                               required>
                        @error('product_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price (₱) <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control @error('price') is-invalid @enderror" 
                               id="price" 
                               name="price" 
                               value="{{ old('price') }}" 
                               placeholder="0.00"
                               step="0.01"
                               min="0"
                               required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="current_stock" class="form-label">Initial Stock</label>
                        <input type="number" 
                               class="form-control @error('current_stock') is-invalid @enderror" 
                               id="current_stock" 
                               name="current_stock" 
                               value="{{ old('current_stock', 0) }}" 
                               placeholder="0"
                               min="0">
                        <div class="form-text">Leave as 0 if starting with no stock.</div>
                        @error('current_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Create Product
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
