<?php

namespace App\Http\Controllers;

use App\Models\Afp;
use Illuminate\Http\Request;

class AfpController extends Controller
{
    public function index()
    {
        return view('admin.afps.index');
    }
    public function data()
    {
        return Afp::all();
    }

    public function create()
    {
        return view('admin.afps.create');
    }

    public function edit(Afp $afp)
    {
        return view('admin.afps.edit', compact('afp'));
    }

    public function destroy(Request $request)
    {
        try {
            Afp::find($request->id)->delete();
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
