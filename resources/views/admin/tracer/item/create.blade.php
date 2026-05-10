@extends('admin.layouts.app')

@section('title','Tambah Item Jawaban')

@section('content')
<h4>Tambah Item Jawaban</h4>

<form method="POST" action="{{ route('admin.tracer-item.store') }}">
@csrf

<input type="hidden"
       name="tracer_question_id"
       value="{{ request('question_id') }}">

<div class="mb-3">
    <label>Label Jawaban</label>
    <input type="text"
           name="label"
           class="form-control"
           placeholder="contoh: Sangat Tinggi"
           required>
</div>

<div class="mb-3">
    <label>Nilai</label>
    <input type="number"
           name="value"
           class="form-control"
           placeholder="contoh: 5"
           required>
</div>

<div class="mb-3">
    <label>Urutan</label>
    <input type="number"
           name="urutan"
           class="form-control"
           required>
</div>

<button class="btn btn-maroon">
    <i class="bi bi-save"></i> Simpan
</button>

<a href="{{ route('admin.tracer-item.index', ['question_id'=>request('question_id')]) }}"
   class="btn btn-cream">Kembali</a>

</form>
@endsection
