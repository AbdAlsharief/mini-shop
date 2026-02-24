<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /** Only products belonging to the logged-in admin. */
    private function adminProducts()
    {
        return Auth::user()->products();
    }

    public function index()
    {
        $products = $this->adminProducts()->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);

        $validated['user_id'] = Auth::id();

        Product::create($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $this->authorizeProduct($product);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted.');
    }

    /** Abort 403 if this product doesn't belong to the current admin. */
    private function authorizeProduct(Product $product): void
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to manage this product.');
        }
    }
}
