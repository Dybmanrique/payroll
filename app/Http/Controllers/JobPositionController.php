<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{
    public function index()
    {
        return view('admin.job-positions.index');
    }
    public function data()
    {
        return JobPosition::all();
    }

    public function create()
    {
        return view('admin.job-positions.create');
    }

    public function edit(JobPosition $job_position)
    {
        return view('admin.job-positions.edit', compact('job_position'));
    }

    public function destroy(Request $request)
    {
        try {
            JobPosition::find($request->id)->delete();
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
