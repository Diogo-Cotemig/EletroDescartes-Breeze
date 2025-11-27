<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Rota;
use Illuminate\Http\Request;

class RotaController extends Controller
{
    public function index()
    {
        $rotas = Rota::latest()->paginate(10);
        return view('admin.rotas.index', compact('rotas'));
    }

    public function create()
    {
        return view('admin.rotas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
        ]);

        Rota::create($request->all());

        return redirect()->route('admin.rotas.index')
            ->with('success', 'Ponto de coleta criado com sucesso!');
    }
    public function destroy($id)
{
    $rota = Rota::findOrFail($id);
    $rota->delete();

    return redirect()
        ->route('admin.rotas.index')
        ->with('success', 'Ponto de coleta removido com sucesso!');
}
public function update(Request $request, Rota $rota)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'endereco' => 'required|string|max:255',
        'cidade' => 'required|string|max:255',
        'estado' => 'required|string|max:2',
    ]);

    $rota->update($request->all());

    return redirect()->route('admin.rotas.index')
        ->with('success', 'Ponto de coleta atualizado com sucesso!');
}
}