<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TracerSection;
use Illuminate\Http\Request;

class TracerSectionController extends Controller
{
    public function index()
    {
        $sections = TracerSection::orderBy('urutan')->get();
        return view('admin.tracer.section.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.tracer.section.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_section' => 'required',
            'urutan' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        TracerSection::create($request->all());
        return redirect()->route('admin.tracer-section.index')
        ->with('success','Section berhasil ditambahkan');
    }

    public function edit($id)
    {
    $section = TracerSection::findOrFail($id);
    return view('admin.tracer.section.edit', compact('section'));
    }


    public function update(Request $request, $id)
    {
    $request->validate([
        'urutan' => 'required|integer',
        'nama_section' => 'required|string|max:255',
        'deskripsi' => 'nullable|string'
    ]);

    TracerSection::findOrFail($id)->update($request->all());

    return redirect()
        ->route('admin.tracer-section.index')
        ->with('success','Section berhasil diperbarui');
    }
    public function destroy(TracerSection $tracer_section)
    {
        $tracer_section->delete();
        return back();
    }
}

