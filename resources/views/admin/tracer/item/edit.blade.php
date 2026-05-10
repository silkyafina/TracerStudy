@extends('admin.layouts.app')
@section('title','Edit Item')

@section('content')

<h4 class="mb-3">
    <i class="bi bi-pencil-square"></i> Edit Item Pertanyaan
</h4>

<form method="POST"
      action="{{ route('admin.tracer-item.update', $item->id) }}">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Kode Item</label>
    <input type="text"
           name="kode_item"
           class="form-control"
           value="{{ $item->kode_item }}">
</div>

<div class="mb-3">
    <label>Label</label>
    <input type="text"
           name="label"
           class="form-control"
           value="{{ $item->label }}"
           required>
</div>

<div class="mb-3">
    <label>Urutan</label>
    <input type="number"
           name="urutan"
           class="form-control"
           value="{{ $item->urutan }}">
</div>

<button class="btn btn-primary">
    <i class="bi bi-save"></i> Update
</button>

<a href="{{ route('admin.tracer-item.index', ['question_id'=>$item->tracer_question_id]) }}"
   class="btn btn-secondary">
   Kembali
</a>

</form>
@endsection
