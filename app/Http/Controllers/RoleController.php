<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
