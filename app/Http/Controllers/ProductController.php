<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

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
            'product_image' => 'nullable|image|max:2048',
            'icon' => 'nullable|string','description' => 'nullable|string'
        ]);

        $data = $request->except(['product_image']);
        
        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        Product::create($data);

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
            'product_image' => 'nullable|image|max:2048',
            'icon' => 'nullable|string','description' => 'nullable|string'
        ]);

        $data = $request->except(['product_image']);

        if ($request->hasFile('product_image')) {
            // Delete old image
            if ($product->image_url) {
                $oldPath = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('product_image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Check if product has related orders
        $ordersCount = \App\Models\Order::where('product_id', $id)->count();
        if ($ordersCount > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', "Tidak dapat menghapus produk '{$product->name}' karena memiliki {$ordersCount} pesanan terkait. Hapus pesanan terlebih dahulu atau nonaktifkan produk.");
        }
        
        // Check if product has related commissions
        $commissionsCount = \App\Models\Commission::where('product_id', $id)->count();
        if ($commissionsCount > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', "Tidak dapat menghapus produk '{$product->name}' karena memiliki {$commissionsCount} komisi terkait.");
        }
        
        // Delete image
        if ($product->image_url) {
            $oldPath = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($oldPath);
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', "Produk '{$product->name}' berhasil dihapus.");
    }
}
