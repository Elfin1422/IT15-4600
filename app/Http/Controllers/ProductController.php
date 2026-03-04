<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::withCount('stockEntries')
            ->withSum('stockEntries', 'quantity')
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'product_code'),
            ],
            'product_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'current_stock' => ['nullable', 'integer', 'min:0'],
        ], [
            'product_code.required' => 'The product code is required.',
            'product_code.unique' => 'This product code already exists.',
            'product_name.required' => 'The product name is required.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',
            'current_stock.integer' => 'The current stock must be a whole number.',
            'current_stock.min' => 'The current stock cannot be negative.',
        ]);

        // Set default current_stock if not provided
        if (!isset($validated['current_stock'])) {
            $validated['current_stock'] = 0;
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product with suppliers and stock history.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        $product->load(['suppliers', 'stockEntries.supplier']);

        // Get unique suppliers who delivered this product
        $suppliers = $product->suppliers;

        // Get stock history
        $stockHistory = $product->stockEntries()
            ->with('supplier')
            ->latest()
            ->paginate(10);

        return view('products.show', compact('product', 'suppliers', 'stockHistory'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'product_code')->ignore($product->id),
            ],
            'product_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ], [
            'product_code.required' => 'The product code is required.',
            'product_code.unique' => 'This product code already exists.',
            'product_name.required' => 'The product name is required.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // Check if product has stock entries
        if ($product->stockEntries()->count() > 0) {
            return redirect()->route('products.index')
                ->with('error', 'Cannot delete product with existing stock entries!');
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
