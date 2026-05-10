<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TracerQuestion;
use App\Models\TracerQuestionItem;
use Illuminate\Http\Request;

class TracerQuestionItemController extends Controller
{


public function index(Request $request)
{
    $questionId = $request->question_id;

    $question = TracerQuestion::with('section')
        ->findOrFail($questionId);

    $items = TracerQuestionItem::where(
        'tracer_question_id',
        $questionId
    )->orderBy('urutan')->get();

    return view('admin.tracer.item.index', [
        'items'      => $items,
        'questionId' => $questionId,
        'sectionId'  => $question->tracer_section_id,
        'question'   => $question,
    ]);
}

    public function store(Request $request)
{
    $request->validate([
        'tracer_question_id' => 'required|exists:tracer_questions,id',
        'label'              => 'required',
        'kode_item'          => 'nullable',
        'urutan'             => 'nullable|integer'
    ]);

    TracerQuestionItem::create($request->only(
        'tracer_question_id',
        'kode_item',
        'label',
        'urutan'
    ));

    return redirect()->back()
        ->with('success','Item berhasil ditambahkan');
    }

    public function edit($id)
    {
    $item = TracerQuestionItem::findOrFail($id);

    return view(
        'admin.tracer.item.edit',
        compact('item')
    );
    }

    
    public function update(Request $request, $id)
    {
    $item = TracerQuestionItem::findOrFail($id);

    $request->validate([
        'label' => 'required',
        'kode_item' => 'nullable',
        'urutan' => 'nullable|integer'
    ]);

    $item->update([
        'kode_item' => $request->kode_item,
        'label' => $request->label,
        'urutan' => $request->urutan,
    ]);

    return redirect()
        ->route('admin.tracer-item.index', [
            'question_id' => $item->tracer_question_id
        ])
        ->with('success', 'Item berhasil diperbarui');
    }
    public function destroy(TracerQuestionItem $tracer_item)
    {
        $tracer_item->delete();
        return back();
    }
}

