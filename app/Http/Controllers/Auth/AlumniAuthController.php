<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumniAuthController extends Controller
{
    public function showRegister()
{
    $prodi = \App\Models\Prodi::orderBy('nama_prodi')->get();
    return view('alumni.auth.register', compact('prodi'));
}

public function register(Request $request)
{
    $validated = $request->validate([
        'nama_lengkap'   => 'required|string|max:255',
        'nim'            => 'required|digits:8|unique:alumni,nim',
        'tanggal_lahir'  => 'required|date',
        'nik' => 'required|digits:16',
        'prodi_id'       => 'required|exists:prodi,id',
        'tahun_lulus'    => 'nullable|digits:4',
        'no_hp'          => 'nullable|numeric',
        'desa'           => 'required|string|max:100',
        'kecamatan'      => 'required|string|max:100',
        'kota'           => 'required|string|max:100',
    ], [
        'nim.digits' => 'NIM harus 8 digit.',
        'nik.digits' => 'NIK harus 16 digit angka.',
    ]);

    // Format kapital tiap kata
    $validated['nama_lengkap'] = ucwords(strtolower($validated['nama_lengkap']));
    $validated['desa'] = ucwords(strtolower($validated['desa']));
    $validated['kecamatan'] = ucwords(strtolower($validated['kecamatan']));
    $validated['kota'] = ucwords(strtolower($validated['kota']));

    $alumni = Alumni::create($validated);

    Auth::guard('alumni')->login($alumni);

    return redirect()
        ->route('alumni.dashboard')
        ->with('success', 'Registrasi berhasil.');
}
    public function showLogin()
    {
        return view('alumni.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        $alumni = Alumni::where('nim', $request->nim)
            ->where('tanggal_lahir', $request->tanggal_lahir)
            ->first();

        if (!$alumni) {
            return back()->withErrors([
                'login' => 'NIM atau Tanggal Lahir tidak sesuai'
            ]);
        }

        Auth::guard('alumni')->login($alumni);

        return redirect()->route('alumni.dashboard');
    }

    public function logout()
    {
        Auth::guard('alumni')->logout();
        return redirect()->route('alumni.login');
    }
}
