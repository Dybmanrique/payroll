<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index');
    }
    public function data()
    {
        return Role::select('id', 'name')->get();
    }
    public function get_permissions()
    {
        /** @var User $user */
        $user = Auth::user();
        $can_index = $user->can('roles.index');
        $can_create = $user->can('roles.create');
        $can_edit = $user->can('roles.edit');
        $can_delete = $user->can('roles.delete');

        return response()->json([
            'can_index' => $can_index,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_delete' => $can_delete,
        ]);
    }
    public function create()
    {
        return view('admin.roles.create');
    }
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }
    public function destroy(Request $request)
    {
        try {
            Role::find($request->id)->delete();
            return response()->json(['message' => 'Eliminado correctamente', 'code' => '200']);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'No se puede eliminar', 'code' => '500']);
        }
    }
}
