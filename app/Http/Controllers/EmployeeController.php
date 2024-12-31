<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EmployeeController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'web',
            new Middleware('can:employees.index', only: ['index','data']),
            new Middleware('can:employees.create', only: ['create']),
            new Middleware('can:employees.edit', only: ['edit']),
            new Middleware('can:employees.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        return view('admin.employees.index');
    }

    public function data()
    {
        return Employee::with('identity_type')->get();
    }

    public function get_permissions()
    {
        /** @var User $user */
        $user = Auth::user();
        $can_index = $user->can('employees.index');
        $can_create = $user->can('employees.create');
        $can_edit = $user->can('employees.edit');
        $can_delete = $user->can('employees.delete');

        return response()->json([
            'can_index' => $can_index,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_delete' => $can_delete,
        ]);
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function destroy(Request $request)
    {
        try {
            Employee::find($request->id)->delete();
            return response()->json(['message' => 'Eliminado correctamente', 'code' => '200']);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'No se puede eliminar', 'code' => '500']);
        }
    }
}
