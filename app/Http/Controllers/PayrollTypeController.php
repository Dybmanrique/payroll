<?php

namespace App\Http\Controllers;

use App\Models\PayrollType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollTypeController extends Controller
{
    public function index()
    {
        return view('admin.payroll-types.index');
    }
    public function data()
    {
        return PayrollType::all();
    }

    public function get_permissions()
    {
        /** @var User $user */
        $user = Auth::user();
        $can_index = $user->can('payroll_types.index');
        $can_create = $user->can('payroll_types.create');
        $can_edit = $user->can('payroll_types.edit');
        $can_delete = $user->can('payroll_types.delete');

        return response()->json([
            'can_index' => $can_index,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_delete' => $can_delete,
        ]);
    }

    public function create()
    {
        return view('admin.payroll-types.create');
    }

    public function edit(PayrollType $payroll_type)
    {
        return view('admin.payroll-types.edit', compact('payroll_type'));
    }

    public function destroy(Request $request)
    {
        try {
            PayrollType::find($request->id)->delete();
            return response()->json(['message' => 'Eliminado correctamente', 'code' => '200']);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'No se puede eliminar', 'code' => '500']);
        }
    }
}
