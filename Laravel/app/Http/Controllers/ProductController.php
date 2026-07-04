<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan semua produk
     */
    
    public function index()
    {
        return response()->json(Product::with('category')->get());
    }

    /**
     * Menambahkan produk baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $request->image,
        ]);

        ActivityLog::create([
            'user' => 'admin',
            'activity' => 'Menambahkan produk '.$product->name,
            'module' => 'Product',
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Product berhasil ditambahkan',
            'data' => $product,
        ], 201);
    }

    /**
     * Menampilkan detail produk
     */
    public function show(string $id)
    {
        return response()->json(
            Product::with('category')->findOrFail($id)
        );
    }

    /**
     * Mengubah data produk
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->only([
            'category_id',
            'name',
            'price',
            'stock',
            'description',
            'image'
        ]));

        ActivityLog::create([
            'user' => 'admin',
            'activity' => 'Mengubah produk '.$product->name,
            'module' => 'Product',
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Product berhasil diupdate',
            'data' => $product,
        ]);
    }

    /**
     * Menghapus produk
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $productName = $product->name;

        $product->delete();

        ActivityLog::create([
            'user' => 'admin',
            'activity' => 'Menghapus produk '.$productName,
            'module' => 'Product',
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Product berhasil dihapus'
        ]);
    }
}