@extends('layouts.app')

@section('title', 'Suppliers - Canteen Inventory')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-truck me-2"></i>Suppliers
    </h1>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add New Supplier
    </a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list me-2"></i>All Suppliers</span>
        <span class="badge bg-primary">{{ $suppliers->total() }} Total</span>
    </div>
    <div class="card-body p-0">
        @if($suppliers->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Supplier Code</th>
                            <th>Supplier Name</th>
                            <th>Contact Email</th>
                            <th>Contact Number</th>
                            <th class="text-center">Stock Entries</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ $supplier->supplier_code }}</span>
                                </td>
                                <td>{{ $supplier->supplier_name }}</td>
                                <td>
                                    <a href="mailto:{{ $supplier->contact_email }}" class="text-decoration-none">
                                        {{ $supplier->contact_email }}
                                    </a>
                                </td>
                                <td>{{ $supplier->contact_number }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $supplier->stock_entries_count }}</span>
                                </td>
                                <td class="text-center action-btns">
                                    <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-sm btn-info" title="View Profile">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
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
                {{ $suppliers->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-truck"></i>
                <h5>No Suppliers Found</h5>
                <p>Start by adding your first supplier to the system.</p>
                <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Add Supplier
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
