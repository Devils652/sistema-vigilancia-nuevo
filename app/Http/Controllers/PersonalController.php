<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // <--- Importante para la validación de update

class PersonalController extends Controller
{
    public function index()
    {
        // Eager Loading para optimizar consultas
        $personals = User::where('role_id', '!=', 1)
            ->with(['role', 'supervisor']) 
            ->paginate(10);
            
        return view('personal.index', compact('personals'));
    }

    public function create()
    {
        // Obtenemos roles menos el de admin para no crear superusuarios por error
        $roles = Role::where('name', '!=', 'admin')->get();
        
        // Obtenemos solo usuarios que sean supervisores para la lista desplegable
        $supervisors = User::whereHas('role', function ($q) {
            $q->where('name', 'supervisor');
        })->get();

        return view('personal.create', compact('roles', 'supervisors'));
    }

    public function store(Request $request)
    {
        // VALIDACIÓN ROBUSTA (CREACIÓN)
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'], // Email único en la tabla users
            'password'      => ['required', 'string', 'min:8', 'confirmed'], // Mínimo 8 caracteres y confirmación (si usas password_confirmation)
            'role_id'       => ['required', 'exists:roles,id'], // El rol debe existir en la BD
            'supervisor_id' => ['nullable', 'exists:users,id'], // Opcional (para Admins/Supervisores) pero si se envía debe existir
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'role_id'       => $request->role_id,
            'supervisor_id' => $request->supervisor_id, // Puede ser null
            'status'        => 1,
            'password'      => Hash::make($request->password),
        ]);

        return redirect()->route('admin.personal.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'admin')->get();
        $supervisors = User::whereHas('role', function ($q) {
            $q->where('name', 'supervisor');
        })->where('id', '!=', $user->id)->get(); // Evitar que se seleccione a sí mismo como supervisor

        return view('personal.edit', compact('user', 'roles', 'supervisors'));
    }

    public function update(Request $request, User $user)
    {
        // VALIDACIÓN ROBUSTA (EDICIÓN)
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            // Ignoramos el ID del usuario actual para permitir guardar sin cambiar el email
            'email'         => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role_id'       => ['required', 'exists:roles,id'],
            'supervisor_id' => ['nullable', 'exists:users,id'],
        ]);

        $data = [
            'name'          => $request->name,
            'email'         => $request->email,
            'role_id'       => $request->role_id,
            'supervisor_id' => $request->supervisor_id
        ];

        // Solo actualizamos la contraseña si el campo no está vacío
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['string', 'min:8', 'confirmed']
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.personal.index')
            ->with('success', 'Usuario actualizado.');
    }

    public function destroy(User $user)
    {
        // Prevención: No eliminarse a sí mismo
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.personal.index')
                ->with('error', 'ACCIÓN DENEGADA: No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('admin.personal.index')
            ->with('success', 'Usuario eliminado.');
    }

    public function toggle(User $user)
    {
        // Prevención: No desactivarse a sí mismo
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.personal.index')
                ->with('success', 'ERROR: No puedes desactivar tu propia cuenta.');
        }

        $user->update([
            'status' => !$user->status
        ]);

        return redirect()->route('admin.personal.index')
            ->with('success', 'Estado del usuario actualizado.');
    }
}