@extends('layouts.app')

@section('title', 'Add Supplier - Canteen Inventory')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">
                <i class="bi bi-truck me-2"></i>Add New Supplier
            </h1>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Supplier Information
            </div>
            <div class="card-body">
                <form action="{{ route('suppliers.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="supplier_code" class="form-label">Supplier Code <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('supplier_code') is-invalid @enderror" 
                               id="supplier_code" 
                               name="supplier_code" 
                               value="{{ old('supplier_code') }}" 
                               placeholder="Enter unique supplier code"
                               required>
                        @error('supplier_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="supplier_name" class="form-label">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('supplier_name') is-invalid @enderror" 
                               id="supplier_name" 
                               name="supplier_name" 
                               value="{{ old('supplier_name') }}" 
                               placeholder="Enter supplier name"
                               required>
                        @error('supplier_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Contact Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control @error('contact_email') is-invalid @enderror" 
                               id="contact_email" 
                               name="contact_email" 
                               value="{{ old('contact_email') }}" 
                               placeholder="supplier@example.com"
                               required>
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('contact_number') is-invalid @enderror" 
                               id="contact_number" 
                               name="contact_number" 
                               value="{{ old('contact_number') }}" 
                               placeholder="Enter contact number"
                               required>
                        @error('contact_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Create Supplier
                        </button>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
