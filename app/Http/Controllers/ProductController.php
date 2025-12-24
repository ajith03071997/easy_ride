<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('productCategory')->latest()->get();
        $productCategories = ProductCategory::all();
        return view('products.index', compact('products', 'productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategories = ProductCategory::all();
        return view('products.create', compact('productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'cost_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'has_stock' => 'boolean',
            'opening_quantity' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        
        // Handle checkbox - if not checked, set to false
        $data['has_stock'] = $request->has('has_stock') ? true : false;
        
        // Set current_quantity to opening_quantity if has_stock is true
        if ($data['has_stock'] && $request->opening_quantity) {
            $data['current_quantity'] = $request->opening_quantity;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $productCategories = ProductCategory::all();
        return view('products.edit', compact('product', 'productCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'cost_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'has_stock' => 'boolean',
            'opening_quantity' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        
        // Handle checkbox - if not checked, set to false
        $data['has_stock'] = $request->has('has_stock') ? true : false;
        
        // Update current_quantity if has_stock is true and opening_quantity is provided
        if ($data['has_stock'] && $request->opening_quantity) {
            $data['current_quantity'] = $request->opening_quantity;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
