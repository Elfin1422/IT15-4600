<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of all suppliers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $suppliers = Supplier::withCount('stockEntries')
            ->latest()
            ->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new supplier.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created supplier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('suppliers', 'supplier_code'),
            ],
            'supplier_name' => ['required', 'string', 'max:255'],
            'contact_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('suppliers', 'contact_email'),
            ],
            'contact_number' => ['required', 'string', 'max:255'],
        ], [
            'supplier_code.required' => 'The supplier code is required.',
            'supplier_code.unique' => 'This supplier code already exists.',
            'supplier_name.required' => 'The supplier name is required.',
            'contact_email.required' => 'The contact email is required.',
            'contact_email.email' => 'Please enter a valid email address.',
            'contact_email.unique' => 'This email is already registered.',
            'contact_number.required' => 'The contact number is required.',
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully!');
    }

    /**
     * Display the specified supplier with products and quantities.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\View\View
     */
    public function show(Supplier $supplier)
    {
        $supplier->load(['products', 'stockEntries.product']);

        // Get all products supplied by this supplier
        $products = $supplier->products;

        // Get quantities delivered per product
        $productQuantities = [];
        foreach ($products as $product) {
            $productQuantities[$product->id] = $supplier->getQuantityDeliveredForProduct($product->id);
        }

        // Get stock entries history
        $stockHistory = $supplier->stockEntries()
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('suppliers.show', compact('supplier', 'products', 'productQuantities', 'stockHistory'));
    }

    /**
     * Show the form for editing the specified supplier.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\View\View
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified supplier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'supplier_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('suppliers', 'supplier_code')->ignore($supplier->id),
            ],
            'supplier_name' => ['required', 'string', 'max:255'],
            'contact_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('suppliers', 'contact_email')->ignore($supplier->id),
            ],
            'contact_number' => ['required', 'string', 'max:255'],
        ], [
            'supplier_code.required' => 'The supplier code is required.',
            'supplier_code.unique' => 'This supplier code already exists.',
            'supplier_name.required' => 'The supplier name is required.',
            'contact_email.required' => 'The contact email is required.',
            'contact_email.email' => 'Please enter a valid email address.',
            'contact_email.unique' => 'This email is already registered.',
            'contact_number.required' => 'The contact number is required.',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated successfully!');
    }

    /**
     * Remove the specified supplier from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Supplier $supplier)
    {
        // Check if supplier has stock entries
        if ($supplier->stockEntries()->count() > 0) {
            return redirect()->route('suppliers.index')
                ->with('error', 'Cannot delete supplier with existing stock entries!');
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully!');
    }
}
