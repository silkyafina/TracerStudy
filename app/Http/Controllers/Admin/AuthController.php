<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function formLogin()
    {
        return view('admin.auth.login');
    }
    public function login(Request $request)
    {
    if (Auth::guard('admin')->attempt($request->only('email','password'))) {
        return redirect()->route('admin.dashboard');
    }
    return back()->with('error','Login gagal');
}
public function logout(Request $request)
{
    Auth::guard('admin')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login');
    
}

}