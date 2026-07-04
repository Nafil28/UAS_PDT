<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use Illuminate\Http\Request;

class Categorycontroller extends Controller
{
    /**
     * Menampilkan semua kategori
     */
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * Menambahkan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        ActivityLog::create([
            'user' => 'admin',
            'activity' => 'Menambahkan kategori '.$category->name,
            'module' => 'Category',
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Category berhasil ditambahkan',
            'data' => $category,
        ], 201);
    }

    /**
     * Menampilkan detail kategori
     */
    public function show(string $id)
    {
        return response()->json(Category::findOrFail($id));
    }

    /**
     * Mengubah data kategori
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $category->update($request->only([
            'name',
            'description'
        ]));

        ActivityLog::create([
            'user' => 'admin',
            'activity' => 'Mengubah kategori '.$category->name,
            'module' => 'Category',
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Category berhasil diupdate',
            'data' => $category,
        ]);
    }

    /**
     * Menghapus kategori
     */
    public function destroy(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        ActivityLog::create([
            'user' => 'admin',
            'activity' => 'Menghapus kategori '.$category->name,
            'module' => 'Category',
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);


        return response()->json([
            'message' => 'Category berhasil dihapus'
        ]);
    }
}