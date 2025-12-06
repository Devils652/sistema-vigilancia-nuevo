<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
{
    public function index()
    {
        // Cargamos la relación 'supervisor' para no hacer 100 consultas (Eager Loading)
        $personals = User::where('role_id', '!=', 1)
            ->with(['role', 'supervisor']) 
            ->paginate(10);
            
        return view('personal.index', compact('personals'));
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'admin')->get();
        $supervisors = User::whereHas('role', function ($q) {
            $q->where('name', 'supervisor');
        })->get();

        return view('personal.create', compact('roles', 'supervisors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role_id'  => 'required|exists:roles,id',
            // CAMBIO: Ahora es obligatorio (required)
            'supervisor_id' => 'required|exists:users,id'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role_id'  => $request->role_id,
            'supervisor_id' => $request->supervisor_id,
            'status'   => 1,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.personal.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'admin')->get();
        $supervisors = User::whereHas('role', function ($q) {
            $q->where('name', 'supervisor');
        })->where('id', '!=', $user->id)->get();

        return view('personal.edit', compact('user', 'roles', 'supervisors'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string',
            'email' => "required|email|unique:users,email,$user->id",
            'role_id' => 'required|exists:roles,id',
            // CAMBIO: Ahora es obligatorio
            'supervisor_id' => 'required|exists:users,id'
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'supervisor_id' => $request->supervisor_id
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.personal.index')
            ->with('success', 'Usuario actualizado.');
    }

    public function destroy(User $user)
    {
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