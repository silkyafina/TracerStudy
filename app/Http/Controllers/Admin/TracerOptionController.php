<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TracerOption;
use App\Models\TracerQuestion;
use Illuminate\Http\Request;

class TracerOptionController extends Controller
{
    public function index(Request $request)
    {
        $questionId = $request->question_id;

        $question = TracerQuestion::findOrFail($questionId);

        $options = TracerOption::where('tracer_question_id', $questionId)
            ->orderBy('urutan')
            ->get();

        return view('admin.tracer.option.index', compact(
            'options',
            'question',
            'questionId'
        ));
    }
    public function create(Request $request)
{
    $questionId = $request->question_id;
    return view('admin.tracer.option.create', compact('questionId'));
}


    public function store(Request $request)
    {
        $request->validate([
            'tracer_question_id' => 'required|exists:tracer_questions,id',
            'label' => 'required',
            'value' => 'required',
            'urutan' => 'required|numeric'
        ]);

        TracerOption::create($request->all());

        return back()->with('success','Option berhasil ditambahkan');
    }

    public function edit($id)
    {
        $option = TracerOption::findOrFail($id);

        return view('admin.tracer.option.edit', compact('option'));
    }

    public function update(Request $request, $id)
    {
        $option = TracerOption::findOrFail($id);

        $request->validate([
            'label' => 'required',
            'value' => 'required',
            'urutan' => 'required|numeric'
        ]);

        $option->update($request->all());

        return redirect()->route('admin.tracer-option.index', [
            'question_id' => $option->tracer_question_id
        ])->with('success','Option berhasil diperbarui');
    }

    public function destroy($id)
    {
        TracerOption::findOrFail($id)->delete();
        return back()->with('success','Option dihapus');
    }
}
