<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    // Controller para admin profile
    public function index()
    {
        return view('admin.profile.index');
    }

    // Controller para atualizar perfil do admin (imagem máximo 2 megas)
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::user()->id],
            'image' => ['nullable', 'image', 'max:2048'], // máx 2MB
        ]);

        $user = Auth::user();

        // Se o usuário enviou uma nova imagem
        if ($request->hasFile('image')) {
            // Apaga a imagem antiga (se existir e não for a padrão)
            if ($user->image && File::exists(public_path($user->image)) && $user->image !== 'uploads/padrao.png') {
                File::delete(public_path($user->image));
            }

            $image = $request->image;
            $imageName = rand() . '-eletrodescartes-' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);

            $path = 'uploads/' . $imageName;
            $user->image = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('successo !', 'Perfil atualizado com sucesso!');
    }
}
