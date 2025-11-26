<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRedemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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

    // ========================================
    // NOVOS MÉTODOS PARA GERENCIAR RESGATES
    // ========================================

    /**
     * Lista todos os resgates de produtos
     */
    public function redemptions(Request $request)
    {
        $query = ProductRedemption::with(['user', 'product']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('id', $request->search)
                  ->orWhere('product_name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%')
                               ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        $redemptions = $query->orderBy('created_at', 'desc')->paginate(20);

        // Estatísticas
        $stats = [
            'total_pending' => ProductRedemption::where('status', 'pending')->count(),
            'total_processing' => ProductRedemption::where('status', 'processing')->count(),
            'total_completed' => ProductRedemption::where('status', 'completed')->count(),
            'total_cancelled' => ProductRedemption::where('status', 'cancelled')->count(),
            'points_pending' => ProductRedemption::where('status', 'pending')->sum('points_spent'),
            'points_completed' => ProductRedemption::where('status', 'completed')->sum('points_spent'),
        ];

        return view('admin.products.redemptions', compact('redemptions', 'stats'));
    }

    /**
     * Visualizar detalhes do resgate
     */
    public function showRedemption(ProductRedemption $redemption)
    {
        $redemption->load(['user', 'product']);
        return view('admin.products.redemption-show', compact('redemption'));
    }

    /**
     * Atualizar status do resgate
     */
    public function updateRedemptionStatus(Request $request, ProductRedemption $redemption)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $redemption->status;
        $newStatus = $request->status;

        DB::beginTransaction();

        try {
            $redemption->status = $newStatus;
            $redemption->admin_notes = $request->admin_notes;

            // Se está concluindo o resgate
            if ($newStatus === 'completed' && $oldStatus !== 'completed') {
                $redemption->processed_at = now();
            }

            // Se está CANCELANDO o resgate, devolver os pontos
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                $user = $redemption->user;
                if ($user) {
                    $user->descarte_points += $redemption->points_spent;
                    $user->save();

                    // Devolve o estoque se o produto ainda existir
                    if ($redemption->product) {
                        $redemption->product->stock += 1;
                        $redemption->product->save();
                    }
                }
            }

            $redemption->save();

            DB::commit();

            return redirect()->back()->with('success', 'Status do resgate atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao atualizar resgate: ' . $e->getMessage());
        }
    }

    /**
     * Excluir resgate
     */
    public function destroyRedemption(ProductRedemption $redemption)
    {
        DB::beginTransaction();

        try {
            // Se não foi concluído, devolve os pontos
            if ($redemption->status !== 'completed') {
                $user = $redemption->user;
                if ($user) {
                    $user->descarte_points += $redemption->points_spent;
                    $user->save();
                }

                // Devolve o estoque
                if ($redemption->product) {
                    $redemption->product->stock += 1;
                    $redemption->product->save();
                }
            }

            $redemption->delete();

            DB::commit();

            return redirect()->route('admin.products.redemptions')
                ->with('success', 'Resgate excluído com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao excluir resgate: ' . $e->getMessage());
        }
    }
}