<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodi = Prodi::latest()->get();

        return view('admin.prodi.index', compact('prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_prodi' => 'required|unique:prodi,kode_prodi',
            'nama_prodi' => 'required'
        ]);

        Prodi::create($request->all());

        return redirect()
            ->route('admin.prodi.index')
            ->with('success', 'Data prodi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $prodi = Prodi::findOrFail($id);

        $request->validate([
            'kode_prodi' => 'required|unique:prodi,kode_prodi,' . $id,
            'nama_prodi' => 'required'
        ]);

        $prodi->update($request->all());

        return redirect()
            ->route('admin.prodi.index')
            ->with('success', 'Data prodi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);
    
        if ($prodi->alumni()->count() > 0) {
            return redirect()
                ->route('admin.prodi.index')
                ->with('error', 'Prodi tidak dapat dihapus karena masih digunakan oleh data alumni.');
        }
    
        $prodi->delete();
    
        return redirect()
            ->route('admin.prodi.index')
            ->with('success', 'Data prodi berhasil dihapus.');
    }
}