<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'web',
            new Middleware('can:roles.index', only: ['index','data']),
            new Middleware('can:roles.create', only: ['create']),
            new Middleware('can:roles.edit', only: ['edit']),
            new Middleware('can:roles.delete', only: ['destroy']),
        ];
    }

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
