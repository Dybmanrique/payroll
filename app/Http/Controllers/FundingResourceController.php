<?php

namespace App\Http\Controllers;

use App\Models\FundingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FundingResourceController extends Controller
{
    public function index()
    {
        return view('admin.funding-resources.index');
    }
    public function data()
    {
        return FundingResource::all();
    }

    public function get_permissions()
    {
        /** @var User $user */
        $user = Auth::user();
        $can_index = $user->can('funding_resources.index');
        $can_create = $user->can('funding_resources.create');
        $can_edit = $user->can('funding_resources.edit');
        $can_delete = $user->can('funding_resources.delete');

        return response()->json([
            'can_index' => $can_index,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_delete' => $can_delete,
        ]);
    }

    public function create()
    {
        return view('admin.funding-resources.create');
    }

    public function edit(FundingResource $funding_resource)
    {
        return view('admin.funding-resources.edit', compact('funding_resource'));
    }

    public function destroy(Request $request)
    {
        try {
            FundingResource::find($request->id)->delete();
            return response()->json(['message' => 'Eliminado correctamente', 'code' => '200']);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'No se puede eliminar', 'code' => '500']);
        }
    }
}
