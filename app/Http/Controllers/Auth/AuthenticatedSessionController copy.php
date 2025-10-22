<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request): RedirectResponse
    {
        // Autenticación estándar de Jetstream
        $request->authenticate();
        $request->session()->regenerate();

        // Obtiene el rol del usuario autenticado
        $rol = auth()->user()->rol ?? 1; // Ajusta el nombre del campo si tu tabla usa otro (por ejemplo 'role_id')

        // Mensaje personalizado según el rol
        switch ($rol) {
            case 3:
                Session::flash('rol', 'Bienvenido Administrador del Sistema');
                break;
            case 2:
                Session::flash('rol', 'Bienvenido Coordinador de Posgrado');
                break;
            default:
                Session::flash('rol', 'Bienvenido Usuario');
                break;
        }

        // Redirección normal al dashboard
        return redirect()->intended(route('dashboard', absolute: false));
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
