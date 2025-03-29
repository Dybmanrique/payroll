<?php

namespace App\Http\Controllers;

use App\Models\IdentityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('worker')->check()) {
            return redirect()->route('workers.dashboard');
        }

        $identity_types = IdentityType::orderByRaw("CASE WHEN name = 'D.N.I.' THEN 0 ELSE 1 END")->get();

        return view('workers.login', compact('identity_types')); // Crea esta vista
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identity_number' => 'required|string',
            'password' => 'required|string',
            'identity_type_id' => 'required|integer',
        ]);

        $credentialsWithType = [
            'identity_number' => $credentials['identity_number'],
            'password' => $credentials['password'],
            'identity_type_id' => $credentials['identity_type_id'],
        ];

        $remember = $request->has('remember');

        if (Auth::guard('worker')->attempt($credentialsWithType, $remember)) {
            return redirect()->route('workers.dashboard');
        }

        return back()->withErrors(['identity_number' => 'Las credenciales no son válidas.'])->withInput();
    }


    public function logout()
    {
        Auth::guard('worker')->logout();
        return redirect()->route('workers.login');
    }
}
