<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRedemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRedemptionController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')
            ->where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('tasks.Cards', compact('products'));
    }

    public function redeem(Request $request, Product $product)
    {
        $user = Auth::user();

        // Validações
        if ($product->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Este produto não está mais disponível.'
            ], 400);
        }

        if ($product->stock < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Produto sem estoque.'
            ], 400);
        }

        if ($user->descarte_points < $product->price) {
            return response()->json([
                'success' => false,
                'message' => 'Pontos insuficientes. Você tem ' . number_format($user->descarte_points, 2, ',', '.') . ' pontos e precisa de ' . number_format($product->price, 2, ',', '.') . ' pontos.'
            ], 400);
        }

        DB::beginTransaction();

        try {
            // Deduz os pontos do usuário
            $user->descarte_points -= $product->price;
            $user->save();

            // Reduz o estoque
            $product->stock -= 1;
            $product->save();

            // Cria o registro de resgate
            $redemption = ProductRedemption::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'points_spent' => $product->price,
                'product_name' => $product->name,
                'product_description' => $product->description,
                'product_image' => $product->image,
                'status' => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Resgate realizado com sucesso! Tire um print desta confirmação e faça a solicitação pelo Suporte.',
                'redemption_id' => $redemption->id,
                'new_points' => number_format($user->descarte_points, 2, ',', '.')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar resgate: ' . $e->getMessage()
            ], 500);
        }
    }
}