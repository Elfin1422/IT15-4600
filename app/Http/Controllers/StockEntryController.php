<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockEntry;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StockEntryController extends Controller
{
    /**
     * Display a listing of all stock entries.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stockEntries = StockEntry::with(['product', 'supplier'])
            ->latest()
            ->paginate(10);

        return view('stock_entries.index', compact('stockEntries'));
    }

    /**
     * Show the form for creating a new stock entry.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $products = Product::orderBy('product_name')->get();
        $suppliers = Supplier::orderBy('supplier_name')->get();

        return view('stock_entries.create', compact('products', 'suppliers'));
    }

    /**
     * Store a newly created stock entry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'delivery_reference' => [
                'required',
                'string',
                'max:255',
                Rule::unique('stock_entries', 'delivery_reference'),
            ],
        ], [
            'product_id.required' => 'Please select a product.',
            'product_id.exists' => 'The selected product does not exist.',
            'supplier_id.required' => 'Please select a supplier.',
            'supplier_id.exists' => 'The selected supplier does not exist.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be a whole number.',
            'quantity.min' => 'The quantity must be greater than zero.',
            'delivery_reference.required' => 'The delivery reference is required.',
            'delivery_reference.unique' => 'This delivery reference already exists.',
        ]);

        StockEntry::create($validated);

        return redirect()->route('stock_entries.index')
            ->with('success', 'Stock entry created successfully! Product stock has been updated.');
    }

    /**
     * Display the specified stock entry.
     *
     * @param  \App\Models\StockEntry  $stockEntry
     * @return \Illuminate\View\View
     */
    public function show(StockEntry $stockEntry)
    {
        $stockEntry->load(['product', 'supplier']);

        return view('stock_entries.show', compact('stockEntry'));
    }

    /**
     * Show the form for editing the specified stock entry.
     *
     * @param  \App\Models\StockEntry  $stockEntry
     * @return \Illuminate\View\View
     */
    public function edit(StockEntry $stockEntry)
    {
        $products = Product::orderBy('product_name')->get();
        $suppliers = Supplier::orderBy('supplier_name')->get();

        return view('stock_entries.edit', compact('stockEntry', 'products', 'suppliers'));
    }

    /**
     * Update the specified stock entry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockEntry  $stockEntry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, StockEntry $stockEntry)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'delivery_reference' => [
                'required',
                'string',
                'max:255',
                Rule::unique('stock_entries', 'delivery_reference')->ignore($stockEntry->id),
            ],
        ], [
            'product_id.required' => 'Please select a product.',
            'product_id.exists' => 'The selected product does not exist.',
            'supplier_id.required' => 'Please select a supplier.',
            'supplier_id.exists' => 'The selected supplier does not exist.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be a whole number.',
            'quantity.min' => 'The quantity must be greater than zero.',
            'delivery_reference.required' => 'The delivery reference is required.',
            'delivery_reference.unique' => 'This delivery reference already exists.',
        ]);

        // Store old quantity for adjustment
        $oldQuantity = $stockEntry->quantity;
        $newQuantity = $validated['quantity'];
        $quantityDifference = $newQuantity - $oldQuantity;

        // Update the stock entry
        $stockEntry->update($validated);

        // Adjust product stock if quantity changed
        if ($quantityDifference != 0) {
            $product = $stockEntry->product;
            $product->current_stock += $quantityDifference;
            $product->save();
        }

        return redirect()->route('stock_entries.index')
            ->with('success', 'Stock entry updated successfully!');
    }

    /**
     * Remove the specified stock entry from storage.
     *
     * @param  \App\Models\StockEntry  $stockEntry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(StockEntry $stockEntry)
    {
        $stockEntry->delete();

        return redirect()->route('stock_entries.index')
            ->with('success', 'Stock entry deleted successfully! Product stock has been updated.');
    }
}
