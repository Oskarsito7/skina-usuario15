<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }
    public function update(Request $request, User $user)
    {
        //Guardar el estado del usuario
        $user->status = $request->input('status');
        $user->roles()->sync($request->roles);
        $user->save();
        return redirect()->route('users.edit', $user)->with('success', 'Rol asignado correctamente.');
    }
}
