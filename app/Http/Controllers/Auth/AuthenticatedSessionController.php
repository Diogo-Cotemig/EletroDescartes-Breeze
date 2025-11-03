<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Autentificação do sistema
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Autentificação do sistema
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // condicional para redirecionar conforme o nivel do usuario

        if($request->user()->role === 'admin'){
            return redirect()->intended(route('admin.dashboard'));
        }
         // condicional para redirecionar conforme o nivel do usuario (vendedor)
        elseif ($request->user()->role === 'vendor'){
            return redirect()->intended(route('vendor.dashboard'));
            }
         // condicional para redirecionar conforme o nivel do usuario (user comum)
        elseif ($request->user()->role === 'user'){
            return redirect()->intended(route('logado'));
        }else{
            return redirect('login')->with('error','Opps! Seus dados estão incorretos.');
        }
       
        return redirect()->intended(route('logado'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
