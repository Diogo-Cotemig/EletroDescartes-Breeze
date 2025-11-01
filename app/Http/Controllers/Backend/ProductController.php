<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:novo,seminovo,usado',
            'category' => 'nullable|max:100',
            'image' => 'nullable|image|max:2048',
            'stock' => 'required|integer|min:0',
            'badge' => 'nullable|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->image;
            $imageName = rand() . '-produto-' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
            'category' => $request->category,
            'image' => $imagePath,
            'stock' => $request->stock,
            'badge' => $request->badge,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:novo,seminovo,usado',
            'category' => 'nullable|max:100',
            'image' => 'nullable|image|max:2048',
            'stock' => 'required|integer|min:0',
            'badge' => 'nullable|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            // Apaga imagem antiga
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            $image = $request->image;
            $imageName = rand() . '-produto-' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = 'uploads/products/' . $imageName;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
            'category' => $request->category,
            'stock' => $request->stock,
            'badge' => $request->badge,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        // Apaga a imagem
        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produto excluído com sucesso!');
    }
}
