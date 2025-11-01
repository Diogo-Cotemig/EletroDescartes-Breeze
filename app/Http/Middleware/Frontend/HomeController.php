<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Exibe os produtos para os clientes
     */
    public function products()
    {
        // Busca apenas produtos ativos com estoque disponível
        $products = Product::where('status', 'active')
                          ->where('stock', '>', 0)
                          ->latest()
                          ->paginate(12);

        return view('tasks.Cards', compact('products'));
    }
}
