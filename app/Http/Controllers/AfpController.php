<?php

namespace App\Http\Controllers;

use App\Models\Afp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function get_permissions()
    {
        /** @var User $user */
        $user = Auth::user();
        $can_index = $user->can('afps.index');
        $can_create = $user->can('afps.create');
        $can_edit = $user->can('afps.edit');
        $can_delete = $user->can('afps.delete');

        return response()->json([
            'can_index' => $can_index,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_delete' => $can_delete,
        ]);
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
            return response()->json(['message' => 'Eliminado correctamente', 'code' => '200']);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'No se puede eliminar', 'code' => '500']);
        }
    }
}
