<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AlumniAuthController extends Controller
{
 
    public function showLogin()
    {
        return view('alumni.auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'nim' => 'required',
        'password' => 'required',
    ]);

    $user = User::where('username', $request->nim)
        ->where('role', 'alumni')
        ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->withErrors(['login' => 'Login gagal']);
    }

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('alumni.dashboard');
}

public function logout()
{
    Auth::logout();
    return redirect()->route('alumni.login');
}
}
