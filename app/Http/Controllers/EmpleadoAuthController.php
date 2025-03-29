<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpleadoAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('employees.login'); // Crea esta vista
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identity_number' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('employee')->attempt($credentials)) {
            return redirect()->route('empleado.dashboard'); // Ajusta la ruta
        }

        return back()->withErrors(['identity_number' => 'Credenciales incorrectas']);
    }

    public function logout()
    {
        Auth::guard('employee')->logout();
        return redirect()->route('empleado.login');
    }
}
