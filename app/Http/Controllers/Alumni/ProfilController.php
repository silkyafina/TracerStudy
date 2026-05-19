<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class ProfilController extends Controller
{
    public function index()
    {
        
        $user = Auth::user();
$alumni = $user->alumni;
        return view('alumni.profil.index', compact('alumni'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Alumni $alumni */

        $user = Auth::user();
        $alumni = $user->alumni;      

        $request->validate([
        'nama_lengkap'  => 'required|string|max:255',
        'nim'           => 'required|string|max:20|unique:alumni,nim',
        'tanggal_lahir' => 'required|date',
        'nik'           => 'nullable|string|max:20',
        'prodi_id'      => 'required|exists:prodi,id',
        'tahun_lulus'   => 'nullable|integer|min:2000|max:' . date('Y'),
        'no_hp'         => 'nullable|string|max:20',
        'desa'          => 'nullable|string|max:100',
        'kecamatan'     => 'nullable|string|max:100',
        'kota'          => 'nullable|string|max:100',
        ]);

        $alumni->update($request->only([
            'nama_lengkap',
            'nim',
            'tanggal_lahir',
            'nik',
            'prodi_id',
            'tahun_lulus',
            'desa',
            'kecamatan',
            'kota',
        ]));

        return redirect()
            ->route('alumni.profil')
            ->with('success', 'Profil berhasil diperbarui');
    }
    public function edit()
    {
        $user = Auth::user();
$alumni = $user->alumni;
        $prodi = Prodi::orderBy('nama_prodi')->get();
        return view('alumni.profil.edit', compact('alumni','prodi'));
    }
 
public function editPassword()
{
    return view('alumni.profil.password');
}

public function updatePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = \App\Models\User::find(Auth::id());

    if (!$user) {
        return back()->withErrors('User tidak ditemukan');
    }

    if (!Hash::check($request->old_password, $user->password)) {
        return back()->withErrors([
            'old_password' => 'Password lama tidak sesuai'
        ]);
    }

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return back()->with('success', 'Password berhasil diubah');
}
}
