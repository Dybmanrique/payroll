<?php

namespace App\Http\Controllers;

use App\Models\IdentityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function get_permissions()
    {
        /** @var User $user */
        $user = Auth::user();
        $can_index = $user->can('identity_types.index');
        $can_create = $user->can('identity_types.create');
        $can_edit = $user->can('identity_types.edit');
        $can_delete = $user->can('identity_types.delete');

        return response()->json([
            'can_index' => $can_index,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_delete' => $can_delete,
        ]);
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
