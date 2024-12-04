<?php

namespace App\Http\Controllers;

use App\Models\FundingResource;
use Illuminate\Http\Request;

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
