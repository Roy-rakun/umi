<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|unique:products',
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required|in:physical,digital',
            'weight' => 'required_if:type,physical|numeric',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required|in:physical,digital',
            'weight' => 'required_if:type,physical|numeric',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
