<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
            $query->where('nama_produk', 'like', '%' . $search . '%');
        })->latest()->get();

        return Inertia::render('Products/Index', [
            'products' => $products,
            'filters'  => ['search' => $search],
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|string|max:50|unique:products,kode_produk',
            'nama_produk' => 'required|string|max:255',
            'kategori'    => 'required|string|max:100',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'kode_produk' => ['required', 'string', 'max:50', Rule::unique('products', 'kode_produk')->ignore($product->id)],
            'nama_produk' => 'required|string|max:255',
            'kategori'    => 'required|string|max:100',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
