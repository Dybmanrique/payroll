<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        return view('admin.payrolls.index');
    }
    public function data()
    {
        return Payroll::all();
    }

    public function create()
    {
        return view('admin.payrolls.create');
    }

    public function edit(Payroll $payroll)
    {
        return view('admin.payrolls.edit', compact('payroll'));
    }

    public function destroy(Request $request)
    {
        try {
            Payroll::find($request->id)->delete();
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
