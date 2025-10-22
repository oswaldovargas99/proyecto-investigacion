<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Listado con búsqueda y paginación
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $users = User::when($q, function ($query) use ($q) {
                        $query->where(function ($sub) use ($q) {
                            $sub->where('name', 'like', "%{$q}%")
                                ->orWhere('email', 'like', "%{$q}%");
                        });
                    })
                    ->orderByDesc('id')
                    ->paginate(5)
                    ->withQueryString();

        return view('administrador.usuarios.index', compact('users', 'q'));
    }

    /**
     * Form de creación
     */
    public function create()
    {
        return view('administrador.usuarios.create');
    }

    /**
     * Crear usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required','string','max:255'],
            'email'     => ['required','string','email','max:255','unique:users,email'],
            'password'  => ['required','string','min:8','confirmed'],
            'role'      => ['required','in:1,2,3'],
            'is_active' => ['nullable','boolean'],
        ]);

        User::create([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password')),
            'role'      => (int) $request->input('role', 1),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Detalle
     */
    public function show(User $usuario)
    {
        return view('administrador.usuarios.show', compact('usuario'));
    }

    /**
     * Form de edición
     */
    public function edit(User $usuario)
    {
        return view('administrador.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'      => ['required','string','max:255'],
            'email'     => ['required','string','email','max:255', Rule::unique('users','email')->ignore($usuario->id)],
            'password'  => ['nullable','string','min:8','confirmed'],
            'role'      => ['required','in:1,2,3'],
            'is_active' => ['nullable','boolean'],
        ]);

        $data = [
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'role'      => (int) $request->input('role', $usuario->role),
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')
            ->with('warning', 'Usuario actualizado correctamente.');
    }

 
    // FUNCION ELIMINAR - USUARIO
    public function destroy(User $usuario)
    {
        // ✅ Validar si el usuario autenticado intenta eliminarse a sí mismo
        if (auth()->check() && auth()->id() === $usuario->id) {
            return redirect()->route('admin.usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta mientras estás logueado.');
        }

        // ✅ Eliminar usuario (si no es el actual)
        $usuario->delete();

        // ✅ Mensaje de éxito con color coherente (verde)
        return redirect()->route('admin.usuarios.index')
            ->with('danger', 'Usuario eliminado correctamente.');
    }

}
