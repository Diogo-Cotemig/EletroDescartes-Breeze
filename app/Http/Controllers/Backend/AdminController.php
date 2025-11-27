<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Estatísticas reais
     $stats = [
        'admins' => \App\Models\User::where('role', 'admin')->count(),
        'products' => \App\Models\Product::where('status', 'active')->count(),
        'vendors' => \App\Models\User::where('role', 'vendor')->count(),
        'customers' => \App\Models\User::where('role', 'user')->count(),
    ];

    // Busca os 5 produtos mais recentes
    $recentProducts = \App\Models\Product::latest()->take(5)->get();

    return view('admin.dashboard', compact('stats', 'recentProducts'));

    return view('admin.dashboard', compact('stats'));
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function forgot()
    {
        return view('admin.auth.forgot-password');
    }
}
