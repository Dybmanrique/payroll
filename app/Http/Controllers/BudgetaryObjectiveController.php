<?php

namespace App\Http\Controllers;

use App\Models\BudgetaryObjective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BudgetaryObjectiveController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'web',
            new Middleware('can:budgetary_objectives.index', only: ['index','data']),
            new Middleware('can:budgetary_objectives.create', only: ['create']),
            new Middleware('can:budgetary_objectives.edit', only: ['edit']),
            new Middleware('can:budgetary_objectives.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        return view('admin.budgetary-objectives.index');
    }

    public function data()
    {
        return BudgetaryObjective::orderByDesc('id')->get();
    }

    public function get_permissions()
    {
        /** @var User $user */
        $user = Auth::user();
        $can_index = $user->can('budgetary_objectives.index');
        $can_create = $user->can('budgetary_objectives.create');
        $can_edit = $user->can('budgetary_objectives.edit');
        $can_delete = $user->can('budgetary_objectives.delete');

        return response()->json([
            'can_index' => $can_index,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_delete' => $can_delete,
        ]);
    }

    public function create()
    {
        return view('admin.budgetary-objectives.create');
    }

    public function edit(BudgetaryObjective $budgetary_objective)
    {
        return view('admin.budgetary-objectives.edit', compact('budgetary_objective'));
    }

    public function destroy(Request $request)
    {
        try {
            BudgetaryObjective::find($request->id)->delete();
            return response()->json(['message' => 'Eliminado correctamente', 'code' => '200']);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'No se puede eliminar', 'code' => '500']);
        }
    }
}
