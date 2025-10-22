<?php

namespace App\Http\Controllers;

use App\Models\OtroRubro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtroRubroController extends Controller
{
    public function index()
    {
        // ✅ Lista paginada de 5 rubros del usuario autenticado
        $rubros = OtroRubro::where('user_id', Auth::id())->paginate(5);

        // ✅ Total general de montos del usuario autenticado
        $totalMonto = OtroRubro::where('user_id', Auth::id())->sum('monto');

        return view('usuario.otros-rubros.index', compact('rubros', 'totalMonto'));
    }

    public function create()
    {
        return view('usuario.otros-rubros.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rubro'    => 'required|string|max:255',
            'concepto' => 'required|string',      // ← antes 'descripcion'
            'monto'    => 'required|numeric|min:1',
        ]);

        OtroRubro::create([
            'user_id'  => Auth::id(),
            'rubro'    => $request->rubro,
            'concepto' => $request->concepto,     // ← antes 'descripcion'
            'monto'    => $request->monto,
        ]);

        return redirect()->route('otros-rubros.index')->with('success', 'Rubro registrado correctamente.');
    }

    public function show(OtroRubro $otros_rubro)
    {
        return view('usuario.otros-rubros.show', compact('otros_rubro'));
    }

    public function edit(OtroRubro $otros_rubro)
    {
        return view('usuario.otros-rubros.edit', compact('otros_rubro'));
    }

    public function update(Request $request, OtroRubro $otros_rubro)
    {
        $request->validate([
            'rubro'    => 'required|string|max:255',
            'concepto' => 'required|string',      // ← antes 'descripcion'
            'monto'    => 'required|numeric|min:1',
        ]);

        $otros_rubro->update([
            'rubro'    => $request->rubro,
            'concepto' => $request->concepto,     // ← antes 'descripcion'
            'monto'    => $request->monto,
        ]);

        return redirect()->route('otros-rubros.index')->with('warning', 'Rubro editado correctamente.');
    }

    public function destroy(OtroRubro $otros_rubro)
    {
        $otros_rubro->delete();

        return redirect()->route('otros-rubros.index')->with('danger', 'Rubro eliminado correctamente.');
    }
}
