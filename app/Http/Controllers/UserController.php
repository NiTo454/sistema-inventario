<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// Importaciones necesarias para que no den error
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin,manager,employee',
            'phone' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Ahora Hash funcionará
            'role' => $request->role,
            'phone' => $request->phone,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,manager,employee',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado');
    }

    /**
     * Remove the specified resource from storage.
     * Lógica personalizada: Solo admin borra directo, otros con contraseña.
     */
    public function destroy(Request $request, User $user)
    {
        $currentUser = Auth::user();

        // 1. Verificamos si NO es administrador
        if ($currentUser->role !== 'admin') {
            
            // Validamos que venga la contraseña en la petición
            $request->validate([
                'password_confirmation' => 'required',
            ]);

            // Comparamos la contraseña ingresada con la del usuario que está logueado
            if (!Hash::check($request->password_confirmation, $currentUser->password)) {
                return back()->withErrors(['password_confirmation' => 'La contraseña es incorrecta. No tienes permiso para eliminar usuarios.']);
            }
        }

        // 2. Si pasó el check o es admin, se elimina
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}