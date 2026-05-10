<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TracerQuestion;
use App\Models\TracerSection;
use Illuminate\Http\Request;

class TracerQuestionController extends Controller
{
    public function index(Request $request)
    {
    $sectionId = $request->section_id;

    if (!$sectionId) {
        abort(404, 'Section tidak ditemukan');
    }

    $section = TracerSection::findOrFail($sectionId);

    $questions = TracerQuestion::where('tracer_section_id', $sectionId)
                    ->orderBy('urutan')
                    ->get();

    return view('admin.tracer.question.index', compact('section','questions'));
    }
    public function create()
    {
        $sections = TracerSection::orderBy('urutan')->get();
        return view('admin.tracer.question.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tracer_section_id' => 'required',
            'pertanyaan' => 'required',
            'tipe_jawaban' => 'required',
            'urutan' => 'required|numeric'
        ]);
        TracerQuestion::create([
            'tracer_section_id' => $request->tracer_section_id,
            'kode_pertanyaan'   => $request->kode,
            'pertanyaan'        => $request->pertanyaan,
            'tipe_jawaban'      => $request->tipe_jawaban,
            'urutan'            => $request->urutan,
        ]);
        return redirect()->route('admin.tracer-question.index', [
            'section_id' => $request->tracer_section_id
        ])->with('success','Pertanyaan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $question = TracerQuestion::findOrFail($id);
        $sections = TracerSection::orderBy('urutan')->get();
    
        return view('admin.tracer.question.edit', compact('question','sections'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'tracer_section_id' => 'required',
        'pertanyaan'        => 'required',
        'tipe_jawaban'      => 'required',
        'urutan'            => 'required|numeric'
    ]);

    $question = TracerQuestion::findOrFail($id);

    $question->update([
        'tracer_section_id' => $request->tracer_section_id,
        'kode_pertanyaan'   => $request->kode,
        'pertanyaan'        => $request->pertanyaan,
        'tipe_jawaban'      => $request->tipe_jawaban,
        'urutan'            => $request->urutan,
    ]);
    return redirect()->route('admin.tracer-question.index', [
        'section_id' => $request->tracer_section_id
        ])
        ->with('success','Pertanyaan berhasil diperbarui');
    }
    public function destroy(TracerQuestion $tracer_question)
    {
        $tracer_question->delete();
        return back();
    }
}
