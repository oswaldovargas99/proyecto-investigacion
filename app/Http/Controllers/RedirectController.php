<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke(Request $request)
    {
        $role = $request->user()->role;

        return match ($role) {
            1 => redirect()->route('usuario.dashboard'),
            2 => redirect()->route('coordinador.dashboard'),
            3 => redirect()->route('admin.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }
}
