<?php

namespace App\Http\Controllers;

use App\Models\PayrollType;
use Illuminate\Http\Request;

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
            return response()->json([
                'message' => 'Eliminado correctamente',
                'code' => '200'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'No se puede eliminar',
                'code' => '500'
            ]);
        }
    }
}
