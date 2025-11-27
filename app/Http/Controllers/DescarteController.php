<?php

namespace App\Http\Controllers;

use App\Models\Rota;

class DescarteController extends Controller
{
    public function index()
    {
        $rotas = Rota::all();
        return view('tasks.descartar', compact('rotas'));
    }
}
