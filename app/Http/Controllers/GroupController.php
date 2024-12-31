<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GroupController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'web',
            new Middleware('can:groups.index', only: ['index','data']),
            new Middleware('can:groups.create', only: ['create']),
            new Middleware('can:groups.edit', only: ['edit']),
            new Middleware('can:groups.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        return view('admin.groups.index');
    }

    public function data()
    {
        return Group::with(['employees' => function ($query) {
            $query->select('id', 'name', 'last_name', 'second_last_name', 'group_id'); // Incluye la clave foránea
        }])->get();
    }

    public function get_permissions()
    {
        /** @var User $user */
        $user = Auth::user();
        $can_index = $user->can('groups.index');
        $can_create = $user->can('groups.create');
        $can_edit = $user->can('groups.edit');
        $can_delete = $user->can('groups.delete');

        return response()->json([
            'can_index' => $can_index,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_delete' => $can_delete,
        ]);
    }

    public function create()
    {
        return view('admin.groups.create');
    }

    public function edit(Group $group)
    {
        return view('admin.groups.edit', compact('group'));
    }

    public function destroy(Request $request)
    {
        try {
            Group::find($request->id)->delete();
            return response()->json(['message' => 'Eliminado correctamente', 'code' => '200']);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'No se puede eliminar', 'code' => '500']);
        }
    }
}
