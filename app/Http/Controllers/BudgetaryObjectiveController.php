<?php

namespace App\Http\Controllers;

use App\Models\BudgetaryObjective;
use Illuminate\Http\Request;

class BudgetaryObjectiveController extends Controller
{
    public function index()
    {
        return view('admin.budgetary-objectives.index');
    }
    public function data()
    {
        return BudgetaryObjective::orderByDesc('id')->get();
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
