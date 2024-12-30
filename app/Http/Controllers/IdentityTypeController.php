<?php

namespace App\Http\Controllers;

use App\Models\IdentityType;
use Illuminate\Http\Request;

class IdentityTypeController extends Controller
{
    public function index()
    {
        return view('admin.identity-types.index');
    }
    public function data()
    {
        return IdentityType::all();
    }

    public function create()
    {
        return view('admin.identity-types.create');
    }

    public function edit(IdentityType $identity_type)
    {
        return view('admin.identity-types.edit', compact('identity_type'));
    }

    public function destroy(Request $request)
    {
        try {
            IdentityType::find($request->id)->delete();
            return response()->json(['message' => 'Eliminado correctamente', 'code' => '200']);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'No se puede eliminar', 'code' => '500']);
        }
    }
}
