<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class JobPositionController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'web',
            new Middleware('can:job_positions.index', only: ['index','data']),
            new Middleware('can:job_positions.create', only: ['create']),
            new Middleware('can:job_positions.edit', only: ['edit']),
            new Middleware('can:job_positions.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        return view('admin.job-positions.index');
    }

    public function data()
    {
        return JobPosition::all();
    }

    public function get_permissions()
    {
        /** @var User $user */
        $user = Auth::user();
        $can_index = $user->can('job_positions.index');
        $can_create = $user->can('job_positions.create');
        $can_edit = $user->can('job_positions.edit');
        $can_delete = $user->can('job_positions.delete');

        return response()->json([
            'can_index' => $can_index,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_delete' => $can_delete,
        ]);
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
            return response()->json(['message' => 'Eliminado correctamente', 'code' => '200']);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'No se puede eliminar', 'code' => '500']);
        }
    }
}
