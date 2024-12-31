<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LevelController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'web',
            new Middleware('can:levels.index', only: ['index','data']),
            new Middleware('can:levels.create', only: ['create']),
            new Middleware('can:levels.edit', only: ['edit']),
            new Middleware('can:levels.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        return view('admin.levels.index');
    }

    public function data()
    {
        return Level::all();
    }

    public function get_permissions()
    {
        /** @var User $user */
        $user = Auth::user();
        $can_index = $user->can('levels.index');
        $can_create = $user->can('levels.create');
        $can_edit = $user->can('levels.edit');
        $can_delete = $user->can('levels.delete');

        return response()->json([
            'can_index' => $can_index,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_delete' => $can_delete,
        ]);
    }

    public function create()
    {
        return view('admin.levels.create');
    }

    public function edit(Level $level)
    {
        return view('admin.levels.edit', compact('level'));
    }

    public function destroy(Request $request)
    {
        try {
            Level::find($request->id)->delete();
            return response()->json(['message' => 'Eliminado correctamente', 'code' => '200']);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'No se puede eliminar', 'code' => '500']);
        }
    }
}
